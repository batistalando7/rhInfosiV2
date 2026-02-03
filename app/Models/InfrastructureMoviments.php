<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InfrastructureMoviments extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'infrastructure_moviments';

    protected $guarded = ['id'];

    public function infrastructure() {
        
        return $this->belongsTo(Infrastructure::class, 'infrastructureId');
    }
}
