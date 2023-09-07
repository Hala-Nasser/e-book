<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Category;
use App\Models\MediaBook;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use \Yajra\Datatables\Datatables;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->authorizeResource(Book::class, 'book');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Book::with('subCategory')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('book', function ($row) {
                    return '<div class="d-flex align-items-center">
                    <a href=""
                        class="symbol symbol-50px">
                        <span class="symbol-label"
                            style="background-image:url( ' . Storage::url($row->image)  . ');"></span>
                    </a>
                    <div class="ms-5">
                        <a href=""
                            class="text-gray-800 text-hover-primary fs-5 fw-bolder">' . $row->name . '</a>
                        <div class="text-muted fs-7 fw-bolder">' . $row->description . '</div>
                    </div>
                </div>';
                })
                ->addColumn('sub-category', function ($row) {
                    return '<span class="fw-bolder text-dark">' . $row->subCategory->name . '</span>';
                })
                ->addColumn('price', function ($row) {
                    return '<span class="fw-bolder text-dark">' . $row->price . ' $</span>';
                })
                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-secondary btn-sm" href="/dashboard/book/' . $row->id . '/edit">
                           <i class="fa fa-edit">
                           </i>
                           Edit
                       </a>

                       <button class="btn btn-danger btn-sm delete" onclick="DeleteBook(' . $row->id . ',this)" style="margin-top:5px;">
                           Delete</button>';
                })

                ->rawColumns(['action', 'book', 'sub-category', 'price'])
                ->make(true);
        }

        return view('book.index');
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
        $saved = Book::create($request->getData());
        if ($saved) {
            if ($request['images']) {
                $images = [];
                foreach ($request['images'] as $image) {
                    $imageName = time() . "" . random_int(1, 999999). '.' . $image->getClientOriginalExtension();
                    $image->storePubliclyAs('Book', $imageName, ['disk' => 'public']);
                    $media = new MediaBook();
                    $media->book_id = $saved->id;
                    $media->image = 'Book/' . $imageName;
                    $images[] = $media;
                 }
                $saved->media()->saveMany($images);
            }
        }
        return $saved ? parent::successResponse() : parent::errorResponse();
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
        $book = $book->load('subCategory')->load('media');
        return view('book.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $updated = $book->update($request->getData());
        if ($updated) {
            if ($request['images']) {
                foreach ($request['images'] as $image) {
                    $imageName = time() . "" . random_int(1, 999999). '.' . $image->getClientOriginalExtension();
                    $image->storePubliclyAs('Book', $imageName, ['disk' => 'public']);
                    $media = new MediaBook();
                    $media->book_id = $book->id;
                    $media->image = 'Book/' . $imageName;
                    $media->save();
                }
            }
        }
        return $updated ? parent::successResponse() : parent::errorResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        foreach($book->media as $media){
            $media_deleted = $media->delete();
            if($media_deleted){
                Storage::disk('public')->delete("$media->image");
            }
        }
        $deleted = $book->delete();
        if ($deleted) {
            Storage::disk('public')->delete("$book->image");
            return response()->json(['message' => "Book deleted successfully"], Response::HTTP_OK);
        } else {
            return response()->json(['message' => "Deletion failed"], Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteMedia(MediaBook $media_book){
        $deleted = $media_book->delete();
        if ($deleted) {
            Storage::disk('public')->delete("$media_book->image");
            return response()->json(['message' => "Media deleted successfully"], Response::HTTP_OK);
        } else {
            return response()->json(['message' => "Deletion failed"], Response::HTTP_BAD_REQUEST);
        }
    }
}
