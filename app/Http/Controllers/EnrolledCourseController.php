<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Course;
use App\Models\EnrolledCourse;
use App\Models\MultipleCoursesEnrolled;
use App\Models\Payment;
use App\Models\RelatedCoursesStatus;
use App\Models\Student;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class EnrolledCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(GenericController $generic){
        $this->genericController = $generic;
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        if (!$user->can('List_enRolled_Course')) {
            abort(403);
        }
        $rolledCourse=EnrolledCourse::all();
        return view('pages.enrolled-courses.List')->with('rolledCourse',$rolledCourse);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user->can('Add_enRolled_Course')) {
            abort(403);
        }
        $rolledCourse=null;
        $status=RelatedCoursesStatus::pluck('name','id');
        $courses=Course::select('name','id','price')->get();
        $students = Student::all()->pluck('full_name', 'id');

        return view('pages.enrolled-courses.Add')
            ->with('rolledCourse',$rolledCourse)
            ->with('status',$status)
            ->with('courses',$courses)
            ->with('students',$students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->can('Add_enRolled_Course')) {
            abort(403);
        }
        $request->validate([
            'amount'     => 'required|numeric|min:0',
           'student_id'=>'required',
           'course_id'=>'required',
            'r_amount'   => 'nullable|numeric|lte:amount',
        ]);


        $pendingStatus = RelatedCoursesStatus::where('key','PE')->firstOrFail();
        $partiallyStatus = RelatedCoursesStatus::where('key','PP')->firstOrFail();
        $paidStatus = RelatedCoursesStatus::where('key','PA')->firstOrFail();

        $obj=new EnrolledCourse();
        $counter = DB::table('enrolled_courses')->max('counter') + 1;
        $obj->enrollment_number = "ENR-" . $counter;
        $obj->student_id=$request->student_id;
        $obj->counter = $counter;
        $obj->total_amount    = (float) $request->amount;
        $obj->received_amount = (float) ($request->r_amount ?? 0);
        $obj->remaining_amount = max(
            0,
            $obj->total_amount - $obj->received_amount
        );

        if($obj->received_amount > 0){
            $obj->status_id=$partiallyStatus->id;
        }else{
            $obj->status_id=$pendingStatus->id;
        }

        if($request->paid){
            $obj->status_id=$paidStatus->id;
            $obj->received_amount =  $obj->total_amount ;
            $obj->remaining_amount=0;
        }

        $obj->save();

        $payment=new Payment();
        $counter = DB::table('payments')->max('counter') + 1;
        $payment->trx_number = "TRX-" . $counter;
        $payment->counter = $counter;
        $payment->date=now()->toDateString();;
        $payment->student_id=$request->student_id;
        $payment->enrolled_course_id = $obj->id;
        $payment->amount=$obj->received_amount;
        $payment->save();




        foreach ($request->course_id as $courseId) {
            $obj2=new MultipleCoursesEnrolled();
            $obj2->enrolled_course_id=$obj->id;
            $obj2->course_id=$courseId;
            $obj2->save();
        }
        return redirect()->route('enrolled-course.index');
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
        if (!$user->can('Edit_enRolled_Course')) {
            abort(403);
        }
        $rolledCourse=EnrolledCourse::find($id);
        $status=RelatedCoursesStatus::pluck('name','id');
        $courses=Course::select('name','id','price')->get();
        $students = Student::all()->pluck('full_name', 'id');
        return view('pages.enrolled-courses.Add')
            ->with('rolledCourse',$rolledCourse)
            ->with('status',$status)
            ->with('courses',$courses)
            ->with('students',$students);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_enRolled_Course')) {
            abort(403);
        }
        $request->validate([
            'amount'     => 'required|numeric|min:0',
            'student_id' => 'required',
            'course_id'  => 'required',
            'r_amount'   => 'nullable|numeric|min:0|lte:amount',
        ]);

        $pendingStatus   = RelatedCoursesStatus::where('key', 'PE')->firstOrFail();
        $partiallyStatus = RelatedCoursesStatus::where('key', 'PP')->firstOrFail();
        $paidStatus      = RelatedCoursesStatus::where('key', 'PA')->firstOrFail();

        $alreadyPaid = Payment::where('enrolled_course_id',$id)->sum('amount');
        $obj=EnrolledCourse::findOrFail($id);
        $obj->student_id=$request->student_id;
        $obj->total_amount = (float) $request->amount;
        $obj->received_amount = (float) ($request->r_amount ?? 0) + (float) $alreadyPaid;
        $obj->remaining_amount = max(
            0,
            $obj->total_amount - $obj->received_amount
        );

       if ($obj->received_amount > 0) {
            $obj->status_id = $partiallyStatus->id;
        }
        else {
            $obj->status_id = $pendingStatus->id;
        }

        $obj->save();

        MultipleCoursesEnrolled::where('enrolled_course_id',$obj->id)->delete();
        foreach ($request->course_id as $courseId) {
            $obj2=new MultipleCoursesEnrolled();
            $obj2->enrolled_course_id=$obj->id;
            $obj2->course_id=$courseId;
            $obj2->save();
        }
        return redirect()->route('enrolled-course.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        {
            $user = Auth::user();
            if (!$user->can('Delete_enRolled_Course')) {
                abort(403);
            }
            $obj = EnrolledCourse::find($id);
            $obj->delete();
            $code = 200;
            $msg = 'The selected enrolled course has been successfully deleted!';
            return response()->json([
                'code' => $code,
                'msg' => $msg
            ]);
        }
    }



}
