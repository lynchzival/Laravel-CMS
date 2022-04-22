<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleLikeController;
use App\Http\Controllers\ArticleFavoriteController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AuthorFollowerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserController;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class, 'index']) 
-> name('home');
Route::get('/about', [IndexController::class, 'about']) 
-> name('about');
Route::get('/contact', [IndexController::class, 'contact']) 
-> name('contact');
Route::get('/search/{keyword?}', [SearchController::class, 'index'])
-> name('search');

Route::group([
    'middleware' => ['auth', 'verified']
], function(){
    Route::group([
        'middleware' => ['adminOrOwner']
    ], function(){

        /**
         * Article routes
         *
         * 
         */

        Route::resource('article', ArticleController::class, [
            'except' => ['show', 'index', 'create', 'store']
            /** only admin & owner can edit, delete, update article */
        ]);
        Route::group([
            'prefix' => 'article',
        ], function(){
            Route::get('/view/{article}', [ArticleController::class, 'view'])
            -> name('article.view');
        });

    });

    Route::group([
        'middleware' => ['adminOrAuthor']
    ], function(){

        /**
         * Article routes
         *
         * 
         */

        Route::resource('article', ArticleController::class, [
            'except' => ['update', 'destroy', 'edit', 'show']
            /** only admin & author can create article */
        ]);

        Route::get('/article/search/{keyword?}', [ArticleController::class, 'index'])
        -> name('article.search');

    });

    Route::group([
        'middleware' => ['admin']
    ], function(){

        /**
         * Article routes
         *
         * 
         */

        Route::get('/user/search/{keyword?}', [UserController::class, 'search'])
        -> name('user.search');

        Route::resource('user', UserController::class, [
            'except' => ['show', 'edit', 'update', 'destroy']
        ]);
        
        Route::resource('user', UserController::class, [
            'except' => ['show', 'create', 'store', 'index']
        ]) -> middleware('notMyself');

        Route::resource('category', CategoryController::class, [
            'except' => ['show']
        ]);
    });

    /**
     * Profile routes
     *
     * 
     */

    Route::group([
        'prefix' => 'profile',
    ], function(){
        Route::get('/', [ProfileController::class, 'index']) 
        -> name('profile');
        Route::get('/like', [ArticleLikeController::class, 'inProfile']) 
        -> name('profile.like');
        Route::get('/favorite', [ArticleFavoriteController::class, 'inProfile']) 
        -> name('profile.favorite');
        Route::get('/following', [AuthorFollowerController::class, 'inProfile']) 
        -> name('profile.follow');
        Route::view('/edit', 'profile.edit-profile') 
        -> name('profile.edit');
        Route::view('/privacy', 'profile.privacy') 
        -> name('profile.privacy');
        Route::view('/password/edit', 'profile.edit-password') 
        -> name('profile.password');
        Route::view('/two-factor/toggle', 'profile.toggle-two-factor') 
        -> name('profile.two-factor');

        Route::view('/subscription', 'profile.subscription') 
        -> name('profile.subscription')
        -> middleware('isSubscribed', 'reader');
        
        Route::post('/subscription/cancel', [PaymentController::class, 'destroy'])
        -> name('profile.subscription.cancel');
        Route::post('/subscription/resume', [PaymentController::class, 'resume'])
        -> name('profile.subscription.resume');

        Route::post('/privacy/toggleVisibility', [ProfileController::class, 'toggleVisibility'])
        -> name('profile.privacy.toggleVisibility');
    });

    /**
     * Category routes
     *
     * 
     */

    Route::resource('category', CategoryController::class, [
        'except' => ['show', 'index']
    ]);

    /**
     * Author routes
     *
     * 
     */

    Route::resource('author', AuthorController::class, [
        'except' => ['show', 'index']
    ]);

    /**
     * Payment routes
     *
     * 
     */

    Route::group([
        'middleware' => ['notSubscribed', 'reader']
    ], function(){
        Route::get('/payment', [PaymentController::class, 'index']) 
        -> name('payment.index');
        Route::get('/subscription', [PaymentController::class, 'plan']);
        Route::post('/payment', [PaymentController::class, 'store'])
        ->name('payment.store');
    });
});

/**
 * Article routes
 *
 * 
 */

Route::group([
    'prefix' => 'article',
], function(){
    Route::post('/like', [ArticleLikeController::class, 'like']);
    Route::post('/favorite', [ArticleFavoriteController::class, 'favorite']);    
    Route::get('/{article}', [ArticleController::class, 'show'])
    -> name('article.show');

    Route::post('/upload', [ArticleController::class, 'storeTinyMCEImg'])
    -> name('article.img.upload');
});

Route::group([
    'prefix' => 'category',
], function(){
    Route::get('/', [CategoryController::class, 'index'])
    -> name('category.index');
    Route::get('/{category}', [CategoryController::class, 'show'])
    -> name('category.show');
    Route::get('/{category}/search/{keyword?}', [CategoryController::class, 'show'])
    -> name('category.article.search');
});

Route::group([
    'prefix' => 'author',
], function(){
    Route::get('/', [AuthorController::class, 'index'])
    -> name('author.index');
    Route::get('/{user}', [AuthorController::class, 'show'])
    -> name('author.show');
    Route::get('/{user}/search/{keyword?}', [AuthorController::class, 'show'])
    -> name('author.article.search');

    Route::post('/{user}/follow', [AuthorFollowerController::class, 'follow'])
    -> name('author.follow');
});

Route::group([
    'prefix' => 'user',
], function(){
    Route::get('/{user}', [UserController::class, 'show'])
    -> name('user.show');
    Route::get('/{user}/like', [ArticleLikeController::class, 'fromUser'])
    -> name('user.like');
    Route::get('/{user}/following', [AuthorFollowerController::class, 'fromUser'])
    -> name('user.follow');
});