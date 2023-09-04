<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{

    //بدنا نطبق ال policy علشان يتم تنفيذ البيرمشنز و الرولز
    public function __construct()
    {
        $this->authorizeResource(Category::class, 'category');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::select('*')->get();
           return DataTables::of($data)
                   ->addIndexColumn()
                   ->addColumn('category', function ($row) {
                    return '<div class="d-flex align-items-center">
                    <a href=""
                        class="symbol symbol-50px">
                        <span class="symbol-label"
                            style="background-image:url( ' . Storage::url($row->image)  .');"></span>
                    </a>
                    <div class="ms-5">
                        <a href=""
                            class="text-gray-800 text-hover-primary fs-5 fw-bolder">' .$row->name . '</a>
                    </div>
                </div>';
                   })
                   ->addColumn('status', function ($row) {
                    if($row->status == 1){
                        return '<div class="badge badge-light-success" style="font-size:1.15rem">Active</div>';
                    }else{
                        return '<div class="badge badge-light-primary" style="font-size:1.15rem">Inactive</div>';
                    }

                   })
                   ->addColumn('action', function($row){
                    //        return '<a class="btn btn-secondary btn-sm" href="with/'.$row->id.'/edit ">
                    //        <i class="fa fa-edit">
                    //        </i>
                    //        تعديل
                    //    </a>

                    //    <button class="btn btn-danger btn-sm delete" onclick="DeleteWith('.$row->id.',this)">
                    //        حذف</button>';

                           return '<a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                           data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                           <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                           <span class="svg-icon svg-icon-5 m-0">
                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                   viewBox="0 0 24 24" fill="none">
                                   <path
                                       d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                       fill="black" />
                               </svg>
                           </span>
                           <!--end::Svg Icon--></a>
                       <!--begin::Menu-->
                       <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                           data-kt-menu="true">
                           <!--begin::Menu item-->
                           <div class="menu-item px-3">
                               <a href="dashboard/category/'. $row->id .'/edit"
                                   class="menu-link px-3">Edit</a>
                           </div>
                           <!--end::Menu item-->
                           <!--begin::Menu item-->
                           <div class="menu-item px-3">
                               <button class="btn menu-link px-3"
                                   onclick="DeleteCategory('. $row->id .',this)"
                                   style="font-size: .95rem; color:#7e8299; text-align: left; padding-left:0px">
                                   Delete
                               </button>
                           </div>
                           <!--end::Menu item-->
                       </div>
                       <!--end::Menu-->';

                   })

                   ->rawColumns(['action','category','status'])
                   ->make(true);
       }

       return view('category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->getData());
        if ($category) {
            return response()->json(['message' => "Category added successfully"], Response::HTTP_OK);
        }
        return response()->json(['message' => "Create failed"], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category = $category->load('books');
      return response()->view('category.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $updated = $category->update($request->getData());
        if ($updated) {
            return response()->json(['message' => "Category updated successfully"], Response::HTTP_OK);
        }
        return response()->json(['message' => "Update failed"], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->books->each->delete();
        $deleted = $category->delete();
        if ($deleted) {
            Storage::disk('public')->delete("$category->image");
            return response()->json(['message' => "Category deleted successfully"], Response::HTTP_OK);
        }else{
            return response()->json(['message' => "Deletin failed"], Response::HTTP_BAD_REQUEST);
        }
    }
}
