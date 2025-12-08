<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\SectionVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class SectionVideoController extends Controller
{

    private $genericController;
    public function __construct(GenericController $generic){
        $this->middleware('auth');
        $this->genericController = $generic;
    }
    public function index()
    {
        $user = Auth::user();
        if (!$user->can('List_Section_Video')) {
            abort(403);
        }
        $sectionvideo = SectionVideo::all();
        return view('pages.section-video.list', compact('sectionvideo'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->can('Add_Section_Video')) {
            abort(403);
        }
        $sectionvideo = null;
        $sections = Section::pluck('title','id');
        return view('pages.section-video.add', compact('sectionvideo', 'sections'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->can('Add_Section_Video')) {
            abort(403);
        }
          $request->validate([
            'item_index' => 'required',
            'section_id' => 'required',
            'path' => 'required',
        ]);

        $sectionvideo = new SectionVideo();
        $sectionvideo->item_index = $request->item_index;
        $sectionvideo->section_id = $request->section_id;
        $videoName = 'path';
        $path = $this->genericController->uploadVideo($request, $videoName);
        if ($path) {
            $sectionvideo->path = $path;
        }
        $sectionvideo->save();

        return redirect()->route('section-video.index');
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Section_Video')) {
            abort(403);
        }
        $sectionvideo = SectionVideo::findOrFail($id);
        $sections = Section::pluck('title','id');

        return view('pages.section-video.add', compact('sections', 'sectionvideo'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Section_Video')) {
            abort(403);
        }
         $request->validate([
            'item_index' => 'required',
            'section_id' => 'required',
        ]);

        $sectionvideo = SectionVideo::findOrFail($id);
        $sectionvideo->item_index = $request->item_index;
        $sectionvideo->section_id = $request->section_id;
        $videoName = 'path';
        $path = $this->genericController->uploadVideo($request, $videoName);
        if ($path) {
            $sectionvideo->path = $path;
        }

        $sectionvideo->save();
        return redirect()->route('section-video.index');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->can('Delete_Section_Video')) {
            abort(403);
        }
        $section=SectionVideo::find($id);
        $section->delete();
        $code = 200;
        $msg = 'The selected section video been successfully deleted!';
        return response()->json([
            'code' => $code,
            'msg'=>$msg
        ]);
    }
}
