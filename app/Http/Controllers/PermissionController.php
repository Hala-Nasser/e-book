<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
     {
         $this->authorizeResource(Permission::class, 'permission');
     }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user_type', function ($row) {
                    return '<div class="badge '. ($row->guard_name == 'admin' ? 'badge-light-success' : 'badge-light-primary' ).'"
                    style="font-size:1.15rem"> '. $row->guard_name .'</div>';
                })
                ->rawColumns(['user_type'])
                ->make(true);
        }

        return view('permission.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
    }
}
