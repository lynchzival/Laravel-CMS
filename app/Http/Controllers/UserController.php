<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::orderBy('created_at', 'desc') -> paginate(5);

        if($request -> ajax()) {
            $view = view('user._load', ['users' => $users])->render();
            return response()->json(['html' => $view]);
        }

        return view("user.index", [
            "users" => $users
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search($keyword=null, Request $request)
    {

        $role_id = Role::select('id') -> where('name', $keyword) -> first();

        $users = User::orderBy('created_at', 'desc') -> where('name', 'like', '%'.$keyword.'%')
            -> orWhere('email', 'like', '%'.$keyword.'%')
            -> orWhere('role_id', $role_id -> id ?? null)
            -> paginate(5);

        if($request -> ajax()) {
            $view = view('user._load', ['users' => $users])->render();
            return response()->json(['html' => $view]);
        }

        return view("user.index", [
            "users" => $users,
            "keyword" => $keyword
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("user.create",[
            "roles" => Role::all()
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
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|integer'
        ]);

        User::create([
            'name' => $request -> name,
            'email' => $request -> email,
            'password' => bcrypt($request -> password),
            'role_id' => $request -> role_id
        ]);

        return redirect() -> route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Request $request)
    {
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
        $followings = $user->followings;
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
        
        return view('user.show', [
            'user' => $user,
            'articles' => $articles
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit', [
            'user' => $user,
            'roles' => Role::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role_id' => 'required|integer'
        ]);

        if ($request -> email != $user -> email) {
            $user -> forceFill(['email_verified_at' => null]);
        }

        $user -> update([
            'name' => $request -> name,
            'email' => $request -> email,
            'role_id' => $request -> role_id
        ]);

        return redirect() -> route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user -> delete();
        return redirect() -> route('user.index');
    }
}
