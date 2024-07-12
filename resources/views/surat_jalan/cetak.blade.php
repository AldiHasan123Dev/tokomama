<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $surat_jalan->nomor_surat }}</title>
    <style>
        *{
            font-size: 1rem;
        }
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
                <tr>
                    <th class="text-center border border-black" rowspan="6" style="vertical-align: top;">
                        @foreach($surat_jalan->transactions as $item)
                        <span>{{$loop->iteration}}</span><br>
                        @endforeach
                    </th>
                    <td class="text-center border border-black" rowspan="6" style="vertical-align: top;">
                        @foreach($surat_jalan->transactions as $item)
                        <span>{{$item->jumlah_beli}}</span><br>
                        @endforeach
                    </td>
                    <td class="text-center border border-black" rowspan="6" style="vertical-align: top;">
                        @foreach($surat_jalan->transactions as $item)
                        <span>{{$item->satuan_beli}}</span><br>
                        @endforeach
                    </td>
                    <td class="border border-black">
                        @foreach ($surat_jalan->transactions as $item)
                        <div class="flex justify-between mt-3">
                            <span>{{ $item->barang->nama }}</span>
                            <span>({{ $item->jumlah_jual}} {{$item->satuan_jual}})</span>
                        </div>
                        @if (str_contains($item->barang->nama, '@'))
                            (Total {{ number_format($item->jumlah_beli * $item->barang->value) }} Kg)
                        @endif
                        @endforeach
                    </td>
                    <td class="border border-black text-center" rowspan="6"> {{
                        $surat_jalan->customer->alamat ?? '-' }} <br> {{ $surat_jalan->customer->nama ?? '-' }}
                    </td>
                </tr>
                <tr>
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
                    <td style="height: 30px"></td>
                    <td></td>
                </tr>
                <tr>
                    <th><b>PENERIMA</b></th>
                    <th><b>PENGIRIM</b></th>
                </tr>
                <tr style="height: 100px !important">
                    <th style="height: 50px"> </th>
                    <th></th>
                </tr>
                <tr>
                    <th>({{ $surat_jalan->nama_penerima }})</th>
                    <th>({{ $surat_jalan->nama_pengirim }})</th>
                </tr>
            </table>
        </div>
    </main>
</body>

</html>
