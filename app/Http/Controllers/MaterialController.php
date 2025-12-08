<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Material;
use App\Models\MaterialPdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class MaterialController extends Controller
{
    public function __construct(GenericController $generic){
        $this->genericController = $generic;
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        if (!$user->can('List_Material')) {
            abort(403);
        }
        $material = Material::all();
        return view('pages.material.list', compact('material'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->can('Add_Material')) {
            abort(403);
        }
        $material = null;
        $chapters = Chapter::pluck('name','id');
        return view('pages.material.add', compact('material', 'chapters'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->can('Add_Material')) {
            abort(403);
        }
        $request->validate([
            'item_index' => 'required',
            'chapter_id' => 'required',
            'path' => 'required|array|min:1',
            'path.*' => 'required|mimes:pdf|max:10240',
        ]);
        $material = new Material();
        $material->item_index = $request->item_index;
        $material->chapter_id = $request->chapter_id;
        $material->save();
        $pdfName = 'path';
        $paths = $this->genericController->uploadPdfs($request, $pdfName);

        foreach ($paths as $index => $path) {
            $obj=new MaterialPdf();
            $obj->material_id=$material->id;
            $obj->path=$path; // Changed from $paths to $path
            $obj->order=$index;
            $obj->save();
        }

        return redirect()->route('material.index');
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Material')) {
            abort(403);
        }
        $material = Material::findOrFail($id);
        $chapters = Chapter::pluck('name','id');
        return view('pages.material.add', compact('material', 'chapters'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Material')) {
            abort(403);
        }
        $request->validate([
            'item_index' => 'required',
            'chapter_id' => 'required',
        ]);

        $material = Material::findOrFail($id);
        $material->item_index = $request->item_index;
        $material->chapter_id = $request->chapter_id;
        $material->save();
        MaterialPdf::where('material_id',$material->id)->delete();
        $pdfName = 'path';
        $paths = $this->genericController->uploadPdfs($request, $pdfName);

        foreach ($paths as $index => $path) {
            $obj=new MaterialPdf();
            $obj->material_id=$material->id;
            $obj->path=$path;
            $obj->order=$index;
            $obj->save();
        }
        return redirect()->route('material.index');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->can('Delete_Material')) {
            abort(403);
        }
        $material=Material::find($id);
        $material->delete();
        $code = 200;
        $msg = 'The selected material has been successfully deleted!';
        return response()->json([
            'code' => $code,
            'msg'=>$msg
        ]);
    }
}
