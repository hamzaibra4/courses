<?php

namespace App\Http\Controllers;

use App\Models\FavoriteVideo;
use App\Models\SectionVideo;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class FavoriteVideoController extends Controller
{
    public function index()
    {
        $favoritevideo = FavoriteVideo::all();
        return view('pages.favorite-video.list', compact('favoritevideo'));
    }

    public function create()
    {
        return view('pages.favorite-video.add', [
            'favoritevideo' => null,
            'student' => Student::all(),
            'sectionvideo' => SectionVideo::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sectionid' => 'required|uuid|exists:section_videos,id',
            'studentid' => 'required|uuid|exists:students,id',
        ]);

        $favoritevideo = new FavoriteVideo();
        $favoritevideo->id = Str::uuid()->toString();
        $favoritevideo->section_video_id = $request->sectionid;
        $favoritevideo->student_id = $request->studentid;
        $favoritevideo->save();

        return redirect()->route('favorite-video.index');
    }

    public function edit($id)
    {
        return view('pages.favorite-video.add', [
            'favoritevideo' => FavoriteVideo::findOrFail($id),
            'student' => Student::all(),
            'sectionvideo' => SectionVideo::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'sectionid' => 'required|uuid|exists:section_videos,id',
            'studentid' => 'required|uuid|exists:students,id',
        ]);

        $favoritevideo = FavoriteVideo::findOrFail($id);
        $favoritevideo->section_video_id = $request->sectionid;
        $favoritevideo->student_id = $request->studentid;
        $favoritevideo->save();

        return redirect()->route('favorite-video.index');
    }

    public function destroy($id)
    {
        $favoritevideo = FavoriteVideo::findOrFail($id);
        $favoritevideo->delete();

        return redirect()->route('favorite-video.index');
    }
}
