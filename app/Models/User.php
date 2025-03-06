<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'profile_picture_path',
        'name',
        'first_name',
        'birthdate',
        'email',
        'email_verified_at',
        'password',
        'promotion_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function wishlists()
    {
        return $this->belongsToMany(Offer::class, 'wishlists');
    }

    public function applies()
    {
        return $this->belongsToMany(Offer::class, 'applies')->withPivot('created_at', 'curriculum_vitae', 'cover_letter');
    }

    public function evaluations()
    {
        return $this->belongsToMany(Company::class, 'evaluates')->withPivot('rating');
    }
}
