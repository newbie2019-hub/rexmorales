<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class grocerylists extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'list',
        'user_id',
    ];
}
