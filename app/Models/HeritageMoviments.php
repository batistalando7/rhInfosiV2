<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeritageMoviments extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'heritage_moviments';
    
    protected $guarded = ['id'];

    public function heritage(){
        
        return $this->belongsTo(Heritage::class, 'heritageId');
    }
}
