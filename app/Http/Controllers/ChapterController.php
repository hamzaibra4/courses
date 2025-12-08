<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function __construct(GenericController $generic){
        $this->genericController = $generic;
        $this->middleware('auth');
    }

    public function index()
    {
    $user = Auth::user();
    if (!$user->can('List_Chapter')) {
        abort(403);
    }
    $chapter = Chapter::all();
    return view('pages.chapter.list', compact('chapter'));
  }

    public function create()
    {
        $user = Auth::user();
        if (!$user->can('Add_Chapter')) {
            abort(403);
        }
        $chapter = null;
        $courses = Course::pluck('name','id');

        return view('pages.chapter.add', compact('chapter', 'courses'));
    }

    public function store(Request $request)
{
    $user = Auth::user();
    if (!$user->can('Add_Chapter')) {
        abort(403);
    }
    $request->validate([
        'name' => 'required|string|max:255',
        'itemindex' => 'required|integer',
        'course_id' => 'required',
    ]);

    $chapter = new Chapter();
    $chapter->name = $request->name;
    $chapter->text = $request->text;
    $chapter->course_id = $request->course_id;
    $chapter->item_index = $request->itemindex;
    $chapter->save();
    return redirect()->route('chapter.index');
}

    public function edit($id)
     {
         $user = Auth::user();
         if (!$user->can('Edit_Chapter')) {
             abort(403);
         }
         $chapter = Chapter::findOrFail($id);
         $courses = Course::pluck('name','id');
    return view('pages.chapter.add', compact('chapter','courses'));
     }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Course')) {
            abort(403);
        }
        $request->validate([
        'name' => 'required|string|max:255',
        'itemindex' => 'required|integer',
        'course_id' => 'required|uuid',
    ]);

    $chapter = Chapter::findOrFail($id);
    $chapter->name = $request->name;
    $chapter->text = $request->text;
    $chapter->course_id = $request->course_id;
    $chapter->item_index = $request->itemindex;
    $chapter->save();
    return redirect()->route('chapter.index');
   }

    public function destroy($id)
    {
        {
            $user = Auth::user();
            if (!$user->can('Delete_Chapter')) {
                abort(403);
            }
            $course=Chapter::find($id);
            $course->delete();
            $code = 200;
            $msg = 'The selected chapter has been successfully deleted!';
            return response()->json([
                'code' => $code,
                'msg'=>$msg
            ]);
        }
    }
}
