<?php

namespace App\Http\Controllers;

use App\Events\Uiupdate;
use App\Models\soldplayer;
use App\Models\team;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

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

        try {
            //code...
            $imagePath = $request->file('logo')->store('teamlogo', 'public');
            $team = new team;
            $team->owner_name = $request->input('owner_name');
            $team->team_name = $request->input('team_name');
            $team->logo = asset('storage/' . $imagePath);
            $team->totale_points = $request->input('totale_points');
            $team->save();

            $team->find($team->id)->update([
                "max_bid_points" => maxBid($team->id)
            ]);
            event(new Uiupdate());
            return response(["msg" => "Team Created Successfully."], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response(["msg" => "Error Accurd"], 200);
        }
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

        try {
            //code...

            // dd($request);

            if ($request->hasFile('logo')) {
                $imagePath = $request->file('logo')->store('player', 'public');
                $teams->find($id)->update([
                    "logo" =>  asset('storage/' . $imagePath),
                ]);
            }

            $teams->where('id',$id)->update([
                "owner_name" => $request->owner_name,
                "team_name" => $request->team_name,
                "totale_points" => $request->totale_points,
            ]);
            $teams->where('id', $id)->update([
                "max_bid_points" => maxBid($id),
            ]);
            event(new Uiupdate());
            return response(["msg" => "Team Updated Successfully."], 200);
            // return response(["msg" => "Team Updated Successfully."]);
        } catch (\Throwable $th) {
            //throw $th;
            return response(["msg" => $th], 500);
        }
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
        soldplayer::where('teams_id', $id)->delete();
        event(new Uiupdate());
        return response(["msg" => "Team Deleted Successfully."]);
    }
}
