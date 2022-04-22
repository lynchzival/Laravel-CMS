<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Scopes\ArticlePublishedScope;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($keyword=null, Request $request)
    {
        $articles = Article::withoutGlobalScope(ArticlePublishedScope::class);
        $authors = User::has('articlesWithoutGlobalScopes')->get();

        $articles -> when(auth() -> user() -> isAuthor(), function($query){
            return $query -> where('user_id', auth() -> user() -> id);
        });

        if($keyword) {
            $articles -> where('title', 'like', '%'.$keyword.'%');
        }

        if ($request -> has('sort')){
            $articles -> when($request -> sort == 'asc', function($query){
                return $query -> orderBy('created_at', 'asc');
            }) -> when($request -> sort == 'desc', function($query){
                return $query -> orderBy('created_at', 'desc');
            }) -> when($request -> sort == 'views', function($query){
                return $query -> orderBy('view_count', 'desc');
            });
        }

        if ($request -> has('category') && $request -> category != 'all') {
            $articles -> where('category_id', Category::where('name', $request -> category) -> first() -> id);
        }

        if ($request -> has('author') && $request -> author != 'all') {
            $articles -> where('user_id', $request -> author);
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

        return view('article.index', [
            'articles' => $articles,
            'keyword' => $keyword ?? '',
            'categories' => Category::all(),
            'authors' => $authors,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('article.create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|min:5',
            'content' => 'required|min:10',
            'category_id' => 'required|exists:categories,id'
        ]);

        $image = null;
        $slug = Str::slug($request->title)."-".time();

        if($request->hasFile('thumbnail')){
            $this -> validate($request, [
                'thumbnail' => 'image|max:2048|mimes:jpeg,png,jpg,gif,svg,webp'
            ]);

            $image_name = time().$request->thumbnail->getClientOriginalName();
            $request->thumbnail->move(public_path("img/articles/thumb/"), $image_name);
            
            $image = "img/articles/thumb/".$image_name;
        }

        $isAdmin = auth() -> user() -> isAdmin();

        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'user_id' => auth()->user()->id,
            "thumbnail" => $image,
            "slug" => $slug,
            "published" => ($request->published) ? 1 : 0,
            "comment_status" => ($request->comment) ? 1 : 0,
            'pinned' => ($request->pinned && $isAdmin) ? 1 : 0,
            'pinned_at' => ($request->pinned && $isAdmin) ? now() : null,
            'is_premium' => ($request->premium) ? 1 : 0,
        ]);

        return redirect()->route('article.index');

    }


    public function storeTinyMCEImg(Request $request){
        $image_name = time().$request->file('file')->getClientOriginalName();
        $request->file('file')->move(public_path('img/articles/'), $image_name);

        return response()->json(['location' => "/img/articles/$image_name"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug) -> firstOrFail();

        if ($article -> is_premium){

            if (Auth::check()){
                $user = auth() -> user();
                if ($user -> isReader() 
                && !$user -> subscribed('default')){
                    return redirect('/subscription');
                }
            } else {
                return redirect() -> route('login');
            }
            
        }

        $article->increment('view_count');
        $related = collect();

        if ($next = $article -> next())
            $related -> push($next);
        if ($prev = $article -> previous())
            $related -> push($prev);

        return view('article.show', [
            'article' => $article,
            'list' => $related
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($slug)
    {
        $article = Article::withoutGlobalScope(ArticlePublishedScope::class)  
            -> where('slug', $slug) -> firstOrFail();

        $related = collect();

        if ($next = $article -> next())
            $related -> push($next);
        if ($prev = $article -> previous())
            $related -> push($prev);
        
        return view('article.show', [
            'article' => $article,
            'list' => $related
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $article = Article::withoutGlobalScope(ArticlePublishedScope::class) 
            -> where('slug', $slug) 
            -> first();

        return view('article.edit', [
            'article' => $article,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            'title' => 'required|min:5',
            'content' => 'required|min:10',
            'category_id' => 'required|exists:categories,id'
        ]);

        $article = Article::withoutGlobalScope(ArticlePublishedScope::class) -> where('slug', $slug) 
            -> first() ;

        $isAdmin = auth() -> user() -> isAdmin();
        
        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'published' => ($request->published) ? 1 : 0,
            'comment_status' => ($request->comment) ? 1 : 0,
            'pinned' => ($request->pinned && $isAdmin) ? 1 : 0,
            'pinned_at' => ($request->pinned && $isAdmin ) ? now() : null,
            'is_premium' => ($request->premium) ? 1 : 0,
        ]);

        if($request->hasFile('thumbnail')){

            $this -> validate($request, [
                'thumbnail' => 'image|max:2048|mimes:jpeg,png,jpg,gif,svg,webp'
            ]);

            if ($article -> thumbnail)
                File::delete(public_path($article -> thumbnail));

            $image_name = time().$request->thumbnail->getClientOriginalName();
            $request->thumbnail->move(public_path("img/articles/thumb/"), $image_name);

            $article -> update([
                "thumbnail" => "img/articles/thumb/" . $image_name
            ]);

        }

        if($request -> thumbnail_removal){
            if ($article -> thumbnail)
                File::delete(public_path($article -> thumbnail));

            $article -> update([
                "thumbnail" => null
            ]);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $article = Article::withoutGlobalScope(ArticlePublishedScope::class) 
            -> where('slug', $slug) 
            -> first();

        DB::table('likes')->where('likeable_id', $article->id)->delete();
        DB::table('favorites')->where('favoriteable_id', $article->id)->delete();

        if ($article -> thumbnail)
            File::delete(public_path($article -> thumbnail));
        
        $article->delete();

        return redirect()->route('article.index');
    }
}
