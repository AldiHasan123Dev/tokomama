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
            page-break-before: avoid;
        }
    </style>
</head>

<body>
    <main>
        <table>
            <thead>
                <tr>
                    <th rowspan="4" style="width: 15%; height: 0%;">
                        <img src="{{ public_path('logo_sb.svg') }}" class="logo" style="width: 70%; height: 7%;">
                    </th>
                    <td style="font-weight: bold; font-size: 1rem;">CV. SARANA BAHAGIA</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: 0.8rem;">Jl. Kalianak 55 Blok G, Surabaya</td>
                    <td style="font-weight: bold; font-size: 1.2rem; text-align: center;"><u>INVOICE</u></td>
                </tr>
                <tr>
                    <td style="font-size: 0.8rem;">Telp: 031-7495507</td>
                    <td style="text-align: center; font-size: 0.8rem">NO : {{ $invoice ?? '-' }}</td>
                </tr>
                <br>
                <tr>
                    <td style="text-align: left; padding-left: 45px; font-size: 0.8rem" colspan="2">Customer &nbsp;&nbsp;&nbsp; :
                        &nbsp;&nbsp;&nbsp;
                        {{$data->first()->transaksi->suratJalan->customer->nama ?? '-' }}</td>
                    <td style="text-align: center; font-size: 0.8rem; " ><span style="font-weight: bold;">KAPAL : </span> 
                        {{ $data->first()->transaksi->suratJalan->nama_kapal }}
                    </td>
                </tr>
            </thead>
        </table>

        <table class="table border border-black" style="font-size: 0.7rem">
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
                        @if ($item->transaksi->barang->satuan->nama_satuan != $item->transaksi->satuan_jual)
                            (Total {{ number_format($item->jumlah * $item->transaksi->barang->value) }} {{ $item->transaksi->barang->satuan->nama_satuan }})
                            @if($transaksi->keterangan == null) {{ "" }} @else {{ $transaksi->keterangan }} @endif
                        @else
                            @if($transaksi->keterangan == null) {{ "" }} @else {{"= " . $transaksi->keterangan }} @endif
                        @endif
                        {{-- @endif --}}
                    </td>
                    <td class="text-center border border-black">{{ $item->transaksi->suratJalan->no_cont }}</td>
                    <td class="text-center border border-black">{{ number_format($item->jumlah) }} {{ $item->transaksi->satuan_jual }}</td>
                    <td class="text-center border border-black">{{ number_format($item->harga) }} / {{ $item->transaksi->satuan_jual }}</td>
                    <td class="border border-black" style="text-align: right;">{{ number_format($item->jumlah * $item->harga) }}</td>
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
                        @if($barang->status_ppn == 'ya')
                            PPN 11%
                        @else
                            PPN 11% (DIBEBASKAN)
                        @endif
                    </td>
                    <td class="border border-black" style="text-align: right;">
                         {{ number_format($total)  }}
                        <br>
                        @if($barang->status_ppn == 'ya')
                            {{ number_format(($barang->value_ppn / 100) * $total) }}
                        @else
                            -
                        @endif
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
                    <td class="border border-black" style="text-align: right;">
                        @if($barang->status_ppn == 'ya')
                            <b>{{ number_format(($total * 0.11) + ($total)) }}</b>
                        @else
                            <b>{{ number_format($total) }}</b>
                        @endif
                        
                    </td>
                </tr>
            </tbody>
        </table>

        <p style="font-weight: bold; font-size: 0.7rem">TERBILANG :
        @if($barang->status_ppn == 'ya')
            {{ strtoupper(terbilang(($total * 0.11) + ($total))) }}
        @else
         {{ strtoupper(terbilang($total)) }} 
        @endif 
         RUPIAH </p>


        <table style="font-size: 0.8rem;">
            <tr>
                <th style="text-align: left; padding-left: 50px; font-style: italic;">Pembayaran ke rekening:</th>
                <td style="text-align: center;">Surabaya, {{ $formattedDate }}</td>
            </tr>
            <tr>
                <th style="text-align: left; padding-left: 50px; font-style: italic;">CV. Sarana Bahagia</th>
                <td style="text-align: center;">Hormat Kami</td>
            </tr>
            <tr>
                <th style="text-align: left; padding-left: 50px; font-style: italic;">Mandiri (Cab.Indrapura) : 14.000.45006.005</th>
                <th></th>
            </tr>
            <tr>
                <th style="text-align: left; padding-left: 50px;"></th>
                <th><br><br><br>(Dwi Satria Wardana)</th>
            </tr>
        </table>
    </main>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    {{-- Surat Penerimaan --}}
    <main>
        <table>
            <thead>
                <tr>
                    <th rowspan="4" style="width: 15%; height: 0%;">
                        <img src="{{ public_path('logo_sb.svg') }}" class="logo" style="width: 70%; height: 15%;">
                    </th>
                    <td style="font-weight: bold; font-size: 1rem;">CV. SARANA BAHAGIA</td>
                    <td></td>
                </tr>
                <tr>
                <td style="font-size: 0.8rem;">Jl. Kalianak 55 Blok G, Surabaya</td>
                    <td style="font-weight: bold; font-size: 1.2rem; text-align: center;"><u>SURAT PENERIMAAN</u></td>
                </tr>
                <tr>
                    <td style="font-size: 0.8rem;" >Telp: 031-7495507</td>
                    <td style="text-align: center;font-size: 0.8rem">Lamp. INV : {{ $invoice ?? '-' }}</td>
                </tr>
                <br>
                <tr>
                    <td style="text-align: left; padding-left: 45px;font-size: 0.8rem" colspan="2">Customer &nbsp;&nbsp;&nbsp; :
                        &nbsp;&nbsp;&nbsp;
                        {{$data->first()->transaksi->suratJalan->customer->nama ?? '-' }}</td>
                    <td style="text-align: center;font-size: 0.8rem"><span style="font-weight: bold;">KAPAL : </span> 
                        {{ $data->first()->transaksi->suratJalan->nama_kapal }}
                    </td>
                </tr>
            </thead>
        </table>

        <table class="table border border-black" style="font-size: 0.7rem" >
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
                        {{-- @if (str_contains($item->transaksi->barang->nama, '@')) --}}
                        @if ($item->transaksi->barang->satuan->nama_satuan != $item->transaksi->satuan_jual)
                        (Total {{ number_format($item->jumlah * $item->transaksi->barang->value) }} {{ $item->transaksi->barang->satuan->nama_satuan }})
                        @if($transaksi->keterangan == null) {{ "" }} @else {{ $transaksi->keterangan }} @endif
                        @else
                        @if($transaksi->keterangan == null) {{ "" }} @else {{"= " . $transaksi->keterangan }} @endif
                        @endif
                        {{-- @endif --}}
                    </td>
                    <td class="text-center border border-black">{{ $item->transaksi->suratJalan->no_cont }}</td>
                    <td class="text-center border border-black">{{ number_format($item->jumlah) }} {{ $item->transaksi->satuan_jual }}
                    </td>
                    <td class="text-center border border-black">{{ number_format($item->harga) }} / {{ $item->transaksi->satuan_jual }}
                    </td>
                    <td class="border border-black" style="text-align: right;">{{ number_format($item->jumlah * $item->harga) }}</td>
                </tr>
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
                        @if($barang->status_ppn == 'ya')
                        PPN 11%
                        @else
                        PPN 11% (DIBEBASKAN)
                        @endif
                    </td>
                    <td class="border border-black" style="text-align: right;">
                        {{ number_format($total)  }}
                        <br>
                        @if($barang->status_ppn == 'ya')
                        {{ number_format(($barang->value_ppn / 100) * $total) }}
                        @else
                        -
                        @endif
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
                    <td class="border border-black" style="text-align: right;">
                        @if($barang->status_ppn == 'ya')
                        <b>{{ number_format(($total * 0.11) + ($total)) }}</b>
                        @else
                        <b>{{ number_format($total) }}</b>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>


        <p style="font-weight: bold;font-size: 0.7rem">TERBILANG :
        @if($barang->status_ppn == 'ya')
            {{ strtoupper(terbilang(($total * 0.11) + ($total))) }}
        @else
         {{ strtoupper(terbilang($total)) }} 
        @endif 
         RUPIAH</p>


        <table style="font-size: 0.8rem;">
            <tr>
                <th style="text-align: left; padding-left: 50px; font-style: italic;">Pembayaran ke rekening:</th>
                <td style="text-align: center;">Surabaya, {{ $formattedDate }}</td>
            </tr>
            <tr>
                <th style="text-align: left; padding-left: 50px; font-style: italic;">CV. Sarana Bahagia</th>
                <td style="text-align: center;">Hormat Kami</td>
            </tr>
            <tr>
                <th style="text-align: left; padding-left: 50px; font-style: italic;">Mandiri (Cab.Indrapura) : 14.000.45006.005</th>
                <th></th>
            </tr>
            <tr>
                <th style="text-align: left; padding-left: 50px;"></th>
                <th><br><br><br>(Dwi Satria Wardana)</th>
            </tr>
        </table>
    </main>
</body>

</html>
