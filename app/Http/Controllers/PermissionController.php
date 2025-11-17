<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function assignPermissionsPage()
    {
        $user = Auth::user();
        if (!$user->can('Assign_Permission')) {
            abort(403);
        }
        $users = User::all();
        $permissions = Permission::all();
        return view('pages.permissions.index', compact('users', 'permissions'));
    }

    public function assignPermissions(Request $request)
    {
        $user = Auth::user();
        if (!$user->can('Assign_Permission')) {
            abort(403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permissions' => 'nullable|array',
        ]);

        $user = User::findOrFail($request->user_id);

        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        } else {
            $user->syncPermissions([]); // No permissions selected, clear all
        }

        return redirect()->route('users.assign_permissions')->with('success', 'Permissions assigned to user successfully.');
    }

    public function getUserPermissions($id)
    {
        $user = Auth::user();
        if (!$user->can('Assign_Permission')) {
            abort(403);
        }

        $user = User::findOrFail($id);
        $permissions = $user->getPermissionNames(); // returns collection of permission names
        return response()->json($permissions);
    }

}
