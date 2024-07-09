<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EkspedisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'CITRA IRIAN KARYA NUSANTARA, PT',
                'pic' => 'ANDI PANGERAN',
                'alamat' => 'JL. BUDI UTOMO',
                'kota' => 'TIMIKA',
                'no_telp' => '',
                'fax' => '',
                'email' => '',
                'created_at' => now()
            ],
            [
                'nama' => 'DELTA MITRA, EKSPEDISI',
                'pic' => 'AINI, IBU',
                'alamat' => 'JL.SEMUT BARU, KOMP.PENGAMPON SQUARE H-8',
                'kota' => 'SURABAYA',
                'no_telp' => '031 3574524',
                'fax' => '031 3536146',
                'email' => '',
                'created_at' => now()
            ],
            [
                'nama' => 'EKSPEDISI PERMATA SAMUDERA',
                'pic' => 'EDDY, BPK.',
                'alamat' => 'JL.SEMUT BARU, KOMP.PENGAMPON SQUARE H-8',
                'kota' => 'SURABAYA',
                'no_telp' => '031 3574524',
                'fax' => '031 3536146',
                'email' => '',
                'created_at' => now()
            ],
        ];
    }
}
