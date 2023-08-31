<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::select('*')->get();
        return view('category.index')->with('categories', $categories);
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
            return response()->json(['message' => "تمت العملية بنجاح"], Response::HTTP_OK);
        }
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
            return response()->json(['message' => "تمت العملية بنجاح"], Response::HTTP_OK);
        }
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
            return response()->json(['message' => "تمت العملية بنجاح"], Response::HTTP_OK);
        }else{
            return response()->json(['message' => "تعذر الحذف"]);
        }
    }
}
