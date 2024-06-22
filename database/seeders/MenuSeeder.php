<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->insert([
            'title' => "Dashboard",
            'icon' => '<i class="fa-solid fa-house"></i>',
            'name' => "dashboard",
            'url' => "#",
            'order' => 1,
            'created_at' => now()
        ]);

        DB::table('menus')->insert([
            'title' => "Master",
            'icon' => '<i class="fa-solid fa-database"></i>',
            'name' => "master",
            'url' => "#",
            'order' => 2,
            'created_at' => now()
        ]);

        DB::table('menus')->insert([
            'title' => "Keuangan",
            'icon' => '<i class="fa-solid fa-money-check-dollar"></i>',
            'name' => "keuangan",
            'url' => "#",
            'order' => 3,
            'created_at' => now()
        ]);

        DB::table('menus')->insert([
            'title' => "Pajak",
            'icon' => '<i class="fa-solid fa-circle-dollar-to-slot"></i>',
            'name' => "pajak",
            'url' => "#",
            'order' => 4,
            'created_at' => now()
        ]);

        DB::table('menus')->insert([
            'title' => "Jurnal Keuangan",
            'icon' => '<i class="fa-solid fa-book"></i>',
            'name' => "jurnal_keuangan",
            'url' => "#",
            'order' => 5,
            'created_at' => now()
        ]);
    }
}
