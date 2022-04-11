<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class ArticleFavoriteController extends Controller
{
    public function favorite(Request $request){
        $user = User::find(auth()->user()->id);
        $article = Article::find($request->id);

        $user->toggleFavorite($article);
        
        return response()->json([
            'status'=>$article->hasBeenFavoritedBy($user),
            'favorites'=> $article->favorites()->count()
        ]);
    }

    public function inProfile(Request $request){
        $user = User::find(auth()->user()->id);
        $articles = $user->getFavoriteItems(Article::class) -> paginate(5);

        if($request -> ajax()) {
            $view = view('article.partials.articles-detailed', ['articles' => $articles])->render();
            return response()->json(['html' => $view]);
        }

        return view('profile.index', [
            "articles" => $articles
        ]);
    }

    public function fromUser(User $user, Request $request){
        $reader = $user::reader();
        $loggedIn = auth() -> check();

        if ($loggedIn) {
            $loggedIn = auth()->user()->isAdmin();
            if ($user->id === auth()->user()->id)
                return redirect()->route('profile');
        }

        $reader -> when(!$loggedIn, function($query){
            return $query -> visible();
        });
        
        $user = $reader -> findOrFail($user -> id);
        $articles = $user->getFavoriteItems(Article::class) -> paginate(5);

        if($request -> ajax()) {
            $view = view('article.partials.articles-detailed', ['articles' => $articles])->render();
            return response()->json(['html' => $view]);
        }

        return view('user.show', [
            "user" => $user,
            "articles" => $articles
        ]);
    }
}
