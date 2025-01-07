<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    public function materiels()
    {
        return $this->hasMany(Material::class);
    }

    public function bonDechargesCede()
    {
        return $this->hasMany(Bon_Decharge::class, 'cedant_id');
    }

    public function bonDechargesRecu()
    {
        return $this->hasMany(Bon_Decharge::class, 'cessionnaire_id');
    }

    public function avisMvtsCede()
    {
        return $this->hasMany(Avis_Mvt::class, 'cedant_id');
    }

    public function avisMvtsRecu()
    {
        return $this->hasMany(Avis_Mvt::class, 'cessionnaire_id');
    }
}