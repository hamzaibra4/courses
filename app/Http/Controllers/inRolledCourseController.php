<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\inRolledCourse;
use App\Models\MultipleCoursesInRolle;
use App\Models\RelatedCoursesStatus;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class inRolledCourseController extends Controller
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
        $rolledCourse=inRolledCourse::all();
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
        $courses=Course::pluck('name','id');
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
           'amount'=>'required',
           'status_id'=>'required',
           'student_id'=>'required',
           'course_id'=>'required',
        ]);
        $obj=new inRolledCourse();
        $obj->amount=$request->amount;
        $obj->status_id=$request->status_id;
        $obj->student_id=$request->student_id;
        $obj->save();
        foreach ($request->course_id as $courseId) {
            $obj2=new MultipleCoursesInRolle();
            $obj2->in_rolled_course_id=$obj->id;
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
        $rolledCourse=inRolledCourse::find($id);
        $status=RelatedCoursesStatus::pluck('name','id');
        $courses=Course::pluck('name','id');
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
            'amount'=>'required',
            'status_id'=>'required',
            'student_id'=>'required',
            'course_id'=>'required',
        ]);
        $obj=inRolledCourse::find($id);
        $obj->amount=$request->amount;
        $obj->status_id=$request->status_id;
        $obj->student_id=$request->student_id;
        $obj->save();
        MultipleCoursesInRolle::where('in_rolled_course_id',$obj->id)->delete();
        foreach ($request->course_id as $courseId) {
            $obj2=new MultipleCoursesInRolle();
            $obj2->in_rolled_course_id=$obj->id;
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
            $obj = inRolledCourse::find($id);
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
