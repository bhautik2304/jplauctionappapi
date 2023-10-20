<?php

namespace App\Http\Controllers;

use App\Models\fcmtoken;
use Illuminate\Http\Request;

class FcmtokenController extends Controller
{
    //

    public function store(Request $req){
        $token=new fcmtoken;
        $token->token=$req->token;
        $token->save();
    }
}
