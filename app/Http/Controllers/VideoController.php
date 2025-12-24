<?php

namespace App\Http\Controllers;

use App\Models\MaterialPdf;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VideoController extends Controller
{
    public function show($id)
    {
        $video = Section::findOrFail($id);
        return view('video.view', compact('video'));
    }

    public function stream($id)
    {
        $video = Section::findOrFail($id);
        error_log("path is" . $video->video_path);
        abort_unless(auth()->check() && Storage::disk('local')->exists($video->video_path), 403);
        $path = Storage::disk('local')->path($video->video_path);
        return response()->stream(function () use ($path) {
            readfile($path);
        }, 200, [
            'Content-Type'        => 'video/mp4',
            'Content-Disposition' => 'inline',
            'Accept-Ranges'       => 'bytes',
            'Cache-Control'       => 'no-store, no-cache, must-revalidate',
            'Pragma'              => 'no-cache',
        ]);
    }
}
