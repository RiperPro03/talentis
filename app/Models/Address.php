<?php

namespace App\Models;

use Database\Factories\AddressFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    /** @use HasFactory<AddressFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'postal_code',
        'city',
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function companies(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Company::class,'locates');
    }
    public function addresses(): \Illuminate\Database\Eloquent\Relations\BelongsTo

    {
        return $this->belongsTo(User::class,'lives');
    }
}
