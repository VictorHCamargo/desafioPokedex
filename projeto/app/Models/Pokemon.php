<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $table = 'pokemons';

    protected $fillable = [
        'name',
        'status',
        'types',
        'image_url',
    ];
    
    protected $casts = [
        'status' => 'array',
        'types' => 'array',
    ];
}
