<x-Layout.layout>
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
    <x-keuangan.card-keuangan>
        <x-slot:tittle>DRAF INVOICE</x-slot:tittle>
        <x-slot:button>
            <form action="{{ route('keuangan.invoice.submit',$surat_jalan) }}" method="post">
                @csrf
                <button type="submit" onclick="return confirm('Submit Invoice?')"
                    class="btn btn-primary btn-sm text-black">Submit Invoice</button>
            </form>
        </x-slot:button>
        <div class="overflow-x-auto">
            <main>
                <table>
                    <thead>
                        <tr>
                            <th rowspan="4" style="width: 20%">
                                <img src="{{ url('logo-sb.jpg') }}" class="logo">
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
                            <td style="text-align: center;">NO: {{ $surat_jalan->invoice ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Fax: 031-7495507</td>
                            <td></td>
                        </tr>
                        <br>
                        <tr>
                            <td style="text-align: left; padding-left: 45px;" colspan="2">Customer &nbsp;&nbsp;&nbsp; :
                                &nbsp;&nbsp;&nbsp;
                                {{$surat_jalan->customer->nama ?? '-' }}</td>
                            <td style="text-align: center;"><span style="font-weight: bold;">KAPAL: </span>
                                &nbsp;&nbsp;&nbsp;
                                {{ $surat_jalan->nama_kapal }}
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
                        @php
                        $total = 0;
                        @endphp
                        @foreach ($surat_jalan->transactions as $item)
                        <tr>
                            <td class="text-center border border-black">{{ $loop->iteration }}</td>
                            <td class="text-center border border-black">{{ date('d M Y',
                                strtotime($surat_jalan->tgl_sj)) }}</td>
                            <td class="text-center border border-black">{{ $item->barang->nama }}</td>
                            <td class="text-center border border-black">{{ $surat_jalan->no_cont }}</td>
                            <td class="text-center border border-black">{{ $item->jumlah_jual }}</td>
                            <td class="text-center border border-black">{{ number_format($item->harga_jual) }}</td>
                            <td class="text-center border border-black">{{ number_format($item->jumlah_jual *
                                $item->harga_jual) }}</td>
                        </tr>
                        @php
                        $total += ($item->jumlah_jual * $item->harga_jual);
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
                                Rp {{ number_format($total) }}
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
                                <b>Rp {{ number_format($total) }}</b>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <p style="font-weight: bold;">Terbilang: Sebelas Juta</p>

                <br>

                <table>
                    <tr>
                        <th style="text-align: left; padding-left: 50px;">Pembayaran ke rekening:</th>
                        <td style="text-align: center;">Surabaya, @for($i = 1; $i <= 1; $i++){{ date('d M Y',
                                strtotime($surat_jalan->tgl_sj)) }}@endfor</td>
                    </tr>
                    <tr>
                        <th style="text-align: left; padding-left: 50px;">CV. Sarana Bahagia</th>
                        <td style="text-align: center;">Hormat Kami</td>
                    </tr>
                    <tr>
                        <th style="text-align: left; padding-left: 50px;">Mandiri (Cab.Indrapura) : 14.000.45006.005
                        </th>
                        <th style="padding: 50px 0px;"></th>
                    </tr>
                    <tr>
                        <th style="text-align: left; padding-left: 50px;"></th>
                        <th>(Dwi Satria Wardana)</th>
                    </tr>
                </table>
            </main>
        </div>
    </x-keuangan.card-keuangan>
</x-Layout.layout>