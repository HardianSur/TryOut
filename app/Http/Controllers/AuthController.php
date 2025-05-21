<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function register(){
        return view('auth.register');
    }

    public function setToken(Request $request){
        $token = $request->get('token');
        $name = $request->get('name');

        session(['access_token' => $token, 'name'=>$name]);

        return redirect('/');
    }

    public function logout(Request $request){
        $token = session('access_token');

        $response = Http::withToken($token)
            ->post(config('app.base_api') . '/auth/logout');

        if($response){
            session()->flush();
        }

        return redirect(url('/'));
    }
}
