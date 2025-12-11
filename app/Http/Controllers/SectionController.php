<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    public function __construct(GenericController $generic){
        $this->genericController = $generic;
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        if (!$user->can('List_Section')) {
            abort(403);
        }
        $sections = Section::all();
        return view('pages.section.list', compact('sections'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->can('Add_Section')) {
            abort(403);
        }
        $section = null;
        $chapters = Chapter::pluck('name','id');

        return view('pages.section.add', compact('section', 'chapters'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->can('Add_Section')) {
            abort(403);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'item_index' => 'required',
            'chapter_id' => 'required',
        ]);

        $section = new Section();
        $section->title = $request->title;
        $section->description = $request->description;
        $section->item_index = $request->item_index;
        $section->chapter_id = $request->chapter_id;
        $section->save();
        return redirect()->route('section.index');
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Section')) {
            abort(403);
        }
        $section = Section::findOrFail($id);
        $chapters = Chapter::pluck('name','id');
        return view('pages.section.add', compact('section', 'chapters'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Section')) {
            abort(403);
        }
         $request->validate([
            'title' => 'required|string|max:255',
            'item_index' => 'required|integer',
            'chapter_id' => 'required',
        ]);

        $section = Section::findOrFail($id);
        $section->title = $request->title;
        $section->description = $request->description;
        $section->item_index = $request->item_index;
        $section->chapter_id = $request->chapter_id;
        $section->save();
        return redirect()->route('section.index');
    }

    public function destroy($id)
    {
        {
            $user = Auth::user();
            if (!$user->can('Delete_Section')) {
                abort(403);
            }
            $section=Section::find($id);
            $section->delete();
            $code = 200;
            $msg = 'The selected section been successfully deleted!';
            return response()->json([
                'code' => $code,
                'msg'=>$msg
            ]);
        }
    }
}
