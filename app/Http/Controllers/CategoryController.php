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
    // public function __construct()
    // {
    //     $this->authorizeResource(Category::class);
    // }

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
                    <a href="/dashboard/category/' . $row->slug . '"
                        class="symbol symbol-50px">
                        <span class="symbol-label"
                            style="background-image:url( ' . Storage::url($row->image)  . ');"></span>
                    </a>
                    <div class="ms-5">
                        <a href="/dashboard/category/' . $row->slug . '"
                            class="text-gray-800 text-hover-primary fs-5 fw-bolder">' . $row->name . '</a>
                    </div>
                </div>';
                })
                ->addColumn('status', function ($row) {
                    return $row->getIsActiveAttribute();
                })
                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-secondary btn-sm" href="/dashboard/category/' . $row->slug . '/edit">
                           <i class="fa fa-edit">
                           </i>
                           Edit
                       </a>

                       <button class="btn btn-danger btn-sm delete" onclick="DeleteCategory(' . $row->id . ',this)">
                           Delete</button>';
                })
                ->rawColumns(['action', 'category', 'status'])
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
        $saved = Category::create($request->getData());
        return $saved ? parent::successResponse() : parent::errorResponse();
    }

    /**
     * Display the specified resource.
     */
    // public function show(Request $request, Category $category)
    public function show(Request $request, $slug)

    {
        $category = Category::select('*')->where('slug',$slug)->first();
        if ($request->ajax()) {
            $category_with_sub = $category->load('subCategories');
            $data = $category_with_sub->subCategories;
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('sub-category', function ($row) {
                    return '<div class="d-flex align-items-center">
                <a href="/dashboard/sub-category/' . $row->slug . '"
                    class="symbol symbol-50px">
                    <span class="symbol-label"
                        style="background-image:url( ' . Storage::url($row->image)  . ');"></span>
                </a>
                <div class="ms-5">
                    <a href="/dashboard/sub-category/' . $row->slug . '"
                        class="text-gray-800 text-hover-primary fs-5 fw-bolder">' . $row->name . '</a>
                </div>
            </div>';
                })
                ->addColumn('status', function ($row) {
                    return $row->getIsActiveAttribute();
                })
                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-secondary btn-sm" href="/dashboard/sub-category/' . $row->id . '/edit">
                       <i class="fa fa-edit">
                       </i>
                       Edit
                   </a>

                   <button class="btn btn-danger btn-sm delete" onclick="DeleteSubCategory(' . $row->id . ',this)">
                       Delete</button>';
                })
                ->rawColumns(['action', 'sub-category', 'status'])
                ->make(true);
        }

        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $category = Category::select('*')->where('slug',$slug)->first();
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $updated = $category->update($request->getData());
        return $updated ? parent::successResponse() : parent::errorResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $sub_categories =  $category->subCategories;
        foreach ($sub_categories as $sub_category) {
            $sub_category->books->each->delete();
        }
        $category->subCategories->each->delete();
        $deleted = $category->delete();
        if ($deleted) {
            Storage::disk('public')->delete("$category->image");
            return response()->json(['message' => "Category deleted successfully"], Response::HTTP_OK);
        } else {
            return response()->json(['message' => "Deletion failed"], Response::HTTP_BAD_REQUEST);
        }
    }

    public function subCategories(Category $category){
        $data = $category->load('subCategories');
        return $data->subCategories;
    }
}
