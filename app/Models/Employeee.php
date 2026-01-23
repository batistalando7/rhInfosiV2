<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Employeee extends Authenticatable implements CanResetPasswordContract
{
    use Notifiable, CanResetPassword;

    protected $table = "employeees";
    protected $guarded = ['id'];

    protected $hidden = [
        "password",
        "remember_token",
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, "departmentId");
    }

    public function position()
    {
        return $this->belongsTo(Position::class, "positionId");
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class, "specialtyId");
    }

    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class, "employeeTypeId");
    }

    public function employeeCategory()
    {
        return $this->belongsTo(EmployeeCategory::class, "employeeCategoryId");
    }

    public function course()
    {
        return $this->belongsTo(Course::class, "courseId");
    }

    public function retirement()
    {
        return $this->hasOne(Retirement::class, "employeeId");
    }

    public function secondments()
    {
        return $this->hasMany(Secondment::class, 'employeeId');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, "employeeId");
    }


    public function positionHistories()
    {
        return $this->hasMany(PositionHistory::class, "employeeId")
                    ->with("position")
                    ->orderByDesc("startDate");
    }

    // relacionamento entre employeee e historico de funcionário
    public function employeeHistories()
    {
        return $this->hasMany(EmployeeHistory::class, 'employeeId');
    }


// Trabalhos Extras dos quais este funcionário participou.

    public function extraJobs()
    {
        return $this->belongsToMany(
            ExtraJob::class,
            "extra_job_employees",
            "employeeId",
            "extraJobId"
        )
        ->withPivot("bonusAdjustment","assignedValue")
        ->withTimestamps();
    }


     //Relaçionamento(vinculo) entre Employeee e Driver.
    // Por um funcionário poder ser um motorista, então a relação é de um para muitos.

    public function drivers()
    {
        return $this->hasMany(Driver::class, "employeeId");
    }

    //relacionamento employeee com mobilety
    public function mobilities()
    {
        return $this->hasMany(Mobility::class, 'employeeId');
    }

    //relacionamento com salarypayment
    public function salaryPayments()
    {
        return $this->hasMany(SalaryPayment::class, 'employeeId');
    }


     // Veículos que este funcionário conduziu (através de Driver e pivot).

    public function vehicles()
    {
        return $this->hasManyThrough(
            Vehicle::class,
            Driver::class,
            "employeeId", // FK em drivers
            "id",         // PK em vehicles
            "id",         // FK local employeees.id
            "id"          // PK em drivers.id
        );
    }
}