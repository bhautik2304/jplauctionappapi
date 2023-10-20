<?php

namespace App\Http\Controllers;

use App\Events\Uiupdate;
use App\Models\soldplayer;
use App\Models\team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response(["team" => team::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $team = new team;
        $team->owner_name = $request->owner_name;
        $team->team_name = $request->team_name;
        $team->totale_points = $request->totale_points;
        $team->save();

        $i = 1;

        while ($i <= 12) {
            # code...
            $soldplayer = new soldplayer;
            $soldplayer->players_no=$i;
            $soldplayer->teams_id=$team->id;
            $soldplayer->save();

            $i++;
        }

        $team->find($team->id)->update([
            "max_bid_points"=>maxBid($team->id)
        ]);
        event(new Uiupdate());
        return response(["msg" => "Team Created Successfully."], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, team $teams, $id)
    {
        //
        $teams->find($id)->update([
            "owner_name" => $request->owner_name,
            "team_name" => $request->team_name,
            "totale_points" => $request->totale_points,
        ]);
        $teams->where('id',$id)->update([
            "max_bid_points" => maxBid($id),
        ]);
        event(new Uiupdate());
        return response(["msg" => "Team Updated Successfully."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(team $teams, $id)
    {
        //
        $teams->destroy($id);
        soldplayer::where('teams_id',$id)->delete();
        event(new Uiupdate());
        return response(["msg" => "Team Deleted Successfully."]);
    }
}

// "owner_name":"",
// "owner_mobaile":"",
// "totale_points":""
