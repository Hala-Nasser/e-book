<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Category;
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
            $data = Book::with('category')->get();
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
                   ->addColumn('category', function ($row) {
                    return '<span class="fw-bolder text-dark">'. $row->category->name .'</span>';
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
                               <a href="dashboard/book/'. $row->id .'/edit"
                                   class="menu-link px-3">Edit</a>
                           </div>
                           <!--end::Menu item-->
                           <!--begin::Menu item-->
                           <div class="menu-item px-3">
                               <button class="btn menu-link px-3"
                                   onclick="DeleteBook('. $row->id .',this)"
                                   style="font-size: .95rem; color:#7e8299; text-align: left; padding-left:0px">
                                   Delete
                               </button>
                           </div>
                           <!--end::Menu item-->
                       </div>
                       <!--end::Menu-->';

                   })

                   ->rawColumns(['action', 'book', 'category'])
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
        // if ($book) {
        //     return response()->json(['message' => "Book added successfully"], Response::HTTP_OK);
        // }
        // return response()->json(['message' => "Create failed"], Response::HTTP_BAD_REQUEST);

        return $saved ? parent::successResponse() : parent::errorResponse();
        // return $book ? response()->json(['message' => "Book added successfully"], Response::HTTP_OK): response()->json(['message' => "Create failed"], Response::HTTP_BAD_REQUEST);
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
        return $updated ? parent::successResponse() : parent::errorResponse();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $deleted = $book->delete();
        if ($deleted) {
            Storage::disk('public')->delete("$book->image");
            return response()->json(['message' => "Book deleted successfully"], Response::HTTP_OK);
        }else{
            return response()->json(['message' => "Deletion failed"], Response::HTTP_BAD_REQUEST);
        }
    }
}
