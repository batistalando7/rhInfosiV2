<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Infrastructure extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'infrastructures';
    protected $guarded = ['id'];

    public function supplier(){

        return $this->belongsTo(Supplier::class, "supplierId");
        
    }

    public function infrastructure_moviments() {

        return $this->hasMany(InfrastructureMoviments::class, 'infrastructureId');
    }
}
