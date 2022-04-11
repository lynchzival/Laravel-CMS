<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;

class ArticleLikeController extends Controller
{

    public function like(Request $request){
        $user = User::find(auth()->user()->id);
        $article = Article::find($request->id);

        $response = $user->toggleLike($article);
        
        return response()->json([
            'success'=>$response,
            'likes'=> $article->likeCount()
        ]);
    }

    public function inProfile(Request $request){
        $user = User::find(auth()->user()->id);
        $likes = $user->likes()->with('likeable')->paginate(5);

        $articles = collect();
        foreach ($likes as $like) {
            $articles -> push($like->likeable);
        }

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
        $likes = $user->likes()->with('likeable')->paginate(5);

        $articles = collect();
        foreach ($likes as $like) {
            $articles -> push($like->likeable);
        }

        if($request -> ajax()) {
            $view = view('article.partials.articles-detailed', ['articles' => $articles])->render();
            return response()->json(['html' => $view]);
        }

        return view('user.show ', [
            "user" => $user,
            "articles" => $articles
        ]);
    }
}