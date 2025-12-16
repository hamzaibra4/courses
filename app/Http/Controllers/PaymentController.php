<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Payment;
use App\Models\PaymentCourse;
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
           'amount'=>'required',
           'student_id'=>'required',
           'course_id'=>'required',
        ]);
        $payment=new Payment();
        $counter = DB::table('payments')->max('counter') + 1;
        $payment->trx_number = "TRX-" . $counter;
        $payment->counter = $counter;
        $payment->amount=$request->amount;
        $payment->date="!223";
        $payment->student_id=$request->student_id;
        $payment->save();
        foreach ($request->course_id as $courseId) {
            $obj=new PaymentCourse();
            $obj->payment_id=$payment->id;
            $obj->course_id=$courseId;
            $obj->save();
        }
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
            'amount'=>'required',
            'student_id'=>'required',
            'course_id'=>'required',
        ]);
        $payment=Payment::find($id);
        $payment->amount=$request->amount;
        $payment->date=$request->date;
        $payment->student_id=$request->student_id;
        $payment->save();
        PaymentCourse::where('payment_id',$payment->id)->delete();
        foreach ($request->course_id as $courseId) {
            $obj=new PaymentCourse();
            $obj->payment_id=$payment->id;
            $obj->course_id=$courseId;
            $obj->save();
        }
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
        $payment=Payment::find($id);
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
            ->get(['id', 'enrollment_number']);

        return response()->json([
            'code' => 200,
            'enrollment_numbers' => $enrollments,
        ]);
    }
}
