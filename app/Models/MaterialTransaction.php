<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'MaterialId',
        'TransactionType', // 'Entrada' ou 'Saída'
        'Quantity',
        'TransactionDate',
        'OriginOrDestination',
        'DocumentationPath',
        'Notes',
        'CreatedBy', // FK para Employeee
    ];

    protected $casts = [
        'TransactionDate' => 'date',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class, 'MaterialId');
    }

    public function employee()
    {
        return $this->belongsTo(Employeee::class, 'CreatedBy');
    }
}
