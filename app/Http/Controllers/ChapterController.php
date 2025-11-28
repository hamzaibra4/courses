<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
 public function index()
{
    $chapter = Chapter::all();
    $course = Course::all();
    return view('pages.chapter.list', compact('chapter','course'));
}

    public function create()
    {
        $chapter = null;
        $course = Course::all();

        return view('pages.chapter.add', compact('chapter', 'course'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'itemindex' => 'required|integer',
        'course_id' => 'required|uuid',
    ]);

    $chapter = new Chapter();
    $chapter->id = Str::uuid();
    $chapter->name = $request->name;
    $chapter->text = $request->text;
    $chapter->course_id = $request->course_id;
    $chapter->item_index = $request->itemindex;


    $chapter->save();

    return redirect()->route('chapter.index');
}

    public function edit($id)
{
    $chapter = Chapter::findOrFail($id);
    $course = Course::all();


    return view('pages.section.add', compact('chapter','course'));
}

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'itemindex' => 'required|integer',
        'course_id' => 'required|uuid',
    ]);

    $chapter = Chapter::findOrFail($id);
    $chapter->id = Str::uuid();
    $chapter->name = $request->name;
    $chapter->text = $request->text;
    $chapter->course_id = $request->course_id;
    $chapter->item_index = $request->itemindex;


    $chapter->save();

    return redirect()->route('chapter.index');
}

    public function destroy($id)
{
    $chapter = Chapter::findOrFail($id);
    $chapter->delete();

    return redirect()->route('chapter.index');
}
}
