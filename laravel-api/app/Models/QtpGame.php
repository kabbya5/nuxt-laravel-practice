<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QtpGame extends Model
{
    use HasFactory;

    protected $table = 'w_qtpgames';

    protected $fillable = [
        'gametitle',
        'gameid',
        'description',
        'provider_id',
        'category_id',
        'position',
        'status',
        'image'
    ];
}