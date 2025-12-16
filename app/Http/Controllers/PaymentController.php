<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Payment;
use App\Models\PaymentCourse;
use App\Models\RelatedCoursesStatus;
use App\Models\Student;
use App\Models\EnrolledCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        if (!$user->can('List_Payments')) {
            abort(403);
        }
        $payments=Payment::all();
        return view('pages.payment.List')->with('payments',$payments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user->can('Add_Payments')) {
            abort(403);
        }
        $students = Student::get()->pluck('full_name', 'id');
        $courses=Course::pluck('name','id');
        $payments=null;
        return view('pages.payment.Add')
            ->with('payments',$payments)
            ->with('courses',$courses)
            ->with('students',$students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->can('Add_Payments')) {
            abort(403);
        }

        $request->validate([
            'enrollment_number' => 'required',
            'student_id'        => 'required',
        ]);

        $remainingAmount = EnrolledCourse::where('student_id', $request->student_id)
            ->value('remaining_amount');

        $request->validate([
            'amount'    => ['required', 'numeric', 'lte:' . $remainingAmount],
        ]);

        $enrolledCourse = EnrolledCourse::where('student_id', $request->student_id)  ->firstOrFail();


        $payment=new Payment();
        $counter = DB::table('payments')->max('counter') + 1;
        $payment->trx_number = "TRX-" . $counter;
        $payment->counter = $counter;
        $payment->amount=$request->amount;
        $payment->date=$request->date;
        $payment->student_id=$request->student_id;
        $payment->enrolled_course_id = $enrolledCourse->id;
        $payment->save();


        $amount = (float) $request->amount;

        if ($amount > $enrolledCourse->remaining_amount) {
        abort(422, 'Amount exceeds remaining balance.');
         }

         $enrolledCourse->received_amount  += $amount;
         $enrolledCourse->remaining_amount -= $amount;
         $enrolledCourse->remaining_amount = max(0, $enrolledCourse->remaining_amount);


        $pendingStatus   = RelatedCoursesStatus::where('key', 'PE')->firstOrFail();
        $partiallyStatus = RelatedCoursesStatus::where('key', 'PP')->firstOrFail();
        $paidStatus      = RelatedCoursesStatus::where('key', 'PA')->firstOrFail();
        if($enrolledCourse->remaining_amount==0){
            $enrolledCourse->status_id = $paidStatus->id;
        }
        elseif ($enrolledCourse->received_amount > 0) {
            $enrolledCourse->status_id = $partiallyStatus->id;
        }
        else {
            $enrolledCourse->status_id = $pendingStatus->id;
        }

        $enrolledCourse->save();
        return redirect()->route('payment.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Payments')) {
            abort(403);
        }
        $students = Student::get()->pluck('full_name', 'id');
        $courses=Course::pluck('name','id');
        $payments=Payment::find($id);
        return view('pages.payment.Add')
            ->with('payments',$payments)
            ->with('courses',$courses)
            ->with('students',$students);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Payments')) {
            abort(403);
        }
        $request->validate([
            'date'=>'required',
            'amount' => 'required|numeric|min:0',
        ]);
        $payment=Payment::find($id);
        $enrolledCourse = EnrolledCourse::findOrFail($payment->enrolled_course_id);
        $oldAmount = (float) $payment->amount;
        $newAmount = (float) $request->amount;

        /**
         * STEP 1: revert old payment
         */
        $enrolledCourse->received_amount  -= $oldAmount;
        $enrolledCourse->remaining_amount += $oldAmount;


        /**
         * STEP 2: validate new amount
         */
        if ($newAmount > $enrolledCourse->remaining_amount) {
            abort(422, 'Amount exceeds remaining balance.');
        }





        /**
         * STEP 3: apply new payment
         */
        $enrolledCourse->received_amount  += $newAmount;
        $enrolledCourse->remaining_amount -= $newAmount;



        $payment->amount = $newAmount;
        $payment->date   = $request->date;
        $payment->save();


        $pendingStatus   = RelatedCoursesStatus::where('key', 'PE')->firstOrFail();
        $partiallyStatus = RelatedCoursesStatus::where('key', 'PP')->firstOrFail();
        $paidStatus      = RelatedCoursesStatus::where('key', 'PA')->firstOrFail();
        if($enrolledCourse->remaining_amount==0){
            $enrolledCourse->status_id = $paidStatus->id;
        }
        elseif ($enrolledCourse->received_amount > 0) {
            $enrolledCourse->status_id = $partiallyStatus->id;
        }
        else {
            $enrolledCourse->status_id = $pendingStatus->id;
        }
        $enrolledCourse->save();

        return redirect()->route('payment.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        if (!$user->can('Delete_Payments')) {
            abort(403);
        }
        $payment=Payment::findOrFail($id);
        $enrolledCourse = EnrolledCourse::findOrFail($payment->enrolled_course_id);
        $amount = (float) $payment->amount;

        /**
         * STEP 1: revert payment effect
         */
        $enrolledCourse->received_amount  -= $amount;
        $enrolledCourse->remaining_amount += $amount;

        // safety
        $enrolledCourse->received_amount  = max(0, $enrolledCourse->received_amount);
        $enrolledCourse->remaining_amount = min(
            $enrolledCourse->total_amount,
            $enrolledCourse->remaining_amount
        );

        $pendingStatus   = RelatedCoursesStatus::where('key', 'PE')->firstOrFail();
        $partiallyStatus = RelatedCoursesStatus::where('key', 'PP')->firstOrFail();
        $paidStatus      = RelatedCoursesStatus::where('key', 'PA')->firstOrFail();
        if($enrolledCourse->remaining_amount==0){
            $enrolledCourse->status_id = $paidStatus->id;
        }
        elseif ($enrolledCourse->received_amount > 0) {
            $enrolledCourse->status_id = $partiallyStatus->id;
        }
        else {
            $enrolledCourse->status_id = $pendingStatus->id;
        }
        $enrolledCourse->save();


        $payment->delete();
        $code = 200;
        $msg = 'The selected payment has been successfully deleted!';
        return response()->json([
            'code' => $code,
            'msg'=>$msg
        ]);
    }

    /**
     * Return enrollment numbers for a given student (AJAX).
     */
    public function getEnrollmentStatus(Request $request)
    {
        $user = Auth::user();
        if (!$user->can('Add_Payments') && !$user->can('Edit_Payments')) {
            abort(403);
        }

        $request->validate([
            'student_id' => 'required|uuid',
        ]);

        $enrollments = EnrolledCourse::where('student_id', $request->student_id)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'enrollment_number','remaining_amount']);

        return response()->json([
            'code' => 200,
            'enrollment_numbers' => $enrollments,
        ]);
    }
}
