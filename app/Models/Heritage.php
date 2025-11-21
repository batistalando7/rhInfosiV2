<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Heritage extends Model
{
    protected $table = 'heritages';

    protected $fillable = [
        'Description', 'Type', 'Value', 'AcquisitionDate', 'Location',
        'ResponsibleId', 'Condition', 'Observations',
        'FormResponsibleName', 'FormResponsiblePhone', 'FormResponsibleEmail', 'FormDate'
    ];

    protected $casts = [
        'AcquisitionDate' => 'date',
        'FormDate' => 'date',
        'Value' => 'decimal:2',
    ];

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin::class, 'ResponsibleId');
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(HeritageMaintenance::class, 'HeritageId');
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(HeritageTransfer::class, 'HeritageId');
    }
}