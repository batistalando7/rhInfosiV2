<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HeritageTransfer extends Model
{
    protected $table = 'heritage_transfers';

    protected $fillable = [
        'HeritageId',
        'TransferDate',
        'TransferReason',
        'TransferResponsible',
    ];

    protected $casts = [
        'TransferDate' => 'date',
    ];

    public function heritage(): BelongsTo
    {
        return $this->belongsTo(Heritage::class, 'HeritageId');
    }
}