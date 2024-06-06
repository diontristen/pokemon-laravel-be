<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date_received',
        'price',
        'condition',
        'pokemon_tcg_id',
        'pokemon_tcg_data',
        'pieces',
        'remarks',
        'user_id',
    ];

    protected $casts = [
        'price' => 'float',
        'pokemon_tcg_data' => 'array',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
