<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Invoice</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        .logo {
            max-width: 100%;
            height: 100px;
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
        .pagebreak{
            page-break-before: always;
        }
    </style>
</head>

<body>
    <main>
        <table>
            <thead>
                <tr>
                    <th rowspan="4" style="width: 20%">
                        <img src="{{ public_path('logo_sb.svg') }}" class="logo">
                    </th>
                    <td style="font-weight: bold; font-size: 1.3rem;">CV. SARANA BAHAGIA</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Jl. Kalianak 55 Blok G, Surabaya</td>
                    <td style="font-weight: bold; font-size: 1.5rem; text-align: center;"><u>INVOICE</u></td>
                </tr>
                <tr>
                    <td>Telp: 031-7495507</td>
                    <td style="text-align: center;">NO: {{ $invoice ?? '-' }}</td>
                </tr>
                <br>
                <tr>
                    <td style="text-align: left; padding-left: 45px;" colspan="2">Customer &nbsp;&nbsp;&nbsp; :
                        &nbsp;&nbsp;&nbsp;
                        {{$data->first()->transaksi->suratJalan->customer->nama ?? '-' }}</td>
                    <td style="text-align: center;"><span style="font-weight: bold;">KAPAL: </span> &nbsp;&nbsp;&nbsp;
                        {{ $data->first()->transaksi->suratJalan->nama_kapal }}
                    </td>
                </tr>
            </thead>
        </table>

        <table class="table border border-black">
            <thead>
                <tr>
                    <th class="border border-black">No.</th>
                    <th class="border border-black">Tgl Barang Masuk</th>
                    <th class="border border-black">Nama Barang</th>
                    <th class="border border-black">No. Cont</th>
                    <th class="border border-black">Quantity</th>
                    <th class="border border-black">Harga Satuan</th>
                    <th class="border border-black">Total (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @php
                $total = 0;
                function terbilang($angka) {
                            $angka = (float)$angka;
                            $bilangan = array(
                                    '',
                                    'satu',
                                    'dua',
                                    'tiga',
                                    'empat',
                                    'lima',
                                    'enam',
                                    'tujuh',
                                    'delapan',
                                    'sembilan',
                                    'sepuluh',
                                    'sebelas'
                                );
                                if ($angka < 12) {
                                    return $bilangan[$angka];
                                } else if ($angka < 20) {
                                    return $bilangan[$angka - 10] . ' belas';
                                } else if ($angka < 100) {
                                    $hasil_bagi = (int)($angka / 10);
                                    $hasil_mod = $angka % 10;
                                    return trim(sprintf('%s puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
                                } else if ($angka < 200) {
                                    return 'seratus ' . terbilang($angka - 100);
                                } else if ($angka < 1000) {
                                    $hasil_bagi = (int)($angka / 100);
                                    $hasil_mod = $angka % 100;
                                    return trim(sprintf('%s ratus %s', $bilangan[$hasil_bagi], terbilang($hasil_mod)));
                                } else if ($angka < 2000) {
                                    return 'seribu ' . terbilang($angka - 1000);
                                } else if ($angka < 1000000) {
                                    $hasil_bagi = (int)($angka / 1000);
                                    $hasil_mod = $angka % 1000;
                                    return trim(sprintf('%s ribu %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
                                } else if ($angka < 1000000000) {
                                    $hasil_bagi = (int)($angka / 1000000);
                                    $hasil_mod = $angka % 1000000;
                                    return trim(sprintf('%s juta %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
                                } else if ($angka < 1000000000000) {
                                    $hasil_bagi = (int)($angka / 1000000000);
                                    $hasil_mod = fmod($angka, 1000000000);
                                    return trim(sprintf('%s miliar %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
                                } else {
                                    return 'Angka terlalu besar';
                                }
                            }
                @endphp
                @foreach ($data as $item)
                <tr>
                    <td class="text-center border border-black">{{ $loop->iteration }}</td>
                    <td class="text-center border border-black">{{ date('d M Y',
                        strtotime($item->transaksi->suratJalan->tgl_sj)) }}</td>
                    <td class="text-center border border-black">
                        {{ $item->transaksi->barang->nama }} <br>
                        {{-- @if (str_contains($item->transaksi->barang->nama, '@')) --}}
                        @if (str_contains($item->transaksi->barang->nama, '@'))
                            (Total {{ number_format($item->jumlah * $item->transaksi->barang->value) }} Kg)
                        @endif
                    </td>
                    <td class="text-center border border-black">{{ $item->transaksi->suratJalan->no_cont }}</td>
                    <td class="text-center border border-black">{{ $item->jumlah }} {{ $item->transaksi->satuan_jual }}</td>
                    <td class="text-center border border-black">{{ number_format($item->harga) }} / {{ $item->transaksi->satuan_jual }}</td>
                    <td class="text-center border border-black">{{ number_format($item->jumlah * $item->harga) }}</td>
                </tr>
                @php
                $total += $item->harga * $item->jumlah;
                @endphp
                @endforeach
                <tr>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="border border-black">
                        DPP
                        <br>
                        PPN 11% (DIBEBASKAN)
                    </td>
                    <td class="border border-black">
                        {{ number_format($total) }}
                        <br>
                        
                    </td>
                </tr>
                <tr>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="border border-black">
                        <b>TOTAL</b>
                    </td>
                    <td class="border border-black">
                        <b>Rp {{ number_format($total) }}</b>
                    </td>
                </tr>
            </tbody>
        </table>


        <p style="font-weight: bold;">TERBILANG: {{ strtoupper(terbilang($total)) }}  RUPIAH</p>

        <br>

        <table>
            <tr>
                <th style="text-align: left; padding-left: 50px;">Pembayaran ke rekening:</th>
                <td style="text-align: center;">Surabaya, {{ date('d F Y') }}</td>
            </tr>
            <tr>
                <th style="text-align: left; padding-left: 50px;">CV. Sarana Bahagia</th>
                <td style="text-align: center;">Hormat Kami</td>
            </tr>
            <tr>
                <th style="text-align: left; padding-left: 50px;">Mandiri (Cab.Indrapura) : 14.000.45006.005</th>
                <th></th>
            </tr>
            <tr>
                <th style="text-align: left; padding-left: 50px;"></th>
                <th>(Dwi Satria Wardana)</th>
            </tr>
        </table>
    </main>
    <div class="pagebreak"></div>
    <main>
        <table>
            <thead>
                <tr>
                    <th rowspan="4" style="width: 20%">
                        <img src="{{ public_path('logo_sb.svg') }}" class="logo">
                    </th>
                    <td style="font-weight: bold; font-size: 1.3rem;">CV. SARANA BAHAGIA</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Jl. Kalianak 55 Blok G, Surabaya</td>
                    <td style="font-weight: bold; font-size: 1.5rem; text-align: center;"><u>SURAT PENERIMAAN</u></td>
                </tr>
                <tr>
                    <td>Telp: 031-7495507</td>
                    <td style="text-align: center;">NO: {{ $invoice ?? '-' }}</td>
                </tr>
                <br>
                <tr>
                    <td style="text-align: left; padding-left: 45px;" colspan="2">Customer &nbsp;&nbsp;&nbsp; :
                        &nbsp;&nbsp;&nbsp;
                        {{$data->first()->transaksi->suratJalan->customer->nama ?? '-' }}</td>
                    <td style="text-align: center;"><span style="font-weight: bold;">KAPAL: </span> &nbsp;&nbsp;&nbsp;
                        {{ $data->first()->transaksi->suratJalan->nama_kapal }}
                    </td>
                </tr>
            </thead>
        </table>

        <table class="table border border-black">
            <thead>
                <tr>
                    <th class="border border-black">No.</th>
                    <th class="border border-black">Tgl Barang Masuk</th>
                    <th class="border border-black">Nama Barang</th>
                    <th class="border border-black">No. Cont</th>
                    <th class="border border-black">Quantity</th>
                    <th class="border border-black">Harga Satuan</th>
                    <th class="border border-black">Total (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td class="text-center border border-black">{{ $loop->iteration }}</td>
                    <td class="text-center border border-black">{{ date('d M Y',
                        strtotime($item->transaksi->suratJalan->tgl_sj)) }}</td>
                    <td class="text-center border border-black">
                        {{ $item->transaksi->barang->nama }} <br>
                        @if (str_contains($item->transaksi->barang->nama, '@'))
                            (Total {{ number_format($item->jumlah * $item->transaksi->barang->value) }} Kg)
                        @endif
                    </td>
                    <td class="text-center border border-black">{{ $item->transaksi->suratJalan->no_cont }}</td>
                    <td class="text-center border border-black">{{ $item->jumlah }} {{ $item->transaksi->satuan_jual }}</td>
                    <td class="text-center border border-black">{{ number_format($item->harga) }} / {{ $item->transaksi->satuan_jual }}</td>
                    <td class="text-center border border-black">{{ number_format($item->jumlah *
                        $item->harga) }}</td>
                </tr>
                @php
                $total += $item->harga * $item->jumlah;
                @endphp
                @endforeach
                <tr>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="border border-black">
                        DPP
                        <br>
                        PPN 11% (DIBEBASKAN)
                    </td>
                    <td class="border border-black">
                        {{ number_format($total) }}
                        <br>
                        
                    </td>
                </tr>
                <tr>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="border border-black">
                        <b>TOTAL</b>
                    </td>
                    <td class="border border-black">
                        <b>{{ number_format($total) }}</b>
                    </td>
                </tr>
            </tbody>
        </table>


        <p style="font-weight: bold;">TERBILANG: {{ strtoupper(terbilang($total)) }}  RUPIAH</p>

        <br>

        <table>
            <tr>
                <th style="text-align: left; padding-left: 50px;">Pembayaran ke rekening:</th>
                <td style="text-align: center;">Surabaya, {{ date('d F Y') }}</td>
            </tr>
            <tr>
                <th style="text-align: left; padding-left: 50px;">CV. Sarana Bahagia</th>
                <td style="text-align: center;">Hormat Kami</td>
            </tr>
            <tr>
                <th style="text-align: left; padding-left: 50px;">Mandiri (Cab.Indrapura) : 14.000.45006.005</th>
                <th></th>
            </tr>
            <tr>
                <th style="text-align: left; padding-left: 50px;"></th>
                <th>(Dwi Satria Wardana)</th>
            </tr>
        </table>
    </main>
</body>

</html>
