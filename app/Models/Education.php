<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'education';

    protected $guarded = [];

    protected $casts = [
        'courses' => 'array',
        'highlights' => 'array',
        'tags' => 'array',
        'is_current' => 'boolean',
        'sort_order' => 'integer',
    ];
}
