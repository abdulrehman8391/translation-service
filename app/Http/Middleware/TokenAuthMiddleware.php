<?php

namespace App\Http\Middleware;

use Closure; use Illuminate\Http\Request; use Illuminate\Support\Facades\DB; use Illuminate\Support\Facades\Hash;

class TokenAuthMiddleware { public function handle(Request $request, Closure $next){ $token=$request->bearerToken(); if(!$token) return response()->json(['message'=>'Unauthorized'],401); $rows=DB::table('api_tokens')->get(); foreach($rows as $r){ if(Hash::check($token,$r->token_hash)){ $request->attributes->set('auth_user_id',$r->user_id); DB::table('api_tokens')->where('id',$r->id)->update(['last_used_at'=>now()]); return $next($request); }} return response()->json(['message'=>'Unauthorized'],401); } }
