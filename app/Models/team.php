<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,Builder};

class team extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('teams', function (Builder $builder) {
            return $builder->with(['soldplayer']);
        });
    }

    protected $fillable = [
        "owner_name",
        "team_name",
        "logo",
        "totale_points",
        "max_bid_points",
    ];

    public function soldplayer(){
        return $this->hasMany(soldplayer::class,'teams_id','id');
    }
}
