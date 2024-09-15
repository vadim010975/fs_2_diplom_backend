<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'duration',
        'poster_url',
        'country',
        'description',
        'start_date',
        'end_date',
    ];

    public function seances(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Seance::class);
    }
}
