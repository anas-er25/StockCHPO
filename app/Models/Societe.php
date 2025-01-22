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
        'CPS'
    ];

    public function materials(){
        return $this->hasMany(Material::class);
    }
}