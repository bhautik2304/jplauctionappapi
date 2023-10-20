<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,Builder};

class player extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('player', function (Builder $builder) {
            return $builder->with(['playercategurie']);
        });
    }

    protected $fillable = [
        "player_no",
        "name",
        "mobaile",
        "image",
        "skill",
        "sold",
        "playercategurie_id",
    ];

    public function playercategurie()
    {
        return $this->belongsTo(playercategury::class, 'playercategurie_id', 'id');
    }
    public function soldplayer()
    {
        return $this->hasMany(soldplayer::class, 'players_id', 'id');
    }
    public function sold($id)
    {
        $this->find($id)->update(['sold'=>1]);
    }
}
