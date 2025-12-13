<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'materialTypeId',
        'Name',
        'SerialNumber',
        'Model',
        'ManufactureDate',
        'SupplierName',
        'SupplierIdentifier',
        'EntryDate',
        'CurrentStock',
        'Notes',
    ];

    protected $casts = [
        'ManufactureDate' => 'date',
        'EntryDate' => 'date',
    ];

    public function type()
    {
        return $this->belongsTo(MaterialType::class, 'materialTypeId');
    }

    public function transactions()
    {
        return $this->hasMany(MaterialTransaction::class, 'MaterialId')->orderBy('TransactionDate', 'desc');
    }
}
