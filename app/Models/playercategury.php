<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class playercategury extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "points",
    ];

    public function player(){
        return $this->hasMany(player::class,'playercategurie_id','id');
    }
}
