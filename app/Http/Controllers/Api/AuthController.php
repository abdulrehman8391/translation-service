<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate(['email'=>'required|email','password'=>'required']);
        $user = DB::table('users')->where('email',$data['email'])->first();
        if(!$user || !Hash::check($data['password'],$user->password)) return response()->json(['message'=>'Invalid'],401);
        $plaintext = bin2hex(random_bytes(32)); $hash = Hash::make($plaintext);
        DB::table('api_tokens')->insert(['user_id'=>$user->id,'token_hash'=>$hash,'name'=>'default','created_at'=>now(),'updated_at'=>now()]);
        return response()->json(['token'=>$plaintext]);
    }

    public function logout(Request $request)
    {
        $token = $request->bearerToken(); if(!$token) return response()->json(['message'=>'No token'],400);
        $rows = DB::table('api_tokens')->get(); foreach($rows as $r){ if(Hash::check($token,$r->token_hash)){ DB::table('api_tokens')->where('id',$r->id)->delete(); return response()->json(['message'=>'Logged out']); }}
        return response()->json(['message'=>'Token not found'],404);
    }
}
