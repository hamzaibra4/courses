<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use App\Models\RelatedCoursesStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RelatedCoursesStatusController extends Controller
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
        if (!$user->can('List_Courses_Status')) {
            abort(403);
        }
        $status=RelatedCoursesStatus::all();
        return view('pages.courses-status.List')->with('status',$status);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user->can('Add_Courses_Status')) {
            abort(403);
        }
        $status=null;
        return view('pages.courses-status.Add')->with('status',$status);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'name'=>'required'
        ]);
        $status=new RelatedCoursesStatus();
        $status->name=$request->name;
        $status->save();
        return redirect()->route('courses-status.index');
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
        if (!$user->can('Edit_Courses_Status')) {
            abort(403);
        }
        $status=RelatedCoursesStatus::find($id);
        return view('pages.courses-status.Add')->with('status',$status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Courses_Status')) {
            abort(403);
        }
        $request->validate([
            'name'=>'required'
        ]);
        $status=RelatedCoursesStatus::find($id);
        $status->name=$request->name;
        $status->save();
        return redirect()->route('courses-status.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $user = Auth::user();
            if (!$user->can('Delete_Courses_Status')) {
                abort(403);
            }
            $obj=RelatedCoursesStatus::find($id);
            $obj->delete();
            $code = 200;
            $msg = 'The selected courses status has been successfully deleted!';
            return response()->json([
                'code' => $code,
                'msg'=>$msg
            ]);
        }

}
