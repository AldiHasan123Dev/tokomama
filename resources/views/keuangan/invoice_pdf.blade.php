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
    </style>
</head>

<body>
    @foreach ($surat_jalan as $sj)
    <main>
        <table>
            <thead>
                <tr>
                    <th rowspan="4" style="width: 20%">
                        <img src="{{ public_path('logo-sb.jpg') }}" class="logo">
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
                    <td style="text-align: center;">NO: {{ $sj->invoice }}</td>
                </tr>
                <tr>
                    <td>Fax: 031-7495507</td>
                    <td></td>
                </tr>
                <br>
                <tr>
                    <td style="text-align: left; padding-left: 45px;" colspan="2">Customer &nbsp;&nbsp;&nbsp; :
                        &nbsp;&nbsp;&nbsp;
                        {{$sj->tujuan }}</td>
                    <td style="text-align: center;"><span style="font-weight: bold;">KAPAL: </span> &nbsp;&nbsp;&nbsp;
                        {{ $sj->nama_kapal }}
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
                    <th class="border border-black">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center border border-black">{{ $loop->iteration }}</td>
                    <td class="text-center border border-black">{{ $sj->tgl_invoice }}</td>
                    <td class="text-center border border-black">{{ $sj->jenis_barang }}</td>
                    <td class="text-center border border-black">{{ $sj->no_cont }}</td>
                    <td class="text-center border border-black">{{ 0 }}</td>
                    <td class="text-center border border-black">{{ 0 }}</td>
                    <td class="text-center border border-black">{{ 0 }}</td>
                </tr>
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
                        Rp 355.300.000
                        <br>
                        Rp
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
                        <b>Rp 355.300.000</b>
                    </td>
                </tr>
            </tbody>
        </table>

        <p style="font-weight: bold;">Terbilang: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tiga Ratus Lima Puluh Lima Juta Tiga
            Ratus Ribu Rupiah</p>

        <br>

        <table>
            <tr>
                <th style="text-align: left; padding-left: 50px;">Pembayaran ke rekening:</th>
                <td style="text-align: center;">Surabaya, 27 Maret 2024</td>
            </tr>
            <tr>
                <th style="text-align: left; padding-left: 50px;">CV. Sarana Bahagia</th>
                <td style="text-align: center;">Hormat Kami</td>
            </tr>
            <tr>
                <th style="text-align: left; padding-left: 50px;">Mandiri (Cab.Indrapura) : 14.000.45006.005</th>
                <th style="padding: 50px 0px;"></th>
            </tr>
            <tr>
                <th style="text-align: left; padding-left: 50px;"></th>
                <th>(Dwi Satria Wardana)</th>
            </tr>
        </table>
    </main>
    @endforeach
</body>

</html>