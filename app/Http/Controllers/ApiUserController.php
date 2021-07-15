<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ApiRegisterRequest;
use App\Http\Requests\ApiLoginRequest;
use App\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class ApiUserController extends Controller
{
    //
    public function register(ApiRegisterRequest $request)
    {
        $user = new User;
        $user->fill($request->all());
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json($user);
        // return 'dsfsd';
    }
    public function login(ApiLoginRequest $request)
    {
        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            $user = User::whereEmail($request->email)->first();
            $user->token = $user->createToken('App')->accessToken;   
            return response()->json($user);
        }
        else return response()->json(['email' => 'Sai ten truy cap hoac mat khau'], 401);
    }

    public function userInfo(Request $request)      
    {
        return response()->json($request->user('api'));
    }
}
