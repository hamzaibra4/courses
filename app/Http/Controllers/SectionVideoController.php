<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\SectionVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class SectionVideoController extends Controller
{
    public function index()
    {
        $sectionvideo = SectionVideo::all();
        return view('pages.section-video.list', compact('sectionvideo'));
    }

    public function create()
    {
        $sectionvideo = null;
        $section = Section::all();

        return view('pages.section-video.add', compact('sectionvideo', 'section'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'itemindex' => 'required|integer',
            'sectionid' => 'required|uuid|exists:sections,id',
        ]);

        $sectionvideo = new SectionVideo();
        $sectionvideo->id = Str::uuid()->toString();
        $sectionvideo->path = $request->path;
        $sectionvideo->item_index = $request->itemindex;
        $sectionvideo->section_id = $request->sectionid;

        $sectionvideo->save();

        return redirect()->route('section-video.index');
    }

    public function edit($id)
    {
        $sectionvideo = SectionVideo::findOrFail($id);
        $section = Section::all();

        return view('pages.section-video.add', compact('section', 'sectionvideo'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'itemindex' => 'required|integer',
            'sectionid' => 'required|uuid|exists:sections,id',
        ]);

        $sectionvideo = SectionVideo::findOrFail($id);
        $sectionvideo->path = $request->path;
        $sectionvideo->item_index = $request->itemindex;
        $sectionvideo->section_id = $request->sectionid;

        $sectionvideo->save();
        return redirect()->route('section-video.index');
    }

    public function destroy($id)
    {
        $sectionvideo = SectionVideo::findOrFail($id);
        $sectionvideo->delete();

        return redirect()->route('section-video.index');
    }
}
