<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function __construct()
    // {
    //     $this->authorizeResource(SubCategory::class);
    // }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SubCategory::with('category')->get();
           return DataTables::of($data)
                   ->addIndexColumn()
                   ->addColumn('subCategory', function ($row) {
                    return '<div class="d-flex align-items-center">
                    <a href="/dashboard/sub-category/' . $row->slug . '"
                        class="symbol symbol-50px">
                        <span class="symbol-label"
                            style="background-image:url( ' . Storage::url($row->image)  .');"></span>
                    </a>
                    <div class="ms-5">
                        <a href="/dashboard/sub-category/' . $row->slug . '"
                            class="text-gray-800 text-hover-primary fs-5 fw-bolder">' .$row->name . '</a>
                    </div>
                </div>';
                   })
                   ->addColumn('category', function ($row) {
                    return '<span class="fw-bolder text-dark">'. $row->category->name .'</span>';
                   })
                   ->addColumn('status', function ($row) {
                    return $row->getIsActiveAttribute();

                   })
                   ->addColumn('action', function($row){
                           return '<a class="btn btn-secondary btn-sm" href="/dashboard/sub-category/'. $row->slug .'/edit">
                           <i class="fa fa-edit">
                           </i>
                           '.trans("general.edit").'
                       </a>

                       <button class="btn btn-danger btn-sm delete" onclick="DeleteSubCategory('. $row->id .',this)">
                       '.trans("general.delete").'</button>';
                   })
                   ->rawColumns(['action','category','status', 'subCategory'])
                   ->make(true);
       }

       return view('sub_category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('sub_category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubCategoryRequest $request)
    {
        $saved = SubCategory::create($request->getData());
        return $saved ? parent::successResponse() : parent::errorResponse();
    }

    /**
     * Display the specified resource.
     */
    // public function show(Request $request, SubCategory $subCategory)
    public function show(Request $request, $slug)

    {
        $subCategory = SubCategory::select('*')->where('slug',$slug)->first();

        if ($request->ajax()) {
            $sub_category_with_books = $subCategory->load('books');
            $data = $sub_category_with_books->books;
            return Datatables::of($data)
                   ->addIndexColumn()
                   ->addColumn('book', function ($row) {
                    return '<div class="d-flex align-items-center">
                    <a href=""
                        class="symbol symbol-50px">
                        <span class="symbol-label"
                            style="background-image:url( ' . Storage::url($row->image)  .');"></span>
                    </a>
                    <div class="ms-5">
                        <a href=""
                            class="text-gray-800 text-hover-primary fs-5 fw-bolder">' .$row->name . '</a>
                        <div class="text-muted fs-7 fw-bolder">' .$row->description . '</div>
                    </div>
                </div>';
                   })
                   ->addColumn('price', function ($row) {
                    return '<span class="fw-bolder text-dark">'. $row->price .' $</span>';
                   })
                   ->addColumn('action', function($row){
                           return '<a class="btn btn-secondary btn-sm" href="/dashboard/book/'. $row->slug .'/edit">
                           <i class="fa fa-edit">
                           </i>
                           '.trans("general.edit").'
                       </a>

                       <button class="btn btn-danger btn-sm delete" onclick="DeleteBook('. $row->id .',this)" style="margin-top:5px;">
                       '.trans("general.delete").'</button>';
                   })

                   ->rawColumns(['action', 'book', 'price'])
                   ->make(true);
        }

        return view('sub_category.show', compact('subCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(SubCategory $subCategory)
    public function edit($slug)

    {
        $categories = Category::select('*')->get();
        $subCategory = SubCategory::select('*')->where('slug',$slug)->first();
        return view('sub_category.edit', compact('subCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubCategoryRequest $request, SubCategory $subCategory)
    {
        $updated = $subCategory->update($request->getData());
        return $updated ? parent::successResponse() : parent::errorResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
        $subCategory->books->each->delete();
        $deleted = $subCategory->delete();
        if ($deleted) {
            Storage::disk('public')->delete("$subCategory->image");
            return response()->json(['message' => "Sub Category deleted successfully"], Response::HTTP_OK);
        } else {
            return response()->json(['message' => "Deletion failed"], Response::HTTP_BAD_REQUEST);
        }
    }
}
