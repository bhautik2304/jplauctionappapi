<?php

namespace App\Http\Controllers;

use App\Models\player;
use Illuminate\Http\Request;
use App\Events\Uiupdate;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response(["player" => player::all()], 200);
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
        $imagePath = $request->file('image')->store('player', 'public');
        $data = json_decode($request->data);
        $player = new player;
        $player->player_no = $data->player_no;
        $player->name = $data->name;
        $player->mobaile = $data->mobaile;
        $player->image =  asset('storage/' . $imagePath);
        $player->skill = $data->skill;
        $player->playercategurie_id = $data->playercategurie_id;
        $player->save();

        event(new Uiupdate());

        return response(["msg" => "Player Created Successfully"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(player $player)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\player  $player
     * @return \Illuminate\Http\Response
     */
    public function edit(player $player)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, player $players)
    {
        //
        $players->find($id)->update([
            "player_no" => $request->player_no,
            "name" => $request->name,
            "mobaile" => $request->mobaile,
            // "image"=>$request->image,
            "skill" => $request->skill,
            "playercategurie_id" => $request->playercategurie_id,
        ]);

        event(new Uiupdate());

        return response(["msg" => "Player Updated Successfully"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, player $players)
    {
        //
        $players->destroy($id);
        event(new Uiupdate());

        return response(["msg" => "Player Deleted Successfully"], 200);
    }
}

// {
//     "player_no":"",
//     "name":"",
//     "mobaile":"",
//     "image":"",
//     "skill":"",
//     "playercategurie_id":""
// }
