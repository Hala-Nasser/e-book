<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('category')->get();
        return response()->view('book.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('*')->get();
        return response()->view('book.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->getData());
        if ($book) {
            return response()->json(['message' => "تمت العملية بنجاح"], Response::HTTP_OK);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $categories = Category::select('*')->get();
        return view('book.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $updated = $book->update($request->getData());
        if ($updated) {
            return response()->json(['message' => "تمت العملية بنجاح"], Response::HTTP_OK);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $deleted = $book->delete();
        if ($deleted) {
            Storage::disk('public')->delete("$book->image");
            return response()->json(['message' => "تمت العملية بنجاح"], Response::HTTP_OK);
        }else{
            return response()->json(['message' => "تعذر الحذف"]);
        }
    }
}
