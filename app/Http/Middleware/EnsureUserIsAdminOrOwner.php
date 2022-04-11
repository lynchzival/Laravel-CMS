<?php

namespace App\Http\Middleware;

use App\Models\Article;
use Closure;
use Illuminate\Http\Request;
use App\Scopes\ArticlePublishedScope;

class EnsureUserIsAdminOrOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $slug = $request->route('article');
        $article = Article::withoutGlobalScope(ArticlePublishedScope::class) 
            -> where('slug', $slug)
            -> firstOrFail();

        if ($article->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
