<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocieteMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'societe_id',
        'material_id',
        'numero_marche',
        'numero_bl',
        'PV',
        'CPS',
        'observation',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    public function societe()
    {
        return $this->belongsTo(Societe::class);
    }
}