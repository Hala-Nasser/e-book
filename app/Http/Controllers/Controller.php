<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Book;
use App\Models\Category;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index(){
        $categories_count = Category::count();
        $books_count = Book::count();
        $categories = Category::select('*')->get();
        foreach($categories as $category){
            $category->books_count = Book::select('*')->where('category_id',$category->id)->get()->count();
        }
        // dd($categories);
        return view('home',compact('categories_count', 'books_count', 'categories'));
    }
}
