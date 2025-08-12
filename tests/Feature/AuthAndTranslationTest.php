<?php

namespace Tests\Feature; use Tests\TestCase; use Illuminate\Support\Facades\DB; use Illuminate\Support\Facades\Hash;

class AuthAndTranslationTest extends TestCase { public function test_login_and_protected_routes(){ if(!DB::table('users')->where('email','admin@test.com')->exists()) DB::table('users')->insert(['name'=>'Admin','email'=>'admin@test.com','password'=>Hash::make('test123'),'created_at'=>now(),'updated_at'=>now()]); $resp=$this->postJson('/api/login',['email'=>'admin@test.com','password'=>'test123']); $resp->assertStatus(200)->assertJsonStructure(['token']); $token=$resp->json('token'); $this->withHeader('Authorization','Bearer '.$token)->getJson('/api/translations')->assertStatus(200); } }
