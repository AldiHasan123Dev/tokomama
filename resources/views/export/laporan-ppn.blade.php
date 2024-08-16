<table>
    <thead>
        <tr>
            <th>FK</th>
            <th>KD_JENIS_TRANSAKSI</th>
            <th>FG_PENGGANTI</th>
            <th>NOMOR_FAKTUR</th>
            <th>MASA_PAJAK</th>
            <th>TAHUN_PAJAK</th>
            <th>TANGGAL_FAKTUR</th>
            <th>NPWP</th>
            <th>NAMA</th>
            <th>ALAMAT_LENGKAP</th>
            <th>JUMLAH_DPP</th>
            <th>JUMLAH_PPN</th>
            <th>JUMLAH_PPNBM</th>
            <th>ID_KETERANGAN_TAMBAHAN</th>
            <th>FG_UANG_MUKA</th>
            <th>UANG_MUKA_DPP</th>
            <th>UANG_MUKA_PPN</th>
            <th>UANG_MUKA_PPNBM</th>
            <th>REFERENSI</th>
            <th>KODE_DOKUMEN_PENDUKUNG</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @foreach ($invoices as $item)
            @php
                $invoice_of = App\Models\Invoice::where('invoice', $item->invoice)->get();
                // dd($invoice_of[0]->transaksi->harga_jual);

                foreach ($invoice_of as $of) {
                    $total += $of->transaksi->harga_jual * $of->transaksi->jumlah_jual;
                }
            @endphp
            <tr>
                <td>FK</td>
                <td>
                    @if ($item->transaksi->barang->status_ppn == 'ya')
                        010
                    @else
                        080
                    @endif
                </td>
                <td>0</td>
                <td>{{ substr($item->nsfp->nomor, 6) }}</td>
                <td>{{ date('n', strtotime($item->tgl_invoice)) }}</td>
                <td>{{ date('Y', strtotime($item->tgl_invoice)) }}</td>
                <td>{{ date('d/m/Y', strtotime($item->tgl_invoice)) }}</td>
                <td>{{ $item->transaksi->suratJalan->customer->npwp }}</td>
                <td>"{{ $item->transaksi->suratJalan->customer->nama_npwp }}"</td>
                <td>"{{ $item->transaksi->suratJalan->customer->alamat_npwp }}"</td>
                <td>{{ $total }}</td>
                @php
                    $total = 0;
                @endphp
                <td>
                    @if ($item->transaksi->barang->status_ppn == 'ya')
                        {{ $invoices->sum('subtotal') * ($item->transaksi->barang->value_ppn / 100) }}
                    @else
                        0
                    @endif
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>"{{ $item->invoice }}"</td>
                <td></td>
            </tr>

            @foreach ($invoice_of as $of)
                <tr>
                    <td>OF</td>
                    <td>""</td>
                    <td>"{{ $of->transaksi->barang->nama }}"</td>
                    <td>{{ $of->transaksi->harga_jual }}</td>
                    <td>{{ $of->transaksi->jumlah_jual }}</td>
                    <td>{{ $of->transaksi->harga_jual * $of->transaksi->jumlah_jual }}</td>
                    <td>0</td>
                    <td>{{ $of->transaksi->harga_jual * $of->transaksi->jumlah_jual }}</td>
                    <td>
                        @if ($of->transaksi->status_ppn == 'ya')
                            {{ ($of->transaksi->harga_jual * $of->transaksi->jumlah_jual) * ($item->transaksi->value_ppn / 100) }}
                        @else
                            0
                        @endif
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

<script>

</script>