<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $surat_jalan->nomor_surat }}</title>
    <style>
        
        table {
            border-collapse: collapse;
            width: 90%;
        }

         body, table, th, td, p {
            font-size: 8pt !important;
        }

        .logo {
            width: 70px;
        }

        body {
            width: 100%;
            /* padding: 10px 30px; */
        }

        table.table {
            margin-top: 10px;
        }

        .border.border-black {
            border: 1px solid black;
            padding: 5px;
        }

        .py-1 {
            padding: 5px 0;
        }

        .text-center {
            text-align: center !important;
            justify-content: center;
        }
    </style>
</head>

<body>
    <main>
        <table>
            <thead >
                <tr>
                    <th rowspan="4" style="width: 20%">
                        <img src="{{ public_path('logo_sb.svg') }}" class="logo">
                    </th>
                    <td>CV. SARANA BAHAGIA</td>
                    <td></td>
                    <td>Kepada:</td>
                </tr>
                <tr>
                    <td>Jl. Kalianak 55 Blok G, Surabaya</td>
                    <td></td>
                    <td>{{ $surat_jalan->kepada }}</td>
                </tr>
                <tr>
                    <td>Telp: 031-123456</td>
                    <td></td>
                    <td>{{ $ekspedisi->alamat }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{ $ekspedisi->kota }}</td>
                </tr>
                <tr>
                    <th>SURAT JALAN</th>
                    <td style="font-weight: bold" colspan="2">No: {{ $surat_jalan->nomor_surat }} </td>
                </tr>
            </thead>
        </table>
        <table class="table border border-black">
            <thead>
                <tr>
                    <th class="border border-black">NO</th>
                    <th class="border border-black">JUMLAH</th>
                    <th class="border border-black">SATUAN</th>
                    <th class="border border-black">JENIS BARANG</th>
                    <th class="border border-black">TUJUAN / NAMA CUSTOMER</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($surat_jalan->transactions as $item)
                <tr>
                    <td class="text-center" style="vertical-align: top; border-right: 1px solid black">
                        <span>{{$loop->iteration}}</span><br>
                    </td>
                    <td class="text-center" style="vertical-align: top; border-right: 1px solid black">
                        <span>{{$item->jumlah_beli}}</span>
                    </td>
                    <td class="text-center" style="vertical-align: top; border-right: 1px solid black">
                        <span>{{$item->satuan_beli}}</span><br>
                    </td>
                    <td class="px-2" style="padding: 0px 5px">
                        <div class="flex justify-between mt-3">
                            <span>{{ $item->barang->nama_singkat }}</span>
                            <span>({{ $item->jumlah_jual}} {{$item->satuan_jual}})</span>
                        </div>
                        {{-- @if (str_contains($item->barang->nama, '@')) --}}
                        @if (str_contains($item->satuan_jual,$item->barang->satuan->nama_satuan))
                            @php
                                $t = (int)$item->jumlah_jual;
                            @endphp
                        @else
                            @php
                                $t = (double)$item->barang->value * (int)$item->jumlah_jual;
                            @endphp
                        @endif
                        @if($item->satuan_jual != $item->barang->satuan->nama_satuan )
                            (Total {{ number_format($t) }} {{ $item->barang->satuan->nama_satuan }} {{ ($item->keterangan != '' || !is_null($item->keterangan)) ? '= '.$item->keterangan:'' }}) 
                        @else
                            {{ ($item->keterangan != '' || !is_null($item->keterangan)) ? '= '.$item->keterangan:'' }}
                        @endif
                    </td>
                    @if ($loop->first)
                        <td class="border border-black text-center" rowspan="{{ 5 + $surat_jalan->transactions->count() }}"> {{
                            $surat_jalan->customer->alamat ?? '-' }} <br> {{ $surat_jalan->customer->nama ?? '-' }}
                        </td>
                    @endif
                </tr>
                @endforeach
                <tr>
                    <td style="vertical-align: top; border-right: 1px solid black" rowspan="5"></td>
                    <td style="vertical-align: top; border-right: 1px solid black" rowspan="5"></td>
                    <td style="vertical-align: top; border-right: 1px solid black" rowspan="5"></td>
                    <td class="border border-black py-1">
                        Nama Kapal: {{ $surat_jalan->nama_kapal }} </td>
                </tr>
                <tr>
                    <td class="border border-black py-1">
                        No. Cont: {{ $surat_jalan->no_cont }} </td>
                </tr>
                <tr>
                    <td class="border border-black py-1">
                        No. Seal: {{ $surat_jalan->no_seal }} </td>
                </tr>
                <tr>
                    <td class="border border-black py-1">
                        No. Pol: {{ $surat_jalan->no_pol }} </td>
                </tr>
                <tr>
                    <td class="border border-black py-1">
                        No. Job: {{ $surat_jalan->no_job }} </td>
                </tr>
            </tbody>
        </table>
        <p>Note: &nbsp; Barang yang diterima dalam keadaan baik dan lengkap</p>
        <div style="text-align: center">
            <table>
                <tr>
                    <th style="width: 50%;"></th>
                    <th style="width: 50%; text-align: right; font-weight: normal !important; padding-right:20px">{{
                        $surat_jalan->kota_pengirim }}, {{ date('d M Y', strtotime($surat_jalan->tgl_sj)) }}</th>
                </tr>
                <tr>
                    <td style="height: 10px"></td>
                    <td></td>
                </tr>
                <tr>
                    <th><b>PENERIMA</b></th>
                    <th><b>PENGIRIM</b></th>
                </tr>
                <tr>
                   <td style="height: 20px;"></td>
                <tr >
                    <th style="height: 35px"> </th>
                    <th></th>
                </tr>
                <tr>
                    <th>({{ $surat_jalan->nama_penerima }})</th>
                    <th>({{ $surat_jalan->nama_pengirim }})</th>
                </tr>
            </table>
        </div>
    </main>
    
    <script>

    </script>
</body>
</html>
