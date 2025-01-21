<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'from_service_id',
        'to_service_id',
        'moved_at',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function fromService()
    {
        return $this->belongsTo(Service::class, 'from_service_id');
    }

    public function toService()
    {
        return $this->belongsTo(Service::class, 'to_service_id');
    }
}