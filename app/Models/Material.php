<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'num_inventaire',
        'designation',
        'qte',
        'type',
        'origin',
        'marque',
        'modele',
        'num_serie',
        'date_inscription',
        'date_affectation',
        'service_id',
        'observation',
        'etat',
        'numero_marche',
        'numero_bl',
        'nom_societe'
    ];
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function societe(){
        return $this->belongsTo(Societe::class);
    }

    public function feuilleReformes()
    {
        return $this->hasMany(FeuilleReforme::class);
    }

    public function bonDecharges()
    {
        return $this->hasMany(Bon_Decharge::class);
    }

    public function avisMvts()
    {
        return $this->hasMany(Avis_Mvt::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class, 'record_id');
    }

    public function materialHistories()
    {
        return $this->hasMany(MaterialHistory::class);
    }
}