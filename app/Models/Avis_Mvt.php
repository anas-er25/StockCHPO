<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis_Mvt extends Model
{
    use HasFactory;

    protected $fillable = ['material_id', 'qte', 'cedant_id', 'cessionnaire_id', 'motif'];

    public function materiel()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }


    public function cedant()
    {
        return $this->belongsTo(Service::class, 'cedant_id');
    }

    public function cessionnaire()
    {
        return $this->belongsTo(Service::class, 'cessionnaire_id');
    }
}