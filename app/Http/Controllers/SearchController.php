<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index($keyword=null, Request $request){

        $articles = Article::where('title', 'like', '%'.$keyword.'%');

        if ($request -> has('category') && $request -> category != 'all') {
            $articles -> where('category_id', Category::where('name', $request -> category) -> first() -> id);
        }

        if ($request -> has('sort')) {
            $articles -> when($request -> sort == 'asc', function($query){
                return $query -> orderBy('created_at', 'asc');
            }) -> when($request -> sort == 'desc', function($query){
                return $query -> orderBy('created_at', 'desc');
            }) -> when($request -> sort == 'views', function($query){
                return $query -> orderBy('view_count', 'desc');
            });
        }

        if ($request -> has('type') && $request -> type != 'all') {
            $articles -> when($request -> type == 'free', function($query){
                return $query -> where('is_premium', 0);
            }) -> when($request -> type == 'premium', function($query){
                return $query -> where('is_premium', 1);
            });
        }

        $total = $articles -> count();
        $articles = $articles -> paginate(5);

        if($request -> ajax()) {
            $view = view('article.partials.articles-detailed', ['articles' => $articles])->render();
            return response()->json(['html' => $view]);
        }    

        return view('search.index', [
            'articles' => $articles,
            'keyword' => $keyword,
            'total' => $total,
            'categories' => Category::all()
        ]);
    }
}
