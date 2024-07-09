<?php

namespace Database\Seeders;

use App\Models\Barang;
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
        $data = [
            [
                'kode_objek' => 'AQ5',
                'nama' => "AQUA 1500 ML",
                'value' => "1",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'AQ4',
                'nama' => "AQUA 220 ML",
                'value' => "1",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'AQ1',
                'nama' => "AQUA 240 ML",
                'value' => "1",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'AQ2',
                'nama' => "AQUA 330 ML",
                'value' => "1",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'AQ3',
                'nama' => "AQUA 600 ML",
                'value' => "1",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'BERAS99-2',
                'nama' => "BERAS 99 @ 10 KG",
                'value' => "10",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'BERAS99-3',
                'nama' => "BERAS 99 @20 KG",
                'value' => "20",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'BERAS99-4',
                'nama' => "BERAS 99 @25 KG",
                'value' => "25",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'BERAS99-1',
                'nama' => "BERAS 99 @5 KG",
                'value' => "5",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'BERASMAWAR1',
                'nama' => "BERAS MAWAR @10 KG",
                'value' => "10",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'BERASMAWAR2',
                'nama' => "BERAS MAWAR @20 KG",
                'value' => "20",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'BERASMAWAR3',
                'nama' => "BERAS MAWAR @40 KG",
                'value' => "40",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'BERASRAJA1',
                'nama' => "BERAS RAJA ANGSA @10 KG",
                'value' => "10",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'BERASRAJA2',
                'nama' => "BERAS RAJA ANGSA @20 KG",
                'value' => "20",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'BERASRAJA3',
                'nama' => "BERAS RAJA ANGSA @25 KG",
                'value' => "25",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'BIHUN001',
                'nama' => "BIHUN JAGUNG PADAMU",
                'value' => "1",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'GULAKBA',
                'nama' => "GULA KBA @50 KG",
                'value' => "50",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'GULAKTM',
                'nama' => "GULA KTM @50 KG",
                'value' => "50",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'MIE001',
                'nama' => "MIE ATOM BULAN",
                'value' => "1",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'MIE-1',
                'nama' => "MIE GULUNG KUDA MENJANGAN ISI 12 BKS",
                'value' => "12",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'SDP02',
                'nama' => "MIE SEDAP GORENG 90 GR",
                'value' => "90",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'MIE-2',
                'nama' => "MIE TELOR ASLI KUDA MENJANGAN ISI 20 BKS ( KECIL )",
                'value' => "20",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'MIE-3',
                'nama' => "MIE TELOR ASLI KUDA MENJANGAN ISI 20 BKS ( LEBAR )",
                'value' => "20",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'MIE-4',
                'nama' => "MIE TELOR KERIITNG KUDA MENJANGAN ISI 20 BKS",
                'value' => "20",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'TAS',
                'nama' => "TAS SPOUNBOND",
                'value' => "1",
                'created_at' => now()
            ],

            [
                'kode_objek' => 'TPG03',
                'nama' => "TEPUNG MILA @1 KG",
                'value' => "1",
                'created_at' => now()
            ],
        ];

        Barang::insert($data);
    }
}
