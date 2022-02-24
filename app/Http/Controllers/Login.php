<?php

namespace App\Http\Controllers;

use App\Credential;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Minicli\Curly\Client;

class Login extends Controller
{
    public function main(Request $request){

        // $client_id = "86608223b7328c5aabb1";
        // $redirect_uri = "https://github.com/login/oauth/authorize";
        // $url = "http://localhost:8000/login";
        // $login = $redirect_uri . "?client_id=$client_id&redirect_uri=$url&state=" . md5(time());

        // return redirect($login);

        $login_url = "https://github.com/login/oauth/authorize";
        $client_id = "86608223b7328c5aabb1";
        $client_secret = "6bff2c89c52020396f742da97a5888d17091fbcc";
        $redirect_uri = "http://localhost:8000/login";
    
        $state = $request->query('state');
        if($state === null){
            
            $state = md5(time());
            $auth_url = sprintf("%s?client_id=%s&redirect_uri=%s&state=%s", $login_url, $client_id, $redirect_uri, $state);

            return redirect($auth_url);
        }

        $code = $request->query('code');
        $token_url = "https://github.com/login/oauth/access_token";
        $curly = new Client();

        $request_token_url = sprintf('%s', $token_url);

        $response = $curly->post($request_token_url, [
            'code' => $code,
            "client_id" => $client_id,
            "client_secret" => $client_secret,
            "redirect_uri" => $redirect_uri,
            "state" => $state
        ]);

    }
}
