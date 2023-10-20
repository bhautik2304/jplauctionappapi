<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, Builder};

class soldplayer extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('soldplayer', function (Builder $builder) {
            return $builder->with(['players']);
        });
    }

    protected $fillable = [
        "no",
        "players_no",
        "players_id",
        "teams_id",
        "sold",
        "sold_status",
    ];

    public function players()
    {
        return $this->belongsTo(player::class, 'players_id', 'id');
    }
    public function teams()
    {
        return $this->belongsTo(team::class, 'teams_id', 'id');
    }
}
