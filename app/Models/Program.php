<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'icon', 'image', 'is_featured', 'sort_order'];
    
    protected $casts = [
        'is_featured' => 'boolean',
    ];
}
