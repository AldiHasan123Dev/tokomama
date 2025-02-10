<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Invoice</title>
    <style>
        @page {
            size: 21.59cm 13.97cm;
            margin: 120px 0px 70px 0px; /* Adjust bottom margin to make space for footer */
        }

        body {
            width: 100%;
            font-size: 0.8rem;
             font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 0;
        }

        .header {
            position: fixed;
            top: -90px;
            left: 0;
            right: 0;
            height: 105px;
           
            text-align: center;
            padding: 5px;
            box-sizing: border-box;
        }

        table {
            border-collapse: collapse;
            width: 95%;            
            margin:0 auto;
        }

        .logo {
            max-width: 100%;
            height: 100px;
        }

        .border-black {
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

        .footer {
            position:fixed;
            margin-top:-10px;
            margin-left:15px;
            width:100%;
        }

        .page-break {
            page-break-before: always;
        }

        .page-number {
            position: absolute;
            align-items: bottom;
        }


    </style>
</head>

<body>
    <div class="header" style="margin-top:5px">
        <table style="margin-top: -40px">
            <thead>
                <tr>
                    <th rowspan="4" style="width: 13%; height: 15%;">
                        <img src="{{ public_path('tokomama.svg') }}" class="logo" style="width: 60%; height: 55%;">
                    </th>
                    <td style="font-weight: bold; font-size: 1rem;">MAMA BAHAGIA</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: 0.8rem;">Jl. Baru (Ruko depan PLN) Abepura, Jayapura</td>
                    <td style="font-weight: bold; font-size: 1.2rem; text-align: center;"><u>INVOICE</u></td>
                </tr>
                <tr>
                    <td style="font-size: 0.8rem;">Telp: 08112692861 / 08112692859</td>
                    <td style="text-align: center; font-size: 0.8rem">NO : {{ $invoice ?? '-' }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center; font-size: 0.8rem">TOP : {{ $data->first()->transaksi->suratJalan->customer->top }}</td>
                </tr>
            </thead>
        </table>
        <table class="info-table">
            <tbody>
                <tr>
                    <td class="header-cell" style="text-align:left ;padding-left:40px">Customer : {{ $data->first()->transaksi->suratJalan->customer->nama . ' - ' . $data->first()->transaksi->suratJalan->customer->kota ?? '-' }}</td>
                    <td class="header-cell" style="padding-right:50px">Sales : {{ $data->first()->transaksi->suratJalan->customer->sales }}</td>
                </tr>
                <tr>
                    <td class="header-cell" style="text-align:left ;padding-left:40px">{{ $data->first()->transaksi->suratJalan->customer->alamat }}</td>
                </tr>
                <tr style="margin-top:30px">
                    <td class="header-cell" style="text-align:left ;padding-left:40px; margin:90px">({{ $data->first()->transaksi->suratJalan->customer->no_telp ?? '-' }})</td>
                </tr>
            </tbody>
        </table>
    </div>
    <main style="margin-top: 20px">   
        <br>     
        @php
            $items_per_page = 11;
            $dates_per_page = 11;
            $total_items = $data->count();
            $total_dates = $data->pluck('transaksi.suratJalan.tgl_sj')->unique()->count();
            $pages = ceil(max($total_items / $items_per_page, $total_dates / $dates_per_page));
        @endphp

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

        @for ($page = 1; $page <= $pages; $page++)
            @php
                $start_item = ($page - 1) * $items_per_page;
                $end_item = min($start_item + $items_per_page, $total_items);

                $start_date = ($page - 1) * $dates_per_page;
                $end_date = min($start_date + $dates_per_page, $total_dates);
            @endphp

            <table class="table border border-black" style="font-size: 0.7rem; margin-top: -10px">
                <thead>
                    <tr>
                        <th class="border border-black">No.</th>
                        <th class="border border-black">Tgl Barang Masuk</th>
                        <th class="border border-black">Nama Barang</th>
                        <th class="border border-black">No. Cont</th>
                        <th class="border border-black">Quantity</th>
                        <th class="border border-black">Harga Satuan (Rp)</th>
                        <th class="border border-black">Total (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = $start_item; $i < $end_item; $i++)
                        @php
                            $item = $data[$i];
                            $total += $item->harga * $item->jumlah;
                        @endphp
                        <tr>
                            <td class="text-center border border-black">{{ $i + 1 }}</td>
                            <td class="text-center border border-black">{{ date('d M Y', strtotime($item->transaksi->suratJalan->tgl_sj)) }}</td>
                            <td class="border border-black">
                                {{ $item->transaksi->barang->nama }} <br>
                                @if($item->transaksi->satuan_jual != $item->transaksi->barang->satuan->nama_satuan )
                                (Total {{ number_format($item->jumlah * $item->transaksi->barang->value) }} {{ $item->transaksi->barang->satuan->nama_satuan }} {{ ($item->transaksi->keterangan != '' || !is_null($item->transaksi->keterangan)) ? '= '.$item->transaksi->keterangan:'' }})
                                 @else
                                {{ ($item->transaksi->keterangan != '' || !is_null($item->transaksi->keterangan)) ? '= '.$item->transaksi->keterangan:'' }}
                                @endif
                            </td>
                            <td class="text-center border border-black">
                                @if($i == 0 || ($i > 0 && ($i % 11 == 0))) {{-- Menampilkan $no_cont pada baris pertama dan setiap kelipatan 11 --}}
                                    {{ $no_cont ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>                    
                            <td class="text-center border border-black">{{ number_format($item->jumlah, 0, ',', '.') }} {{ $item->transaksi->satuan_jual }}</td>
                            <td class="border border-black" style="text-align: right;">{{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="border border-black" style="text-align: right;">{{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    @endfor
                    @if ($page == $pages) 
                    <tr>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="text-center border border-black"></td>
                    <td class="border border-black">
                        Subtotal
                        <br>
                        DPP 11/12
                        <br>
                        @if($barang->status_ppn == 'ya')
                        PPN 12%
                        @else
                        PPN 12% (DIBEBASKAN)
                        @endif
                    </td>
                    <td class="border border-black" style="text-align: right;" >
                        @php
                            $dpp = $total * 11/12;
                        @endphp
                    {{ number_format($total, 0, ',', '.') }}
                    <br>
                        {{ number_format($dpp, 0, ',', '.') }}
                        <br>
                    @if($barang->status_ppn == 'ya')
                        {{ number_format(($barang->value_ppn / 100) * $dpp, 0, ',', '.') }}
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
                    <td class="border border-black" style="text-align: right;" >
                    @if($barang->status_ppn == 'ya')
                        <b>{{ number_format(($total * 0.11) + ($total), 0, ',', '.') }}</b>
                    @else
                        <b>{{ number_format($total, 0, ',', '.') }}</b>
                    @endif
                    </td>
                </tr>
                </tbody>
                @endif
            </table>

    <div class="footer">
        @if ($page == $pages)
            <p style="font-weight: bold;padding-left:30px; font-size: 0.8rem"> 
                Terbilang: 
                @if($barang->status_ppn == 'ya')
                    {{ ucwords(strtolower(terbilang(round($total * 1.11)))) }} Rupiah
                @else
                    {{ ucwords(strtolower(terbilang(round($total)))) }} Rupiah
                @endif
            </p>
            <table style="font-size: 0.8rem;">
                <tr>
                    <th style="text-align: left; padding-left: 50px; font-style: italic;">Pembayaran ke rekening:</th>
                    <td style="align-items:right ;text-align: center;">Surabaya, {{ $formattedDate }}</td>
                </tr>
                <tr>
                    <th style="text-align: left; padding-left: 50px; font-style: italic;">CV. SARANA BAHAGIA</th>
                    <td style="text-align: center;">Hormat Kami</td>
                </tr>
                <tr>
                    <th style="text-align: left; padding-left: 50px; font-style: italic;">Mandiri (Cab.Indrapura) : 14.000.45006.005</th>
                    <th></th>
                </tr>
                <tr>
                    <th style="text-align: left; padding-left: 50px;"></th>
                    <th style="padding-top:30px">(MAMA BAHAGIA)</th>
                </tr>
            </table>
        @endif
    
    </div>
    <p class="page-number" style=" position: fixed; align-items:bottom ; left: 10px; bottom: -50px; margin: 0; font-size: 0.8rem;">Halaman: {{ $page }} dari {{ $pages }}</p>


            

            @if ($page < $pages)
                <div class="page-break"></div>
                
            @endif
        @endfor
    </main>
</body>

</html>
