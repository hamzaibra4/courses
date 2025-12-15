<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Material;
use App\Models\MaterialPdf;
use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
        $sections = Section::pluck('title','id');
        return view('pages.material.add', compact('material', 'chapters','sections'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->can('Add_Material')) {
            abort(403);
        }
        $request->validate([
            'item_index' => 'required',
            'path' => 'required|array|min:1',
            'path.*' => 'required|mimes:pdf|max:10240',
        ]);
        $material = new Material();
        $material->item_index = $request->item_index;
        if($request->chapter_id){
            $material->chapter_id = $request->chapter_id;

        }

        if($request->section_id){
            $material->section_id = $request->section_id;

        }

        $material->save();
        $pdfName = 'path';
        $pdfs  = $this->genericController->uploadPdfsWithNames($request, $pdfName);
        foreach ($pdfs as $index => $pdf) {
            $obj = new MaterialPdf();
            $obj->material_id = $material->id;
            $obj->name = $pdf['name'];
            $obj->path = $pdf['path'];
            $obj->order = $index;
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
        $sections = Section::pluck('title','id');
        return view('pages.material.add', compact('material', 'chapters','sections'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Material')) {
            abort(403);
        }

        $material = Material::findOrFail($id);
        $existingPdfCount = MaterialPdf::where('material_id', $material->id)->count();
        $validationRules = [
            'item_index' => 'required'
        ];
        if ($existingPdfCount == 0) {
            $validationRules['path'] = 'required|array|min:1';
            $validationRules['path.*'] = 'required|mimes:pdf|max:10240';
        } else {

            if ($request->hasFile('path')) {
                $validationRules['path.*'] = 'mimes:pdf|max:10240';
            }
        }

        $request->validate($validationRules);

        $material->item_index = $request->item_index;
        if($request->chapter_id){
            $material->chapter_id = $request->chapter_id;

        }

        if($request->section_id){
            $material->section_id = $request->section_id;

        }
        $material->save();
        if ($request->hasFile('path')) {
            $pdfName = 'path';
            $pdfs = $this->genericController->uploadPdfsWithNames($request, $pdfName);

            if (!empty($pdfs)) {
                $maxOrder = MaterialPdf::where('material_id', $material->id)->max('order');
                $startOrder = ($maxOrder !== null) ? $maxOrder + 1 : 0;

                foreach ($pdfs as $index => $pdf) {
                    $obj = new MaterialPdf();
                    $obj->material_id = $material->id;
                    $obj->name = $pdf['name'];
                    $obj->path = $pdf['path'];
                    $obj->order = $startOrder + $index;
                    $obj->save();
                }
            }
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

    public function deletePdf($id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Material')) {
            abort(403);
        }

        $pdf = MaterialPdf::findOrFail($id);
        if ($pdf->path) {
            $relativePath = str_replace('storage/public/', 'public/', $pdf->path);
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            } else {
                $storagePath = storage_path('app/' . str_replace('storage/', '', $pdf->path));
                if (File::exists($storagePath)) {
                    File::delete($storagePath);
                } else {
                    $publicPath = public_path($pdf->path);
                    if (File::exists($publicPath)) {
                        File::delete($publicPath);
                    }
                }
            }
        }
        $pdf->delete();

        $code = 200;
        $msg = 'The PDF has been successfully deleted!';
        return response()->json([
            'code' => $code,
            'msg' => $msg
        ]);
    }
}
