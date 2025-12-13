<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Heritage extends Model
{
    use HasFactory;

    protected $fillable = [
        'heritageTypeId',
        'Description',
        'Value',
        'AcquisitionDate',
        'Location',
        'ResponsibleName', // Corrigido para campo de texto
        'Condition',
        'Notes',
    ];

    protected $casts = [
        'AcquisitionDate' => 'date',
        'Value'           => 'float',
    ];

    public function type()
    {
        return $this->belongsTo(HeritageType::class, 'heritageTypeId');
    }

    public function maintenances()
    {
        return $this->hasMany(HeritageMaintenance::class, 'HeritageId')->orderBy('MaintenanceDate', 'desc');
    }

    public function transfers()
    {
        return $this->hasMany(HeritageTransfer::class, 'HeritageId')->orderBy('TransferDate', 'desc');
    }
    
    public function fullHistory()
    {
        $maintenances = $this->maintenances->map(function ($item) {
            $item->type = 'Manutenção';
            return $item;
        });

        $transfers = $this->transfers->map(function ($item) {
            $item->type = 'Transferência';
            return $item;
        });

        return $maintenances->merge($transfers)->sortByDesc(function ($item) {
            return $item->type === 'Manutenção' ? $item->MaintenanceDate : $item->TransferDate;
        });
    }
}
