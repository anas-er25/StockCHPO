<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'hopital_id', 'parent_id', 'type'];

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

    public function materialHistories()
    {
        return $this->hasMany(MaterialHistory::class);
    }

    public function repares()
    {
        return $this->hasMany(Repare::class);
    }

    public function hopital()
    {
        return $this->belongsTo(Hopital::class);
    }

    // Define the relationship for sub-services
    public function parent()
    {
        return $this->belongsTo(Service::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Service::class, 'parent_id');
    }
}