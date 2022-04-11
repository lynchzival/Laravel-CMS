<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Request $request, $keyword=null)
    {
        if($user -> isReader()){
            abort('404');
            /** show author and admin user only */
        }

        $articles = $user->articles();

        if ($keyword) {
            $articles -> where('title', 'like', '%'.$keyword.'%');
        }

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

        $articles = $articles -> paginate(5);
        $populars = $user->popularArticles()->take(4)->get();
        
        if($request -> ajax()) {
            $view = view('article.partials.articles-detailed', ['articles' => $articles])->render();
            return response()->json(['html' => $view]);
        }

        return view('author.show', [
            'articles' => $articles,
            'author' => $user,
            'list' => $populars,
            'keyword' => $keyword,
            'categories' => Category::all()
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
