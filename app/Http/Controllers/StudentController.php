<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentType;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $students=Student::with('getUser')->get();
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
        $users = User::whereHas('getType', function ($q) {
            $q->where('key', 'A');
        })->pluck('name', 'id');
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
        ]);
        $studentType = StudentType::find($request->student_type_id);
        $name = $request->f_name . " " . $request->l_name;
        $username = $request->f_name . "_" . $request->l_name;
        $mailExt = $studentType->email_extension;
        $baseEmail = $username . '@' .$mailExt;
        $email = $baseEmail;
        $counter = 1;
        while (User::where('email', $email)->exists()) {
            $email = $username . $counter . '@' . $mailExt;
            $counter++;
        }
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $role = UserType::where("key", "S")->firstOrFail();
        $randomPassword = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->password = Hash::make($randomPassword);
        $user->plain_password = $randomPassword;
        $user->user_type_id = $role->id;
        $user->save();

        $students=new Student();
        $students->f_name=$request->f_name;
        $students->l_name=$request->l_name;
        $students->dob=$request->dob;
        $students->telephone=$request->telephone;
        $students->is_active = $request->is_active ? 1 : 0;
        $students->student_type_id=$request->student_type_id;
        $students->user_id=$user->id;
        $students->save();

        session()->flash('student_credentials', [
            'email' => $email,
            'password' => $randomPassword,
            'name' => $name
        ]);

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
        ]);
        $students=Student::find($id);
        $students->f_name=$request->f_name;
        $students->l_name=$request->l_name;
        $students->dob=$request->dob;
        $students->telephone=$request->telephone;
        $students->student_type_id=$request->student_type_id;
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
    public function viewStudent($id){
        $student=Student::find($id);
        return view('pages.student.View')->with('student',$student);
    }
}
