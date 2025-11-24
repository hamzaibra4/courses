<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        if (!$user->can('List_Custom_Field')) {
            abort(403);
        }
        $obj=CustomField::all();
        return view('pages.custom-field.List')->with('objs',$obj);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user->can('Add_Custom_Field')) {
            abort(403);
        }
        $students = Student::get()->pluck('full_name', 'id');
        $obj=null;
        return view('pages.custom-field.Add')->with('obj',$obj)->with('students',$students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->can('Add_Custom_Field')) {
            abort(403);
        }
        $request->validate([
           'name'=>'required',
           'value'=>'required',
           'student_id'=>'required'
        ]);
        $obj=new CustomField();
        $obj->name=$request->name;
        $obj->value=$request->value;
        $obj->student_id=$request->student_id;
        $obj->save();
        return redirect()->route('custom-field.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Custom_Field')) {
            abort(403);
        }
        $students = Student::get()->pluck('full_name', 'id');
        $obj=CustomField::find($id);
        return view('pages.custom-field.Add')->with('obj',$obj)->with('students',$students);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Custom_Field')) {
            abort(403);
        }
        $request->validate([
            'name'=>'required',
            'value'=>'required',
            'student_id'=>'required'
        ]);
        $obj= CustomField::find($id);
        $obj->name=$request->name;
        $obj->value=$request->value;
        $obj->student_id=$request->student_id;
        $obj->save();
        return redirect()->route('custom-field.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)

        {
            $user = Auth::user();
            if (!$user->can('Delete_Custom_Field')) {
                abort(403);
            }
            $obj=CustomField::find($id);
            $obj->delete();
            $code = 200;
            $msg = 'The selected custom field has been successfully deleted!';
            return response()->json([
                'code' => $code,
                'msg'=>$msg
            ]);
        }

}
