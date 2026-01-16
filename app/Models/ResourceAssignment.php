<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourceAssignment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'resource_assignments';
    protected $guarded = ['id'];

    public function employeee()
    {
        return $this->belongsTo(Employeee::class, 'employeeeId');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicleId');
    }
}
