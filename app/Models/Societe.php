<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Societe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_societe',
        'numero_marche',
        'numero_bl',
        'PV',
        'CPS',
        'siege_social',
        'telephone',
        'nombre_articles',
        'observation'
    ];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function societeMaterials()
    {
        return $this->hasMany(SocieteMaterial::class);
    }
}
