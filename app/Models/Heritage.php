<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Heritage extends Model
{
    use HasFactory;

    protected $table = 'heritages';

    protected $guarded = ['id'];


    public function type()
    {
        return $this->belongsTo(HeritageType::class, 'heritageTypeId');
    }

}
