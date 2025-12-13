<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeritageTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'HeritageId',
        'TransferDate',
        'Reason',
        'ResponsibleName', // Corrigido para campo de texto (Quem Autorizou/Executou)
        'OriginLocation',
        'DestinationLocation',
        'TransferredToName', // Corrigido para campo de texto (Quem Recebeu)
    ];

    protected $casts = [
        'TransferDate' => 'date',
    ];

    public function heritage()
    {
        return $this->belongsTo(Heritage::class, 'HeritageId');
    }
}
