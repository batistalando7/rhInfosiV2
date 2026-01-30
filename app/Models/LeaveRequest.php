<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employeeId',
        'departmentId',
        'leaveTypeId',
        'leaveStart',
        'leaveEnd',
        'reason',
        'approvalStatus',
        'approvalComment',
    ];

    public function employee()
    {
        return $this->belongsTo(Employeee::class, 'employeeId');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'departmentId');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leaveTypeId');
    }
    
    /* start Função para calcular o intervalo entre as data leave start e leave end */
    public function getDurationAttribute()
    {
        return \Carbon\Carbon::parse($this->leaveStart)
            ->diffInDays($this->leaveEnd) + 1;
    }
    /* start Função para calcular o intervalo entre as data leave start e leave end */
}
