<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        return view('pages.section.list', compact('sections'));
    }

    public function create()
    {
        $section = null;
        $chapters = Chapter::all();

        return view('pages.section.add', compact('section', 'chapters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'itemindex' => 'required|integer',
            'chapterid' => 'required|uuid|exists:chapters,id',
        ]);

        $section = new Section();
        $section->id = Str::uuid()->toString();
        $section->title = $request->title;
        $section->document = $request->document;
        $section->item_index = $request->itemindex;
        $section->chapter_id = $request->chapterid;

        $section->save();

        return redirect()->route('section.index');
    }

    public function edit($id)
    {
        $section = Section::findOrFail($id);
        $chapters = Chapter::all();

        return view('pages.section.add', compact('section', 'chapters'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'itemindex' => 'required|integer',
            'chapterid' => 'required|uuid|exists:chapters,id',
        ]);

        $section = Section::findOrFail($id);
        $section->title = $request->title;
        $section->document = $request->document;
        $section->item_index = $request->itemindex;
        $section->chapter_id = $request->chapterid;

        $section->save();

        return redirect()->route('section.index');
    }

    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();

        return redirect()->route('section.index');
    }
}
