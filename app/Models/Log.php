<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'table_name',
        'record_id',
        'performed_by',
        'performed_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    public function materiel()
    {
        return $this->belongsTo(Material::class, 'record_id');
    }
}