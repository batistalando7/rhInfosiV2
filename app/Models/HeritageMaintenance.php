<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeritageMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'HeritageId',
        'MaintenanceDate',
        'Description',
        'ResponsibleName', // Corrigido para campo de texto
        'MaintenanceCost',
    ];

    protected $casts = [
        'MaintenanceDate' => 'date',
        'MaintenanceCost' => 'float',
    ];

    public function heritage()
    {
        return $this->belongsTo(Heritage::class, 'HeritageId');
    }
}
