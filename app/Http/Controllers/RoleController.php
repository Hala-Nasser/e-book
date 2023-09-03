<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolePermissionsRequest;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
     {
         $this->authorizeResource(Role::class, 'role');
     }

    public function index()
    {
        $roles = Role::all();
        $roles = Role::withCount('permissions')->get();
        return response()->view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create($request->getData());
        if ($role) {
            return response()->json(['message' => "Role added successfully"], Response::HTTP_OK);
        }
        return response()->json(['message' => "Create failed"], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    public function editRolePermissions(Request $request, Role $role)
    {

        // $this->authorize('editRolePermissions', Role::class);
        $permissions = Permission::where('guard_name', $role->guard_name)->get();
        $role_permissions = $role->permissions;

        //في حال كانت الرول المحددة لها بيرميشنز
        //روح لف على كل البيرميشن الموجودين في الجدول
        //افحصلي ازا البيرميشن موجود جوا كولكشن الرول بيرميشنز ($role_permissions)
        //ازا موجود ضيفلي اتربيوت الاسايند و خلي قيمته ترو
        //ازا موجود ضيفلي اتربيوت الاسياند و خلي قيمته فولس
        if (count($role_permissions) > 0) {
            foreach ($permissions as $permission) {
                if ($role_permissions->contains($permission)) {
                    $permission->assigned = true;
                } else {
                    $permission->assigned = false;
                }
            }
        }
        return response()->view('role.role_permissions', compact('role', 'permissions'));
    }

    public function updateRolePermissions(RolePermissionsRequest $request, Role $role)
    {
        $validator = $request->getData();
        if ($validator) {
            $permission  = Permission::findById($request['permission_id'], 'admin');
            //بفحص هل الرول الحالي عنده البيرميشن الي تم الضغط عليه؟
            if ($role->hasPermissionTo($permission)) {
                $role->revokePermissionTo($permission); //في حال كان موجود عنده مسبقا معناها انا ضغطت عشان اشيله
            } else {
                $role->givePermissionTo($permission); //في حال مش موجود بكون ضغطت عشان اعطيه هاي البيرميشن
            }
            return response()->json(['message' => "Permission updated successfully"], Response::HTTP_OK);
        }
        return response()->json(['message' => "Update failed"], Response::HTTP_BAD_REQUEST);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $updated = $role->update($request->getData());
        if ($updated) {
            return response()->json(['message' => "Role updated successfully"], Response::HTTP_OK);
        }
        return response()->json(['message' => "Update failed"], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $deleted = $role->delete();
        if ($deleted) {
            Storage::disk('public')->delete("$role->image");
            return response()->json(['message' => "Role deleted successfully"], Response::HTTP_OK);
        } else {
            return response()->json(['message' => "Deletion failed"], Response::HTTP_BAD_REQUEST);
        }
    }
}
