<?php

namespace App\Models;

use Database\Factories\IndustryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Industry extends Model
{
    /** @use HasFactory<IndustryFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function companies(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Company::class,'works');
    }
}
