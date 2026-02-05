<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'suppliers';
    protected $guarded = ['id'];

    public function infrastructure(){

        return $this->hasMany(Infrastructure::class, "supplierId");
    }
    
    public function heritage(){

        return $this->hasMany(Heritage::class, "supplierId");
    }
}
