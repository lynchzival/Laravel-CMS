<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use stdClass;

class ProfileController extends Controller
{
    public function index(Request $request){

        $followings = auth()->user()->followings;
        $articles = collect();
        
        foreach ($followings as $following) {
            $articles -> push(
                $following->articles
            );
        }

        $articles = $articles -> collapse();
        $articles = $articles -> sortByDesc('created_at') 
            -> where('created_at', '>', now()->subDays(6));

        $articles = CollectionPaginateController::paginate($articles);

        if($request -> ajax()) {
            $view = view('article.partials.articles-detailed', ['articles' => $articles])->render();
            return response()->json(['html' => $view]);
        }

        return view('profile.index', [
            "articles" => $articles
        ]);

    }

    public function toggleVisibility(){
        $user = auth()->user();

        if ($user->role_id === 3){
            $user->update([
                'visibility' => !$user->visibility
            ]);
        }
            
        return redirect()->back();
    }
}
