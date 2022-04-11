<?php

namespace App\Models;

use App\Scopes\ArticleOrderByNewest;
use App\Scopes\ArticlePublishedScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Laravelista\Comments\Commentable;
use Illuminate\Support\Str;
use Coduo\PHPHumanizer\NumberHumanizer;
use Carbon\Carbon;

class Article extends Model
{
    use HasFactory, 
    Likeable,
    Favoriteable,
    Commentable;

    protected $fillable = [
        'title', 
        'content',
        'category_id',
        'user_id',
        'thumbnail',
        'slug',
        'view_count',
        'pinned',
        'pinned_at',
        'published',
        'comment_status',
        'is_premium',
    ];


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new ArticleOrderByNewest);
        static::addGlobalScope(new ArticlePublishedScope);
    }


    /**
     * The relationship functions.
     *
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function next()
    {
        return $this->where('id', '>', $this->id) -> where('category_id', $this->category_id) -> where('published', true)
            -> orderBy('id', 'asc') -> first();
    }

    public function previous()
    {
        return $this->where('id', '<', $this->id) -> where('category_id', $this->category_id) -> where('published', true)
            -> orderBy('id', 'desc') -> first();
    }


    /**
     * The check functions.
     *
     *
     */

    public function isPinned(){
        return $this -> pinned === 1 && $this -> pinned_at > now()->subDays(7);
    }


    /**
     * The scope functions.
     *
     *
     */

    public function scopePinned($query)
    {
        return $query -> where('pinned', 1) -> where('pinned_at', '>', now() -> subDays(7));
    }

    /**
     * The get functions.
     *
     *
     */
    public function likeCount()
    {
        $suffix = Str::plural(' like', $this->likers()->count());
        return NumberHumanizer::metricSuffix($this -> likers() -> count()) . $suffix;
    }

    public function viewCount()
    {
        $suffix = Str::plural(' view', $this->view_count);
        return NumberHumanizer::metricSuffix($this->view_count) . $suffix;
    }
    
    function publishedAt()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function brief($length = 100)
    {
        return Str::limit($this->content, $length);
    }

    public function getThumbnail()
    {
        $category = $this->category;
        // asset('img/no_thumb.jpg')
        $unplash = "https://source.unsplash.com/random?$category->name&sig=$this->id";
        return $this->thumbnail ? asset($this->thumbnail) : $unplash;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
