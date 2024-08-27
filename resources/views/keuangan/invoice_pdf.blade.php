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
            margin: 0;
            padding: 0;
        }

        .header {
            position: fixed;
            top: -130px;
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
    <div class="header" style="margin-top:10px">
        <table>
            <thead>
                <tr>
                    <th rowspan="4" style="width: 13%; height: 15%;">
                        <img src="{{ public_path('logo_sb.svg') }}" class="logo" style="width: 60%; height: 55%;">
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
            </thead>
        </table>
        <table class="info-table">
            <tbody>
                <tr>
                    <td class="header-cell" style="text-align:left ;padding-left:40px">Customer : {{ $data->first()->transaksi->suratJalan->customer->nama ?? '-' }}</td>
                    <td class="header-cell" style="text-align:center;">KAPAL : {{ $data->first()->transaksi->suratJalan->nama_kapal }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <main>
        <br>
        
        @php
            $items_per_page = 6;
            $dates_per_page = 6;
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

            <table class="table border border-black" style="font-size: 0.7rem;">
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
                    @for ($i = $start_item; $i < $end_item; $i++)
                        @php
                            $item = $data[$i];
                            $total += $item->harga * $item->jumlah;
                        @endphp
                        <tr>
                            <td class="text-center border border-black">{{ $i + 1 }}</td>
                            <td class="text-center border border-black">{{ date('d M Y', strtotime($item->transaksi->suratJalan->tgl_sj)) }}</td>
                            <td class="text-center border border-black">
                                {{ $item->transaksi->barang->nama }} <br>
                                @if ($item->transaksi->barang->satuan->nama_satuan != $item->transaksi->satuan_jual)
                                    (Total {{ number_format($item->jumlah * $item->transaksi->barang->value) }} {{ 
                                    $item->transaksi->barang->satuan->nama_satuan }} @if($item->transaksi->keterangan == null) 
                                    {{ $item->transaksi->keterangan }} @endif)
                                @endif
                            </td>
                            <td class="text-center border border-black">{{ $no_cont ?? '-' }}</td>
                            <td class="text-center border border-black">{{ $item->jumlah }} {{ $item->transaksi->satuan_jual }}</td>
                            <td class="text-center border border-black">{{ number_format($item->harga, 2, ',', '.') }}</td>
                            <td class="text-center border border-black">{{ number_format($item->harga * $item->jumlah, 2, ',', '.') }}</td>
                        </tr>
                    @endfor
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
                    <td class="border border-black text-center" >
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
                    <td class="border border-black text-center" >
                        @if($barang->status_ppn == 'ya')
                        <b>{{ number_format(($total * 0.11) + ($total)) }}</b>
                        @else
                        <b>{{ number_format($total) }}</b>
                        @endif
                    </td>
                </tr>
                </tbody>
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
                    <th style="text-align: left; padding-left: 50px; font-style: italic;">CV. Sarana Bahagia</th>
                    <td style="text-align: center;">Hormat Kami</td>
                </tr>
                <tr>
                    <th style="text-align: left; padding-left: 50px; font-style: italic;">Mandiri (Cab.Indrapura) : 14.000.45006.005</th>
                    <th></th>
                </tr>
                <tr>
                    <th style="text-align: left; padding-left: 50px;"></th>
                    <th style="padding-top:30px">(Dwi Satria Wardana)</th>
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
