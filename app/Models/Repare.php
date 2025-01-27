<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repare extends Model
{
    use HasFactory;
    protected $fillable = ['material_id', 'motif', 'date_reparation', 'qte', 'designation'];

    public function materiel()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
