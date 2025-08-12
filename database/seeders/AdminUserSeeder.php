<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder; use Illuminate\Support\Facades\Hash; use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder { public function run(): void { DB::table('users')->insert(['name'=>'Admin','email'=>'admin@test.com','password'=>Hash::make('test123'),'created_at'=>now(),'updated_at'=>now()]); } }
