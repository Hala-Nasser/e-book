<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Mail\AdminWelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
     {
         $this->authorizeResource(Admin::class, 'admin');
     }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Admin::all();
            foreach($data as $admin){
                $admin->role = $admin->roles()->first();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('admin', function ($row) {
                    return '<div class="d-flex align-items-center">
                    <a href=""
                        class="symbol symbol-50px">
                        ' . ($row->image
                        ? ' <span class="symbol-label"
                        style="background-image:url('.Storage::url($row->image) .');"></span>'
                        : '<span class="symbol-label"
                        style="background-image:url('. asset('dist/assets/media/person.png') .');"></span>') . '
                    </a>
                    <div class="ms-5">
                    <a href=""
                    class="text-gray-800 text-hover-primary fs-5 fw-bolder">' . $row->name . '</a>
                    </div>
                </div>';
                })
                ->addColumn('role', function ($row) {
                    return '<span class="fw-bolder text-dark">' . $row->role->name . '</span>';
                })
                ->addColumn('verification', function ($row) {
                    return $row->getIsVerifiedAttribute();
                })
                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-secondary btn-sm" href="/dashboard/admin/' . $row->id . '/edit">
                           <i class="fa fa-edit">
                           </i>
                           '.trans("general.edit").'
                       </a>

                       <button class="btn btn-danger btn-sm delete" onclick="DeleteAdmin(' . $row->id . ',this)" style="margin-top:5px;">
                       '.trans("general.delete").'</button>';
                })

                ->rawColumns(['action', 'admin', 'role', 'verification'])
                ->make(true);
        }

        return response()->view('admin.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('guard_name', 'admin')->get();
        return response()->view('admin.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        $data = $request->getData();
        $password = Str::random(10);
        $admin = new Admin();
        $admin->name = $data['name'];
        $admin->email = $data['email'];
        $admin->image = $data['image'];
        $admin->password = Hash::make($password);
        $is_saved = $admin->save();
        if ($is_saved) {
            $admin->syncRoles(Role::findById($request['role_id'], 'admin'));
            Mail::to([$admin])->send(new AdminWelcomeMail($admin, $password));
            return response()->json(['message' => "Admin added successfully"], Response::HTTP_OK);
        }
        return response()->json(['message' => "Create failed"], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $roles = Role::where('guard_name', 'admin')->get();
        $admin->role = $admin->roles()->first();
        return response()->view('admin.edit', compact('roles', 'admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $updated = $admin->syncRoles(Role::findById($request['role_id'], 'admin'));
        if ($updated) {
            return response()->json(['message' => "Role updated successfully"], Response::HTTP_OK);
        }
        return response()->json(['message' => "Update failed"], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $deleted = $admin->delete();
        if ($deleted) {
            Storage::disk('public')->delete("$admin->image");
            return response()->json(['message' => "Admin deleted successfully"], Response::HTTP_OK);
        } else {
            return response()->json(['message' => "Deletion failed"], Response::HTTP_BAD_REQUEST);
        }
    }
}
