<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeHistory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'employee_histories';
    protected $guarded = ['id'];

    public function employee()
    {
        return $this->belongsTo(Employeee::class, 'employee_id', 'id');
    }
}
