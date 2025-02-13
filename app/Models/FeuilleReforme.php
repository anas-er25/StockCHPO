<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeuilleReforme extends Model
{
    use HasFactory;

    protected $fillable = ['material_id', 'motif', 'date_reforme', 'qte', 'designation'];

    public function materiel()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}