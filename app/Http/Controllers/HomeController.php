<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;

class HomeController extends Controller
{
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
