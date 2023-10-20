<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return response(["users" => User::all()], 200);
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
    public function store(Request $request,User $user)
    {
        //
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobaile = $request->mobaile;
        $user->password = Hash::make($request->password);
        $user->save();

        return response(["msg" => "User Created Successfully."], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,User $users)
    {
        //
        $users->find($id)->update([
            "name" => $request->name,
            "email" => $request->email,
            "mobaile" => $request->mobaile,
            "password" => Hash::make($request->password),
        ]);

        return response(["msg" => "User Updated Successfully."], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,User $users)
    {
        //
        $users->destroy($id);
        return response(["msg" => "User Deleted Successfully."], 200);
    }
}

// {
//     "name":"",
//     "email":"",
//     "mobaile":"",
//     "password":""
// }
