<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Overtrue\LaravelLike\Traits\Liker;
use Overtrue\LaravelFavorite\Traits\Favoriter;
use Laravelista\Comments\Commentable;
use Laravel\Cashier\Billable;
use Overtrue\LaravelFollow\Followable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, 
    HasFactory, 
    Notifiable, 
    TwoFactorAuthenticatable, 
    Billable, 
    Liker, 
    Favoriter,
    Commentable,
    Followable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'line1',
        'line2',
        'city',
        'state',
        'postal_code',
        'country',
        'role_id',
        'visibility'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    /**
     * The scope functions.
     *
     *
     */
    public function scopeVisible($query)
    {
        return $query->where('visibility', true);
    }

    public function scopeAdmin($query)
    {
        return $query->where('role_id', 1);
    }

    public function scopeAuthor($query)
    {
        return $query->where('role_id', 2);
    }

    public function scopeReader($query)
    {
        return $query->where('role_id', 3);
    }


    /**
     * The relationship functions.
     *
     *
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    // articles without globalscopes

    public function articlesWithoutGlobalScopes()
    {
        return $this->hasMany(Article::class)->withoutGlobalScopes();
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function popularArticles()
    {
        return $this->hasMany(Article::class)->orderBy('view_count', 'desc');
    }


    /**
     * The check functions.
     *
     *
     */
    public function isAdmin(){
        return $this->role_id === 1;
    }

    public function isAuthor(){
        return $this->role_id === 2;
    }

    public function isReader(){
        return $this->role_id === 3;
    }

    public function isOwner($article){
        return $this->id === $article->user_id;
    }


    /**
     * The get functions.
     *
     *
     */
    public function getTotalArticles()
    {
        return $this->articles()->count();
    }

    public function getCreatedAt()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function getProfileImg()
    {
        $default_profile = "https://avatars.dicebear.com/api/initials/$this->name.svg";
        return $this->profile_img ? asset($this->profile_img) : $default_profile;
    }

    public function getRoleColor(){
        return ($this->isAdmin()) ? 'danger' : (($this->isAuthor()) ? 'warning' : 'dark');
    }

}
