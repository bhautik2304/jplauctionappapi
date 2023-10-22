<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{player, soldplayer, team};
use App\Events\Uiupdate;

class SoldplayerController extends Controller
{
    //
    public function index()
    {
        $soldplayer = soldplayer::with(['players', 'teams'])->get();
        return response(["soldplayer" => $soldplayer]);
    }
    public function soldPlayer(Request $req)
    {
        $soldplayer = new soldplayer;
        $soldplayer->players_id = $req->players_id;
        $soldplayer->sold = $req->sold;
        $soldplayer->teams_id=$req->teams_id;
        $soldplayer->save();


        $team = team::where('id', $req->teams_id)->first();
        // dd($team->totale_points);
        // dd($team->totale_points - $req->sold);
        team::where('id', $req->teams_id)->update(['totale_points' => ($team->totale_points - $req->sold)]);
        team::where('id', $req->teams_id)->update(['max_bid_points' => maxBid($req->teams_id)]);
        player::where('id', $req->players_id)->update(['sold' => false]);
        // $player = new player;
        // $player->sold($req->players_id);
        event(new Uiupdate());
        return response(["msg" => "Player Sold Successfully."]);
    }

    public function destroy($id)
    {
        $soldplayerData = soldplayer::where('id', $id)->first();
        $teamData = team::where('id', $soldplayerData->teams_id)->first();
        // dd($soldplayerData->teams_id);
        // $playerData=soldplayer::where('id',$id)->first();
        // dd($teamData->toArray());
        team::where('id', $soldplayerData->teams_id)->update(['totale_points' => ($teamData->totale_points + $soldplayerData->sold)]);
        team::where('id', $soldplayerData->teams_id)->update(['max_bid_points' => maxBid($soldplayerData->teams_id)]);
        soldplayer::destroy($id);
        // dd($playerData->toArray());
        event(new Uiupdate());
        return response(["msg" => "Player Sold Successfully."]);
    }


    public function update(Request $req, $id)
    {

        // sold player reverse entry
        $soldplayerData = soldplayer::where('id', $id)->first();
        $teamData = team::where('id', $soldplayerData->teams_id)->first();
        team::where('id', $soldplayerData->teams_id)->update(['totale_points' => ($teamData->totale_points + $soldplayerData->sold)]);
        team::where('id', $soldplayerData->teams_id)->update(['max_bid_points' => maxBid($soldplayerData->teams_id)]);

        $player=player::where('id',$soldplayerData->players_id)->update(['sold'=>true]);


        // sold player update entry
        $teamData = team::where('id', $req->teams_id)->first();
        team::where('id', $soldplayerData->teams_id)->update(['totale_points' => ($teamData->totale_points - $req->sold)]);
        team::where('id', $soldplayerData->teams_id)->update(['max_bid_points' => maxBid($soldplayerData->teams_id)]);

        $soldplayerData->update([
            'players_id' => $req->players_id,
            'sold' => $req->sold,
            'sold_status' => $req->sold_status,
            'teams_id' => $req->teams_id,
        ]);

        $player=player::where('id',$req->players_id)->update(['sold'=>true]);

        // dd($playerData->toArray());
        event(new Uiupdate());
        return response(["msg" => "Player Sold Successfully."]);
    }
}
