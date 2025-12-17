<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        if (!$user->can('List_Users')) {
            abort(403);
        }
        $typeIds = UserType::whereIn('key', ['A', 'SA'])->pluck('id');
        $users = User::whereIn('user_type_id', $typeIds)->get();
        return view('pages.user.List')->with('users', $users);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user->can('Add_Users')) {
            abort(403);
        }
        $users=null;
        $types = UserType::whereIn('key', ['A', 'SA'])->pluck('name','id');
        return view('pages.user.Add')
            ->with('users',$users)
            ->with('types',$types);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'name'=>'required',
           'email'=>'required',
           'password'=>'required',
           'user_type_id'=>'required',
        ]);
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->user_type_id=$request->user_type_id;
        $user->save();
        return redirect()->route('user.index');

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
        if (!$user->can('Edit_Users')) {
            abort(403);
        }
        $users=User::find($id);
        $types = UserType::whereIn('key', ['A', 'SA'])->pluck('name','id');
        return view('pages.user.Add')
            ->with('users',$users)
            ->with('types',$types);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Users')) {
            abort(403);
        }
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'user_type_id'=>'required',
        ]);
        $user=User::find($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->user_type_id=$request->user_type_id;
        $user->save();
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)

        {
            $user = Auth::user();
            if (!$user->can('Delete_Users')) {
                abort(403);
            }
            $users=User::find($id);
            $users->delete();
            $code = 200;
            $msg = 'The selected user has been successfully deleted!';
            return response()->json([
                'code' => $code,
                'msg'=>$msg
            ]);
        }
    public function resetPasswordModal(Request $request){

        $id=$request->id;
        return response()->json([
            'code'=> 200,
            'view' => view('commons.ResetPasswordModal')->with('userId',$id)->render(),
        ]);
    }


    public function updatePassword( Request $request){
        $userId = $request->user_id;
        $newPassword = $request->internalUserManagmentPassword;
        $newPasswordConfirmation = $request->internalUserManagmentPasswordConfirmation;
        $user = User::findOrFail($userId);
        if ($user) {
            if($newPassword && $newPasswordConfirmation){
                if($newPassword == $newPasswordConfirmation){
                    $user->password = $newPassword;
                    $user->save();
                    return  redirect()->route('user.index')->with('message','200');
                }
                else{
                    return back()->with('message','500');
                }
            }
        }
    }



    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Old password is incorrect.'
            ]);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }



}
