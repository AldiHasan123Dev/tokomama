<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $surat_jalan->nomor_surat }}</title>
    <style>
        @page {
            size: 21.59cm 13.97cm;
            margin: 145px 0px 50px 0px /* Adjust bottom margin to make space for footer */
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
            height: 0px;

            text-align: center;
            padding: 5px;
            box-sizing: border-box;
        }

        .content {
            height: 20px;
        }

        .logo {
            width: 70px;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin:0 auto;
        }

        .border-black {
            border: 1px solid black;
            padding: 0px;
        }

        .text-center {
            text-align: center;
            justify-content: center;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 76px; /* Same as bottom margin of @page */
           
            text-align: center;
            width: 100%;
        }

        .footer-content {
            position:fixed;
            padding-top:14px;
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
    <div class="header">
        <table>
            <thead>
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
    </div>

    <div class="content">
        @php
            $items_per_page = 13;
            $total_items = $surat_jalan->transactions->count();
            $pages = ceil($total_items / $items_per_page);
        @endphp

        @for ($page = 1; $page <= $pages; $page++)
            @php
                $start = ($page - 1) * $items_per_page;
                $end = min($start + $items_per_page, $total_items);
            @endphp

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
                    @for ($i = $start; $i < $end; $i++)
                        @php
                            $item = $surat_jalan->transactions[$i];
                        @endphp
                        <tr>
                            <td class="text-center" style="vertical-align: top; border-right: 1px solid black">
                                <span>{{ $i + 1 }}</span><br>
                            </td>
                            <td class="text-center" style="vertical-align: top; border-right: 1px solid black">
                                <span>{{ number_format($item->jumlah_beli) }}</span>
                            </td>
                            <td class="text-center" style="vertical-align: top; border-right: 1px solid black">
                                <span>{{ $item->satuan_beli }}</span><br>
                            </td>
                            <td class="px-2" style="padding: 0px 5px">
                                <div class="flex justify-between mt-3">
                                    <span>{{ $item->barang->nama_singkat }}</span>
                                    <span>({{ number_format($item->jumlah_jual) }} {{ $item->satuan_jual }})</span>
                                </div>
                                @if (str_contains($item->satuan_jual, $item->barang->satuan->nama_satuan))
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
                            @if ($i == $start)
                                <td class="border border-black text-center" rowspan="{{ 5 + $end - $start }}">
                                    
                                    {{ $surat_jalan->customer->nama && $surat_jalan->customer->nama !== '-' ? $surat_jalan->customer->nama : '-' }} <br>
                                    {{ $surat_jalan->customer->kota && $surat_jalan->customer->kota !== '-' ? $surat_jalan->customer->kota : '' }} 
                                </td>
                            @endif
                        </tr>
                    @endfor

                    @if ($page == $pages)
                        <tr>
                            <td style="vertical-align: top; border-right: 1px solid black" rowspan="5"></td>
                            <td style="vertical-align: top; border-right: 1px solid black" rowspan="5"></td>
                            <td style="vertical-align: top; border-right: 1px solid black" rowspan="5"></td>
                            <td class="border border-black py-1" style="padding: 0 5px;">
                                Nama Kapal: {{ $surat_jalan->nama_kapal }} </td>
                        </tr>
                        <tr>
                            <td class="border border-black py-1" style="padding: 0 5px;">
                                No. Cont: {{ $surat_jalan->no_cont }} </td>
                        </tr>
                        <tr>
                            <td class="border border-black py-1" style="padding: 0 5px;">
                                No. Seal: {{ $surat_jalan->no_seal }} </td>
                        </tr>
                        <tr>
                            <td class="border border-black py-1" style="padding: 0 5px;">
                                No. Pol: {{ $surat_jalan->no_pol }} </td>
                        </tr>
                        <tr>
                            <td class="border border-black py-1" style="padding: 0 5px;">
                                No. Job: {{ $surat_jalan->no_job }} </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            
            <div class="footer" >
                
            <p class="page-number" style="  align-items:bottom ; right: 10px; bottom: -20px; margin: 0; font-size: 0.8rem;">Halaman: {{ $page }} dari {{ $pages }}</p>
            </div>
            <div class="footer-content">
                    @if ($page == $pages)
                        <p>Note &nbsp; : &nbsp; Barang yang diterima dalam keadaan baik dan lengkap</p>
                        <table>
                            <tr>
                                <th style="width: 50%;"></th>
                                <th style="width: 50%; text-align: right; font-weight: normal !important; padding-right:20px">
                                    {{ $surat_jalan->kota_pengirim }}, {{ date('d M Y', strtotime($surat_jalan->tgl_sj)) }}
                                </th>
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
                                <td style="height: 15px;"></td>
                            <tr>
                                <th style="height: 30px"> </th>
                                <th></th>
                            </tr>
                            <tr>
                                <th>({{ $surat_jalan->nama_penerima }})</th>
                                <th>({{ $surat_jalan->nama_pengirim }})</th>
                            </tr>
                        </table>
                    @endif
                    
                </div>

            @if ($page < $pages)
                <div class="page-break"></div>
            @endif
        @endfor
    </div>
</body>

</html>
