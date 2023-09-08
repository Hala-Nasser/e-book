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
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::withCount('permissions')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user_type', function ($row) {
                    return '<div class="badge ' . ($row->guard_name == 'admin' ? 'badge-light-success' : 'badge-light-primary') . '"
                    style="font-size:1.15rem"> ' . $row->guard_name . '</div>';
                })
                ->addColumn('permissions',function($row){
                    return '<a href="/dashboard/role/' . $row->id . '/permissions" id="kt_ecommerce_add_product_cancel"
                            class="btn btn-light me-5">'. $row->permissions_count .' permission/s</a>';
                })
                ->addColumn('actions', function ($row) {
                    return '<a class="btn btn-secondary btn-sm" href="/dashboard/role/' . $row->id . '/edit">
                           <i class="fa fa-edit">
                           </i>
                           '.trans("general.edit").'
                       </a>

                       <button class="btn btn-danger btn-sm delete" onclick="DeleteRole(' . $row->id . ',this)">
                       '.trans("general.delete").'</button>';
                })
                ->rawColumns(['user_type', 'permissions', 'actions'])
                ->make(true);
        }

        return view('role.index');
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

        if ($request->ajax()) {
            // $this->authorize('editRolePermissions', Role::class);
        $data = Permission::where('guard_name', $role->guard_name)->get();
        $role_permissions = $role->permissions;

        //في حال كانت الرول المحددة لها بيرميشنز
        //روح لف على كل البيرميشن الموجودين في الجدول
        //افحصلي ازا البيرميشن موجود جوا كولكشن الرول بيرميشنز ($role_permissions)
        //ازا موجود ضيفلي اتربيوت الاسايند و خلي قيمته ترو
        //ازا موجود ضيفلي اتربيوت الاسياند و خلي قيمته فولس
        if (count($role_permissions) > 0) {
            foreach ($data as $permission) {
                if ($role_permissions->contains($permission)) {
                    $permission->assigned = true;
                } else {
                    $permission->assigned = false;
                }
            }
        }
        // dd($data);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user_type', function ($row) {
                    return '<div class="badge ' . ($row->guard_name == 'admin' ? 'badge-light-success' : 'badge-light-primary') . '"
                    style="font-size:1.15rem"> ' . $row->guard_name . '</div>';
                })
                ->addColumn('permissions',function($row){
                    return '<a href="/dashboard/role/' . $row->id . '/permissions" id="kt_ecommerce_add_product_cancel"
                            class="btn btn-light me-5">'. $row->permissions_count .' permission/s</a>';
                })
                ->addColumn('actions', function ($row) {
                    // dd($row->assigned);
                       return '<div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input onclick="performUpdate('.$row->id.')"  ' . ($row->assigned == true ? 'checked="true"' : '') . ' class="form-check-input" type="checkbox" value="1" id="permission_'.$row->id.'_check_box">
                                    </div>';
                })
                ->rawColumns(['user_type', 'permissions', 'actions'])
                ->make(true);
        }

        return view('role.role_permissions', compact('role'));
        // return response()->view('role.role_permissions', compact('role', 'permissions'));
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
