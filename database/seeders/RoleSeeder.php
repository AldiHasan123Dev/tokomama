<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'name' => 'SUPER ADMIN',
            'deleted_at' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);

        DB::table('roles')->insert([
            'name' => 'COMM',
            'deleted_at' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        
        DB::table('roles')->insert([
            'name' => 'FA',
            'deleted_at' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);

        DB::table('roles')->insert([
            'name' => 'TRUCK',
            'deleted_at' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);

        DB::table('roles')->insert([
            'name' => 'TRUCK, FA, TAX',
            'deleted_at' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);

        DB::table('roles')->insert([
            'name' => 'COMM1',
            'deleted_at' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);

        DB::table('roles')->insert([
            'name' => 'MELLA',
            'deleted_at' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);

        DB::table('roles')->insert([
            'name' => 'KOSONG',
            'deleted_at' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);

        DB::table('roles')->insert([
            'name' => 'MARKETING',
            'deleted_at' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);

        DB::table('roles')->insert([
            'name' => 'FA1',
            'deleted_at' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);

        DB::table('roles')->insert([
            'name' => 'ROS1',
            'deleted_at' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);

        DB::table('roles')->insert([
            'name' => 'ADMIN BL',
            'deleted_at' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
    }
}
