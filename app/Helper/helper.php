<?php

use App\Models\{player, playercategury, soldplayer, team};

function maxBid($team_id)
{
    $teamData = team::where('id',$team_id)->first()->toArray();
    $minimumCateguryPoint = playercategury::min('points');
    $blankSoldPlayerFild = 12 - soldplayer::where('teams_id', $team_id)->count();
    $dudecation = $teamData['totale_points'] - $minimumCateguryPoint * $blankSoldPlayerFild + $minimumCateguryPoint;
    // dd($teamData['totale_points']);
    return $dudecation;
}
