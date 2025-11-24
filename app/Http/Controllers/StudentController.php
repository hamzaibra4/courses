<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentType;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
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
        if (!$user->can('List_Students')) {
            abort(403);
        }
        $students=Student::all();
        return view('pages.student.List')->with('students',$students);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user->can('Add_Students')) {
            abort(403);
        }
        $types=StudentType::pluck('name','id');
        $users=User::pluck('name','id');;
        $students=null;
        return view('pages.student.Add')
            ->with('students',$students)
            ->with('types',$types)
            ->with('users',$users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->can('Add_Students')) {
            abort(403);
        }
        $request->validate([
           'f_name'=>'required',
           'l_name'=>'required',
           'telephone'=>'required',
           'dob'=>'required',
           'student_type_id'=>'required',
           'user_id'=>'required',
        ]);
        $students=new Student();
        $students->f_name=$request->f_name;
        $students->l_name=$request->l_name;
        $students->dob=$request->dob;
        $students->telephone=$request->telephone;
        $students->is_active = $request->is_active ? 1 : 0;
        $students->student_type_id=$request->student_type_id;
        $students->user_id=$request->user_id;
        $students->save();
        return redirect()->route('student.index');
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
        if (!$user->can('Edit_Students')) {
            abort(403);
        }
        $types=StudentType::pluck('name','id');
        $users=User::pluck('name','id');;
        $students=Student::find($id);
        return view('pages.student.Add')
            ->with('students',$students)
            ->with('types',$types)
            ->with('users',$users);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Students')) {
            abort(403);
        }
        $request->validate([
            'f_name'=>'required',
            'l_name'=>'required',
            'telephone'=>'required',
            'dob'=>'required',
            'student_type_id'=>'required',
            'user_id'=>'required',
        ]);
        $students=Student::find($id);
        $students->f_name=$request->f_name;
        $students->l_name=$request->l_name;
        $students->dob=$request->dob;
        $students->telephone=$request->telephone;
        $students->student_type_id=$request->student_type_id;
        $students->user_id=$request->user_id;
        $students->is_active = $request->is_active ? 1 : 0;
        $students->save();
        return redirect()->route('student.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        if (!$user->can('Delete_Students')) {
            abort(403);
        }
        $students=Student::find($id);
        $students->delete();
        $code = 200;
        $msg = 'The selected student has been successfully deleted!';
        return response()->json([
            'code' => $code,
            'msg'=>$msg
        ]);
    }
}
