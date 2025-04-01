<?php

namespace App\Models;

use Database\Factories\PromotionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    /** @use HasFactory<PromotionFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'promotion_code',
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class, 'promotion_id', 'id');
    }
    protected static function booted()
    {
        static::deleting(function ($promotion) {
            // Met à jour les étudiants pour qu'ils n'aient plus de promotion
            $promotion->users()->update(['promotion_id' => null]);
        });
    }
}
