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
        $soldplayer = soldplayer::where('sold_status', true)->with(['players','teams'])->get();
        return response(["soldplayer" => $soldplayer]);
    }
    public function soldPlayer(Request $req)
    {
        $soldplayer = soldplayer::where([['sold_status', false], ['teams_id', $req->teams_id]])->first();
        $soldplayer->update([
            "players_id" => $req->players_id,
            "sold" => $req->sold,
            "sold_status" => true,
        ]);

        $team = team::where('id',$req->teams_id)->first();
        // dd($team->totale_points - $req->sold);
        team::where('id',$req->teams_id)->update(['totale_points' => ($team->totale_points - $req->sold)]);
        team::where('id',$req->teams_id)->update(['max_bid_points' => maxBid($req->teams_id)]);
        player::where('id',$req->players_id)->update(['sold' => false]);
        // $player = new player;
        // $player->sold($req->players_id);
        event(new Uiupdate());
        return response(["msg" => "Player Sold Successfully."]);
    }

    public function destroy($id){
        $playerData=soldplayer::where('id',$id)->first();
        $teamData=team::where('id',$playerData->teams_id)->first();
        // $playerData=soldplayer::where('id',$id)->first();
        // dd($teamData->toArray());
        team::where('id',$playerData->teams_id)->update(['totale_points' => ($teamData->totale_points + $playerData->sold)]);
        team::where('id',$playerData->teams_id)->update(['max_bid_points' => maxBid($playerData->teams_id)]);
        $playerData->update([
            "players_id"=>null,
            "sold"=>null,
            "sold_status"=>false,
        ]);
        // dd($playerData->toArray());
        event(new Uiupdate());

        return response(["msg" => "Player Sold Successfully."]);
    }
}
