<?php

namespace App\Http\Controllers;

use App\Models\player;
use Illuminate\Http\Request;
use App\Events\Uiupdate;
use Illuminate\Support\Facades\Log;

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
        try {
            //code...
            $imagePath = $request->file('image')->store('player', 'public');
            $player = new player;
            $player->player_no = $request->input('player_no');
            $player->name = $request->input('name');
            $player->mobaile = $request->input('mobaile');
            $player->image =  asset('storage/' . $imagePath);
            $player->skill = $request->input('skill');
            $player->playercategurie_id = $request->input('playercategurie_id');
            $res = $player->save();

            if (!$res) {
                # code...
                return response(["msg" => "Player Not Created Successfully"], 200);
            }
            event(new Uiupdate());
            return response(["msg" => "Player Created Successfully"], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response(["msg" => "Error Accurd"], 500);
        }
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
        try {
            //code...
            // Log::info('Received PUT request:', $request->all());
            // return $request->all();
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('player', 'public');
                $players->find($id)->update([
                    "image" =>  asset('storage/' . $imagePath),
                ]);
            }
            $players->find($id)->update([
                "player_no" => $request->input('player_no'),
                "name" => $request->input('name'),
                "mobaile" => $request->input('mobaile'),
                // "image"=>$request->image,
                "skill" => $request->input('skill'),
                "playercategurie_id" => $request->input('playercategurie_id'),
            ]);

            event(new Uiupdate());

            return response(["msg" => "Player Updated Successfully"], 200);
        } catch (\Throwable $th) {
            throw $th;
            return response(["msg" => "Error Accurd", "error" => $th], 500);
        }
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
