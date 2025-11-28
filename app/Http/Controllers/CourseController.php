<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $course = Course::all();
        return view('pages.course.list', compact('course'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $course = null;
        return view('pages.course.add', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'itemindex' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'feature' => 'required|boolean',
        ]);

        $course = new Course();
        $course->name = $request->name;
        $course->price = $request->price;
        $course->description = $request->description;
        $course->item_index = $request->itemindex;
        $course->is_featured = $request->feature;

        if ($request->hasFile('image')) {
            $fileName = $this->uploadImage($request->file('image'));
            $course->image = $fileName;
        }

        $course->save();

        return redirect()->route('course.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $course = Course::findOrFail($id);
        return view('pages.course.add', compact('course'));    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'itemindex' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'feature' => 'required|boolean',
        ]);

        $course = Course::findOrFail($id);
        $course->name = $request->name;
        $course->price = $request->price;
        $course->description = $request->description;
        $course->item_index = $request->itemindex;
        $course->is_featured = $request->feature;

        if ($request->hasFile('image')) {
            $fileName = $this->uploadImage($request->file('image'));
            $course->image = $fileName;
        }

        $course->save();

        return redirect()->route('course.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('course.index');
    }

    private function uploadImage($image)
    {
        $name = Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME));
        $extension = $image->getClientOriginalExtension();
        $fileNameToStore = $name . '_' . time() . '.' . $extension;

        $image->storeAs('about-us', $fileNameToStore, 'public');

        return 'storage/about-us/' . $fileNameToStore;
    }

}
