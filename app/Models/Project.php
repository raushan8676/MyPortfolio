<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'features' => 'array',
        'tags' => 'array',
        'technologies' => 'array',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];
}
