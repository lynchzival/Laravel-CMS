<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::orderBy('created_at', 'desc') -> paginate(5);

        if($request -> ajax()) {
            $view = view('category._load', ['categories' => $categories])->render();
            return response()->json(['html' => $view]);
        }

        return view("category.index", [
            "categories" => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories|max:255'
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => Str::slug($request->name)
        ]);

        return redirect() -> route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Request $request, $keyword = null)
    {
        $articles = Article::where('category_id', $category -> id);
        $populars = $category->popularArticles()->take(4)->get();

        if($keyword) {
            $articles -> where('title', 'like', '%'.$keyword.'%') -> where ('category_id', $category -> id);
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

        $articles = $articles -> paginate(5);
        
        if($request -> ajax()) {
            $view = view('article.partials.articles-detailed', ['articles' => $articles])->render();
            return response()->json(['html' => $view]);
        }

        return view('category.show', [
            'articles' => $articles,
            'category' => $category,
            'list' => $populars,
            'keyword' => $keyword ?? ''
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('category.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => Str::slug($request->name)
        ]);

        return redirect() -> route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
