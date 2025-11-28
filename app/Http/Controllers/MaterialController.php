<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class MaterialController extends Controller
{
    public function index()
    {
        $material = Material::all();
        return view('pages.material.list', compact('material'));
    }

    public function create()
    {
        $material = null;
        $course = Course::all();

        return view('pages.material.add', compact('material', 'course'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'itemindex' => 'required|integer',
            'courseid' => 'required|uuid|exists:courses,id',
        ]);

        $material = new Material();
        $material->id = Str::uuid()->toString();
        $material->path = $request->path;
        $material->item_index = $request->itemindex;
        $material->course_id = $request->courseid;

        $material->save();

        return redirect()->route('material.index');
    }

    public function edit($id)
    {
        $material = Material::findOrFail($id);
        $course = Course::all();
        return view('pages.material.add', compact('material', 'course'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'itemindex' => 'required|integer',
            'courseid' => 'required|uuid|exists:courses,id',
        ]);

        $material = Material::findOrFail($id);
        $material->path = $request->path;
        $material->item_index = $request->itemindex;
        $material->course_id = $request->courseid;

        $material->save();
        $material->save();
        return redirect()->route('material.index');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->route('material.index');
    }
}
