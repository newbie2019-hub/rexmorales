<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trackreads extends Model
{
    use HasFactory;

    protected $fillable = [
        'booktitle',
        'genre',
        'author',
        'synopsis',
        'rating',
        'review',
        'status',
        'user_id',
    ];
}
