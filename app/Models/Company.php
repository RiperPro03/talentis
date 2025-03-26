<?php

namespace App\Models;

use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    /** @use HasFactory<CompanyFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'logo_path',
        'description',
        'email',
        'phone_number'
    ];

    public function offers(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Offer::class, 'company_id', 'id');
    }


    public function industries(): Company|\Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Industry::class,'works');
    }

    public function addresses(): Company|\Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Address::class,'locates');
    }

    public function evaluations(): User|\Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class,'evaluates')->withPivot('rating')->withTimestamps();
    }

    private function averageRating()
    {
        return $this->evaluations()->avg('rating') ?? 0;
    }

    public function getRate(): float
    {
        return round($this->averageRating());
    }

    public function latestOffers(int $limit = 3)
    {
        return $this->offers()->latest()->limit($limit)->get();
    }

}
