<?php

namespace App\Http\Controllers;

use App\Models\playercategury;
use Illuminate\Http\Request;

class PlayercateguryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response(["Playercategury" => playercategury::all()], 200);
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
        $pc = new playercategury;
        $pc->name = $request->name;
        $pc->points = $request->points;
        $pc->save();

        return response(["msg" => "Player Categury Created Successfully"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\playercategury  $playercategury
     * @return \Illuminate\Http\Response
     */
    public function show(playercategury $playercategury)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\playercategury  $playercategury
     * @return \Illuminate\Http\Response
     */
    public function edit(playercategury $playercategury)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\playercategury  $playercategury
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, playercategury $playercategurys, $id)
    {
        //
        $playercategurys->find($id)->update([
            'name' => $request->name,
            'points' => $request->points,
        ]);

        return response(["msg" => "Player Cetegury Updated Successfully"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\playercategury  $playercategury
     * @return \Illuminate\Http\Response
     */
    public function destroy(playercategury $playercategurys, $id)
    {
        //
        $playercategurys->destroy($id);
        return response(["msg" => "Player Cetegury Deleted Successfully"], 200);
    }
}
