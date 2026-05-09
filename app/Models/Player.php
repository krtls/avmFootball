<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    /** @use HasFactory<\Database\Factories\PlayerFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'shot_speed_kmh',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'shot_speed_kmh' => 'decimal:1',
        ];
    }
}
