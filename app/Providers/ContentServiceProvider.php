<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ContentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        if (Schema::hasTable('categories')) {
            $this->categoryItems = Category::all();
            
            view()->composer('main.index', function($view) {
                $view->with(['categories' => $this->categoryItems]);
            });
        }
    }
}
