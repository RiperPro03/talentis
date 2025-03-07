<?php

namespace App\Models;

use Database\Factories\IndustryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    /** @use HasFactory<IndustryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function companies(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }
}
