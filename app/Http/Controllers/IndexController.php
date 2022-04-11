<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function index(){
        $categories = Category::all();
        $pins = Article::pinned() -> orderBy('pinned_at', 'desc') -> limit(4) -> get();

        return view('index', [
            'categories' => $categories,
            'pins' => $pins
        ]);
    }

    public function about(){
        return view('about');
    }

    public function contact(){
        return view('contact');
    }

}
