<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthorFollowerController extends Controller
{

    public function follow(User $user){
        $follower = User::findOrFail(auth() -> id());
        $follower -> toggleFollow($user);

        return back();
    }
    
}
