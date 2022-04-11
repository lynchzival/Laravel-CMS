<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug'
    ];

    public function articles()
    {
        return $this->hasMany(Article::class)->orderBy('created_at', 'desc');
    }

    public function popularArticles()
    {
        return $this->hasMany(Article::class)->orderBy('view_count', 'desc');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
