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
    protected static function booted()
    {
        static::deleting(function ($address) {
            // Met à jour les étudiants pour qu'ils n'aient plus d'adresse
            $address->users()->update(['address_id' => null]);

            // Met à jour les entreprises pour qu'elles n'aient plus d'adresse
            $address->companies()->update(['address_id' => null]);

            // Met à NULL company_id dans la table de jointure locates
            \DB::table('locates')->where('address_id', $address->id)->update(['company_id' => null]);
        });


        static::restoring(function ($address) {
            // Optionnel : Restaurer company_id si l'adresse est restaurée
            $locates = \DB::table('locates')
                ->whereNull('company_id')
                ->where('address_id', $address->id)
                ->get();

            foreach ($locates as $locate) {
                $company = \DB::table('companies')->where('id', $locate->company_id)->first();
                if ($company) {
                    \DB::table('locates')->where('address_id', $address->id)->update(['company_id' => $company->id]);
                }
            }
        });
}


}
