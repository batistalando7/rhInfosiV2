<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    protected $fillable = [
        'Category', // Sempre 'infraestrutura'
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
        'EntryDate'       => 'date',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(MaterialType::class, 'materialTypeId');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(MaterialTransaction::class, 'MaterialId');
    }
}