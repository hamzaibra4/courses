<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\EnrolledCourse;
use App\Models\MultipleCoursesEnrolled;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function myCourses()
    {
        $studentId = Auth::user()->getStudent->id;
        if (!$studentId) {
            abort(403);
        }
        $courses_id = EnrolledCourse::where('student_id', $studentId)->pluck('id');;
        $courses = MultipleCoursesEnrolled::whereIn('enrolled_course_id',$courses_id)->paginate(10);
        return view('student.courses.list', compact('courses'));
    }

    public function viewCourse($id)
    {
        $course = Course::findOrFail($id);
        return view('student.courses.view', compact('course'));

    }

    public function viewLesson($id)
    {
        $lesson = Section::findOrFail($id);
        return view('student.courses.details', compact('lesson'));
    }



    public function editAccount()
    {
        return view('student.account.edit');
    }

    public function updatePassword(){
        return view('student.account.password');
    }

}
