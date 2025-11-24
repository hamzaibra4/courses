<?php

namespace App\Http\Controllers;

use App\Models\StudentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentTypeController extends Controller
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
        if (!$user->can('List_Students_Type')) {
            abort(403);
        }
        $types=StudentType::all();
        return view('pages.student-type.List')->with('types',$types);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user->can('Add_Students_Type')) {
            abort(403);
        }
        $types=null;
        return view('pages.student-type.Add')->with('types',$types);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->can('Add_Students_Type')) {
            abort(403);
        }
        $request->validate([
           'name'=>'required',
           'email_extension'=>'required',
        ]);
        $types=new StudentType();
        $types->name=$request->name;
        $types->email_extension=$request->email_extension;
        $types->save();
        return redirect()->route('student-type.index');
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
        if (!$user->can('Edit_Students_Type')) {
            abort(403);
        }
        $types=StudentType::find($id);
        return view('pages.student-type.Add')->with('types',$types);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Students_Type')) {
            abort(403);
        }
        $request->validate([
            'name'=>'required',
            'email_extension'=>'required',
        ]);
        $types=StudentType::find($id);
        $types->name=$request->name;
        $types->email_extension=$request->email_extension;
        $types->save();
        return redirect()->route('student-type.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)

        {
            $user = Auth::user();
            if (!$user->can('Delete_Students_Type')) {
                abort(403);
            }
            $types=StudentType::find($id);
            $types->delete();
            $code = 200;
            $msg = 'The selected student type has been successfully deleted!';
            return response()->json([
                'code' => $code,
                'msg'=>$msg
            ]);
        }

}
