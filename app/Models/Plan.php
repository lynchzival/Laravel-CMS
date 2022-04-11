<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'stripe_id',
        'stripe_name',
        'stripe_price',
        'price',
        'abbreviation',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
