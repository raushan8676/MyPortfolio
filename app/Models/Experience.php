<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'deliverables' => 'array',
        'responsibilities' => 'array',
        'tags' => 'array',
        'technologies' => 'array',
        'is_current' => 'boolean',
        'sort_order' => 'integer',
    ];
}
