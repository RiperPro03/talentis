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

    public function users(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(User::class,'address_id', 'id');
    }

    public function companies(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Company::class,'locates');
    }
}
