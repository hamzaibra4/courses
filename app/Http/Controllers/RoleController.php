<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user->can('List_Role')) {
            abort(403);
        }
        $roles = Role::all();
        return view('pages.roles.index', compact('roles'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->can('Add_Role')) {
            abort(403);
        }
        $permissions = Permission::all();
        return view('pages.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->can('Add_Role')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Role')) {
            abort(403);
        }
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('pages.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Role')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'nullable|array',
        ]);

        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }


    public function assignPermissions(Request $request)
    {
        $user = Auth::user();
        if (!$user->can('Assign_Permission')) {
            abort(403);
        }
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'required|array',
        ]);

        $role = Role::findOrFail($request->role_id);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Permissions assigned to role.');
    }

    public function destroy(string $id)
    {
        //
        $user = Auth::user();
        if (!$user->can('Delete_Role')) {
            return response()->json([
                'code' => 403,
                'msg'=>"Unauthorized"
            ]);
        }

        $role=Role::find($id);
        if (! $role) {
            return response()->json([
                'code' => 404,
                'msg' => 'Role not found.'
            ]);
        }
        $role->delete();
        $code = 200;
        $msg = 'The selected role has been successfully deleted!';

        return response()->json([
            'code' => $code,
            'msg'=>$msg
        ]);
    }
}
