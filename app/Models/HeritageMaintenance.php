<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HeritageMaintenance extends Model
{
    protected $table = 'heritage_maintenances';

    protected $fillable = [
        'HeritageId',
        'MaintenanceDate',
        'MaintenanceDescription',
        'MaintenanceResponsible',
    ];

    protected $casts = [
        'MaintenanceDate' => 'date',
    ];

    public function heritage(): BelongsTo
    {
        return $this->belongsTo(Heritage::class, 'HeritageId');
    }
}