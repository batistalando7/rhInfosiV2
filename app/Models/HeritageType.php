<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeritageType extends Model
{
    use HasFactory;

    protected $table = 'heritage_types';

    protected $guarded = ['id'];

    public function heritages()
    {
        return $this->hasMany(Heritage::class, 'heritageTypeId');
    }
}
