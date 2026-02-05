<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Heritage extends Model
{
    use HasFactory;

    protected $table = 'heritages';

    protected $guarded = ['id'];


    public function heritageType()
    {
        return $this->belongsTo(HeritageType::class, 'heritageTypeId');
    }
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplierId');
    }

}
