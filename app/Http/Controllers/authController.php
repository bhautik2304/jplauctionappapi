<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    //
    public function login(Request $req)
    {
        # code...
        $user = User::where('email', $req->email)->orWhere('mobaile', $req->email)->first();
        if (!$user) {
            # User Not Found
            return response(["msg" => "Users Not Find. Wrong Credentials", "code" => 404], 200);
        }
        if (!Hash::check($req->password, $user->password)) {
            # code...
            return response(["msg" => "Wrong Password " . $user->name, "code" => 404], 200);
        }
        // $token = $user->startSession($user);
        // $users=$user;
        return response(["user" => $user, "tocken" => Str::uuid(), "code" => 200], 200);
    }

    public function otpgenrate() {

    }
}
