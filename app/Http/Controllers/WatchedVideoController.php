<?php

namespace App\Http\Controllers;

use App\Models\SectionVideo;
use App\Models\Student;
use App\Models\WatchedVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class WatchedVideoController extends Controller
{
    public function index()
    {
        $watchedvideo = WatchedVideo::all();
        return view('pages.watched-video.list', compact('watchedvideo'));
    }

    public function create()
    {
        $watchedvideo = null;
        $sectionvideo = SectionVideo::all();
        $student = Student::all();


        return view('pages.watched-video.add', compact('watchedvideo', 'student','sectionvideo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sectionvideo' => 'required|uuid|exists:section_videos,id',
            'studentid' => 'required|uuid|exists:students,id',


        ]);

        $watchedvideo = new WatchedVideo();
        $watchedvideo->id = Str::uuid()->toString();
        $watchedvideo->date = now();
        $watchedvideo->section_video_id = $request->sectionvideo;
        $watchedvideo->student_id = $request->studentid;

        $watchedvideo->save();

        return redirect()->route('watched-video.index');
    }

    public function edit($id)
    {
        $watchedvideo = WatchedVideo::findOrFail($id);
        $sectionvideo = SectionVideo::all();
        $student = Student::all();

        return view('pages.watched-video.add', compact('watchedvideo', 'student','sectionvideo'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'sectionvideo' => 'required|uuid|exists:section_videos,id',
            'studentid' => 'required|uuid|exists:students,id',
        ]);

        $watchedvideo = WatchedVideo::findOrFail($id);
        $watchedvideo->date = $request->date;
        $watchedvideo->section_video_id = $request->sectionvideo;
        $watchedvideo->student_id = $request->studentid;

        $watchedvideo->save();

        return redirect()->route('watched-video.index');
    }

    public function destroy($id)
    {
        $watchedvideo = WatchedVideo::findOrFail($id);
        $watchedvideo->delete();

        return redirect()->route('watched-video.index');
    }
}
