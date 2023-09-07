<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    public function index(){
        $categories_count = Category::count();
        $sub_categories_count = SubCategory::count();
        $books_count = Book::count();
        $categories = Category::select('*')->get();
        foreach($categories as $category){
            $category->sub_categories_count = SubCategory::select('*')->where('category_id',$category->id)->get()->count();
        }
        // dd($categories);
        return view('home',compact('categories_count', 'sub_categories_count', 'books_count', 'categories'));
    }
}
