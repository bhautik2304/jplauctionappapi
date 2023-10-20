<?php
namespace App\Services;

use App\Models\fcmtoken;
use App\Models\User;
use Illuminate\Support\Facades\Http;

trait fireBaseFCMService {
    public static function notyfyToAll($tittle,$msg)
    {
        # code...
        $server_key = "AAAA7oR12yU:APA91bFJH8UznC-i0D2SKxbFIjKZsVJzZJuA2dR8gHFo4QQgtJChhkCUDxDcGJi2e7sJ6l-_Wc1s2AhtrL2C7sMDEPM2fNdopJYMDhRhdtZhK9jeHcgShL7o4FT0o4qb0pUT8v_0Fs0R";
        $url = "https://fcm.googleapis.com/fcm/send";

        // The recipient device token for the notification
        //token = "fqHJbSL1sAk24gcFkH20fz:APA91bEiLTzA9F86FkIEotDjQpLzgpYx0SF0Lpn-ZErPnUe69qQp2UPt2ufp-KawP9bqKT2NCIjTT9Z8dkESYcKd7V9IIo4GtSptNhYKjw1Be4bQM8mPmDhBT3knIbhEeguAjVDW-Sns";

        // The data to include in the notification payload
        $data = [
            "message" => $msg,
            "title" => $tittle,
        ];

        $users=fcmtoken::all();
        foreach ($users as $token) {
            # code...
            // dd();
            $payload = [
                "to" => $token->token,
                "data" => $data,
            ];

            // Send the notification using the Laravel Http package
            $response = Http::withHeaders([
                "Authorization" => "key={$server_key}",
                "Content-Type" => "application/json",
            ])->post($url, $payload);
        }
        // The notification payload

        return $response->body();
    }

    public function sendToUser($tittle,$msg,$id)
    {
        # code...
        $server_key = "AAAAS59oTpo:APA91bEV0-qfEkKzn_XJGYWbBBl9c_6__1T4SEYAIwgplx8ITHE_oxdnv8tmq7L2NKhJpzlNGjyGbXstM8JFAk8Ccmsoa4lxsB6cs8QLI5qBIRW5NDHj5wB9_F3ak_-snObfYYM0muN7";
        $url = "https://fcm.googleapis.com/fcm/send";

        // The recipient device token for the notification
        //token = "fqHJbSL1sAk24gcFkH20fz:APA91bEiLTzA9F86FkIEotDjQpLzgpYx0SF0Lpn-ZErPnUe69qQp2UPt2ufp-KawP9bqKT2NCIjTT9Z8dkESYcKd7V9IIo4GtSptNhYKjw1Be4bQM8mPmDhBT3knIbhEeguAjVDW-Sns";

        // The data to include in the notification payload
        $data = [
            "message" => $msg,
            "title" => $tittle,
        ];

        $users=User::where('id',$id)->first()->toArray();
        // $fcmToken=fcmtoken
        // dd();
        foreach ($users['fcm_tokens'] as $token) {
            # code...
            // dd();
            $payload = [
                "to" => $token['token'],
                "data" => $data,
            ];

            // Send the notification using the Laravel Http package
            $response = Http::withHeaders([
                "Authorization" => "key={$server_key}",
                "Content-Type" => "application/json",
            ])->post($url, $payload);
        }
        // The notification payload

        return $response->body();
    }
}

