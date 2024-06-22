<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('barangs')->insert([
            'kode_objek' => 'AQ5',
            'nama' => "AQUA 1500 ML",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'AQ4',
            'nama' => "AQUA 220 ML",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'AQ1',
            'nama' => "AQUA 240 ML",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'AQ2',
            'nama' => "AQUA 330 ML",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'AQ3',
            'nama' => "AQUA 600 ML",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'BERAS99-2',
            'nama' => "BERAS 99 @ 10 KG",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'BERAS99-3',
            'nama' => "BERAS 99 @20 KG",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'BERAS99-4',
            'nama' => "BERAS 99 @25 KG",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'BERAS99-1',
            'nama' => "BERAS 99 @5 KG",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'BERASMAWAR1',
            'nama' => "BERAS MAWAR @10 KG",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'BERASMAWAR2',
            'nama' => "BERAS MAWAR @20 KG",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'BERASMAWAR3',
            'nama' => "BERAS MAWAR @40 KG",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'BERASRAJA1',
            'nama' => "BERAS RAJA ANGSA @10 KG",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'BERASRAJA2',
            'nama' => "BERAS RAJA ANGSA @20 KG",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'BERASRAJA3',
            'nama' => "BERAS RAJA ANGSA @25 KG",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'BIHUN001',
            'nama' => "BIHUN JAGUNG PADAMU",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'GULAKBA',
            'nama' => "GULA KBA @50 KG",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'GULAKTM',
            'nama' => "GULA KTM @50 KG",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'MIE001',
            'nama' => "MIE ATOM BULAN",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'MIE-1',
            'nama' => "MIE GULUNG KUDA MENJANGAN ISI 12 BKS",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'SDP02',
            'nama' => "MIE SEDAP GORENG 90 GR",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'MIE-2',
            'nama' => "MIE TELOR ASLI KUDA MENJANGAN ISI 20 BKS ( KECIL )",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'MIE-3',
            'nama' => "MIE TELOR ASLI KUDA MENJANGAN ISI 20 BKS ( LEBAR )",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'MIE-4',
            'nama' => "MIE TELOR KERIITNG KUDA MENJANGAN ISI 20 BKS",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'TAS',
            'nama' => "TAS SPOUNBOND",
            'created_at' => now()
        ]);

        DB::table('barangs')->insert([
            'kode_objek' => 'TPG03',
            'nama' => "TEPUNG MILA @1 KG",
            'created_at' => now()
        ]);
    }
}
