<?php

namespace App\Http\Controllers;

use App\Models\EnrolledCourse;
use App\Models\MultipleCoursesEnrolled;
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

    public function editAccount()
    {
        return view('student.account.edit');
    }

    public function updatePassword(){
        return view('student.account.password');
    }

}
