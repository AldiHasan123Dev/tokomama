<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sub_menus')->insert([
            'menu_id' => 2,
            'title' => "Barang",
            'name' => "barang",
            'url' => "#",
            'order' => 1,
            'created_at' => now()
        ]);

        DB::table('sub_menus')->insert([
            'menu_id' => 3,
            'title' => "Surat Jalan",
            'name' => "surat_jalan",
            'url' => "http://127.0.0.1:8000/keuangan/surat-jalan",
            'order' => 1,
            'created_at' => now()
        ]);

        DB::table('sub_menus')->insert([
            'menu_id' => 3,
            'title' => "Invoice",
            'name' => "invoice",
            'url' => "http://127.0.0.1:8000/keuangan/invoice",
            'order' => 2,
            'created_at' => now()
        ]);

        DB::table('sub_menus')->insert([
            'menu_id' => 4,
            'title' => "Nomor Seri NSFP",
            'name' => "nomor_seri_nsfp",
            'url' => "http://127.0.0.1:8000/pajak/nsfp",
            'order' => 1,
            'created_at' => now()
        ]);

        DB::table('sub_menus')->insert([
            'menu_id' => 4,
            'title' => "Laporan PPN",
            'name' => "laporan_ppn",
            'url' => "http://127.0.0.1:8000/pajak/laporan-ppn",
            'order' => 2,
            'created_at' => now()
        ]);
    }
}
