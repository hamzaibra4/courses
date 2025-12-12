<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\CourseDetails;
use App\Models\SeminarDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CourseController extends Controller
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
        if (!$user->can('List_Course')) {
            abort(403);
        }
        $course = Course::all();
        return view('pages.course.list', compact('course'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user->can('Add_Course')) {
            abort(403);
        }
        $course = null;
        return view('pages.course.add', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->can('Add_Course')) {
            abort(403);
        }
         $request->validate([
            'name' => 'required',
            'itemindex' => 'required|integer',
            'image' => 'required',
             'nb_of_hours'=>'required',
             'brief_description'=>'required',
        ]);

        $course = new Course();
        $course->name = $request->name;
        $course->price = $request->price;
        $course->description = $request->description;
        $course->item_index = $request->itemindex;
        $course->is_featured = $request->feature;
        $course->nb_of_hours = $request->nb_of_hours;
        $course->brief_description = $request->brief_description;
        $course->created_by=Auth::user()->name;
        $imageName = 'image';
        $path = $this->genericController->uploadImage($request, $imageName);
        if ($path) {
            $course->image = $path;
        }
        $course->save();
        $titleDetails = $request->input('title_details', []);
        foreach ($titleDetails as $title) {
            $detail = new CourseDetails();
            $detail->course_id = $course->id;
            $detail->title = trim($title);
            $detail->save();
        }
        return redirect()->route('course.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Course')) {
            abort(403);
        }
        $course = Course::findOrFail($id);
        return view('pages.course.add', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Course')) {
            abort(403);
        }
           $request->validate([
            'name' => 'required',
            'itemindex' => 'required',
               'nb_of_hours'=>'required',
               'brief_description'=>'required',
        ]);

        $course = Course::findOrFail($id);
        $course->name = $request->name;
        $course->price = $request->price;
        $course->description = $request->description;
        $course->nb_of_hours = $request->nb_of_hours;
        $course->brief_description = $request->brief_description;
        $course->item_index = $request->itemindex;
        $course->is_featured = $request->feature;
        $course->updated_by=Auth::user()->name;


        $imageName = 'image';
        $path = $this->genericController->uploadImage($request, $imageName);
        if ($path) {
            $course->image = $path;
        }
        $course->save();
        $deleted = CourseDetails::where('course_id', $course->id)->delete();
        $titleDetails = $request->input('title_details', []);
        foreach ($titleDetails as $title) {
            $detail = new CourseDetails();
            $detail->course_id = $course->id;
            $detail->title = trim($title);
            $detail->save();
        }

        return redirect()->route('course.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->can('Delete_Course')) {
            abort(403);
        }
        $course=Course::find($id);
        $course->delete();
        $code = 200;
        $msg = 'The selected course has been successfully deleted!';
        return response()->json([
            'code' => $code,
            'msg'=>$msg
        ]);
    }


}
