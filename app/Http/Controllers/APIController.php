<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Http\Resources\DocumentResource;
use App\Http\Resources\HomeResource;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\LessonResource;
use App\Http\Resources\LoginResource;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\PersonResource;
use App\Http\Resources\ReceiptResource;
use App\Http\Resources\StudentResource;
use App\Models\Company;
use App\Models\Course;
use App\Models\EnrolledCourse;
use App\Models\MaterialPdf;
use App\Models\MultipleCoursesEnrolled;
use App\Models\Payment;
use App\Models\Section;
use App\Models\User;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
class APIController extends Controller
{
    use APIResponse;

    /**
     * Login API
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if($validator->fails()){
                $errors = $validator->errors()->all();
                return $this->sendError(implode(', ', $errors));
            }
            $user = User::where('email', $request->email)->first();
            if (! $user || ! Hash::check($request->password, $user->password)) {
                return $this->sendError(
                    'Could not find an account matching these credentials.',
                    Response::HTTP_UNAUTHORIZED
                );
            }
            if (! $user->getStudent?->is_active) {
                return $this->sendError(
                    'Your account is currently inactive. Please contact support for assistance.',
                    Response::HTTP_UNAUTHORIZED
                );
            }
            if ($user->getType?->key !== "S") {
                return $this->sendError(
                    'You do not have the necessary privileges to perform this action.',
                    Response::HTTP_UNAUTHORIZED
                );
            }

            $data = new LoginResource([
                'token' =>$user->createToken('MyApp')->plainTextToken,
                'name' => $user->name ?? 'Joe Doe',
            ]);

            return $this->sendResponse($data, "Success");
        }catch (\Exception $e){
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            $this->generalError();
        }

    }

    /**
     * Logout API
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return $this->sendResponse(null, 'Logged out successfully.');
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            $this->generalError();
        }
    }

    /**
     * Get User Information API
     *
     * @return \Illuminate\Http\Response
     */
    public function getInformation(Request $request){
        try {
            $user = $request->user();
            if($user){
                $customer = $user->getStudent;
                if($customer){
                    $data = new StudentResource($customer);
                    return $this->sendResponse($data,"User information was successfully retrieved",Response::HTTP_OK);
                }else{
                    return $this->sendError('Missing customer information. Please contact support for assistance. ', Response::HTTP_INTERNAL_SERVER_ERROR);
                }
                }

        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->generalError();
        }

    }


    /**
     * Get User Invoices API
     *
     * @return \Illuminate\Http\Response
     */
    public function getInvoices(Request $request){
        try {
            $user = $request->user();
            $data = EnrolledCourse::where('student_id', $user->getStudent->id)->orderBy('counter','desc')->get();
            $invoices = InvoiceResource::collection($data);
            return $this->sendResponse($invoices,"User invoices was successfully retrieved",Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->generalError();
        }

    }


    /**
     * Get Invoice by id API
     *
     * @return \Illuminate\Http\Response
     */
    public function getInvoiceById(Request $request, $id){
        try {
            $invoice = EnrolledCourse::find($id);
            if($invoice){
                $data = new InvoiceResource($invoice);
                return $this->sendResponse($data,"Invoice was successfully retrieved",Response::HTTP_OK);

            }else{
                return $this->sendError('Missing invoice information or wrong id. Please contact support for assistance. ', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->generalError();
        }

    }



    /**
     * Download Invoice by id API
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadInvoiceById(Request $request, $id){
        try {
            $invoice = EnrolledCourse::find($id);
            if($invoice){
                $company = Company::firstOrFail();
                $pdf = Pdf::loadView('pages.downloads.receipt', [
                    'data' => $invoice,
                    'company' => $company,
                    'download'=>true
                ]);

                return response()->streamDownload(
                    fn () => print($pdf->output()),
                    $invoice->enrollment_number . '.pdf',
                    [
                        'Content-Type' => 'application/pdf',
                    ]
                );

            }else{
                return $this->sendError('Missing invoice information or wrong id. Please contact support for assistance. ', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->generalError();
        }

    }


    /**
     * Get User Receipts API
     *
     * @return \Illuminate\Http\Response
     */
    public function getReceipts(Request $request){
        try {
            $user = $request->user();
            $data = Payment::where('student_id', $user->getStudent->id)->orderBy('counter','desc')->get();
            $invoices = ReceiptResource::collection($data);
            return $this->sendResponse($invoices,"User receipts was successfully retrieved",Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->generalError();
        }

    }


    /**
     * Get Receipt by id API
     *
     * @return \Illuminate\Http\Response
     */
    public function getReceiptById(Request $request, $id){
        try {
            $payment = Payment::find($id);
            if($payment){
                $data = new ReceiptResource($payment);
                return $this->sendResponse($data,"Receipt was successfully retrieved",Response::HTTP_OK);
            }else{
                return $this->sendError('Missing Receipt information or wrong id. Please contact support for assistance. ', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->generalError();
        }

    }



    /**
     * Download Receipt by id API
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadReceiptById(Request $request, $id){
        try {
            $invoice = Payment::find($id);
            if($invoice){

                $company  =Company::firstOrFail();
                $pdf = Pdf::loadView('pages.downloads.payment', [
                    'data' => $invoice,
                    'company' => $company,
                    'download'=>true
                ]);

                return response()->streamDownload(
                    fn () => print($pdf->output()),
                    $invoice->trx_number . '.pdf',
                    [
                        'Content-Type' => 'application/pdf',
                    ]
                );

            }else{
                return $this->sendError('Missing receipt information or wrong id. Please contact support for assistance. ', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->generalError();
        }

    }


    /**
     * Home API
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
        try{
            $user = $request->user();
            $courses_id = EnrolledCourse::where('student_id', $user->getStudent->id)->pluck('id');;
            $courses = MultipleCoursesEnrolled::whereIn('enrolled_course_id',$courses_id)->paginate(10);
            $company  =Company::firstOrFail();
            $data = new HomeResource((object) ['courses' => $courses, 'company'=>$company]);
            return $this->sendResponse($data,"Home data was successfully retrieved",Response::HTTP_OK);
        }catch (\Exception $e){
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            $this->generalError();
        }

    }


    /**
     * Course Details API
     * @return \Illuminate\Http\Response
     */
    public function getCourseDetails(Request $request, $id)
    {
        try{
            $data= Course::find($id);
            if($data){
                $data = new CourseResource($data);
                return $this->sendResponse($data,"Course data was successfully retrieved",Response::HTTP_OK);
            }else{
                return $this->sendError('Missing course information or wrong id. Please contact support for assistance. ', Response::HTTP_INTERNAL_SERVER_ERROR);

            }
        }catch (\Exception $e){
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            $this->generalError();
        }

    }


    /**
     * Get Lesson by id API
     *
     * @return \Illuminate\Http\Response
     */
    public function getLessonById(Request $request, $id){
        try {
            $row = Section::find($id);
            if($row){
                $data = new LessonResource($row);
                return $this->sendResponse($data,"Lesson was successfully retrieved",Response::HTTP_OK);
            }else{
                return $this->sendError('Missing Lesson information or wrong id. Please contact support for assistance. ', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->generalError();
        }

    }

    /**
     * Get Material by id API
     *
     * @return \Illuminate\Http\Response
     */
    public function getMaterialById(Request $request, $id){
        try {
            $row = MaterialPdf::find($id);
            if($row){
                $data = new DocumentResource($row);
                return $this->sendResponse($data,"Document was successfully retrieved",Response::HTTP_OK);
            }else{
                return $this->sendError('Missing Material information or wrong id. Please contact support for assistance. ', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->generalError();
        }

    }


}
