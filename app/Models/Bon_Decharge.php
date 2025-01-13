<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bon_Decharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'qte',
        'num_serie',
        'cedant_id',
        'cessionnaire',
        'motif'
    ];

    public function materiel()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function cedant()
    {
        return $this->belongsTo(Service::class, 'cedant_id');
    }
}