<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    function SignUp(Request $req){
        try{
            $this->validate($req,[
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = new User;
            $user->name = $req->input('name');
            $user->email = $req->input('email');
            $user->password = bcrypt($req->input('password'));
            $user->address = "";
            $user->phone_number = "";
            $user->save();

            $token = JWTAuth::fromUser($user);
            return response()->json(['message' => 'sukses membuat user', 'token' => $token], 200);
            // return "Berhasil";
        }
        catch(\Exception $e){
            return response()->json(['message' => 'Failed to create user, exception:'+$e], 500);
        }
    }

    function SignIn(Request $request){
        $credentials = $request->only('email', 'password');

        try{
            if(! $token = JWTAuth::attempt($credentials)){
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        }
        catch(JWTException $e){
            return response()->json(['error' => 'cloud_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }
}