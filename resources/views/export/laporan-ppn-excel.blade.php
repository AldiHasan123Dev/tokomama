<table>
    <thead>
        <tr>
            <th>No. </th>
            <th>Invoice</th>
            <th>NPWP</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Nama NPWP</th>
            <th>Alamat NPWP</th>
            <th>Tanggal Faktur</th>
            <th>Tujuan</th>
            <th>Uraian</th>
            <th>Faktur</th>
            <th>Sub Total</th>
            <th>PPN</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $item)
            <tr>
                <th>{{ $loop->iteration }}</th>
                <th>{{ $item->invoice }}</th>
                <th>{{ $item->transaksi->suratJalan->customer->npwp }}</th>
                <th>{{ $item->transaksi->suratJalan->customer->nik }}</th>
                <th>{{ $item->transaksi->suratJalan->customer->nama }}</th>
                <th>{{ $item->transaksi->suratJalan->customer->nama_npwp }}</th>
                <th>{{ $item->transaksi->suratJalan->customer->alamat_npwp }}</th>
                <th>{{ $item->tgl_invoice }}</th>
                <th>{{ $item->transaksi->suratJalan->customer->nama }}</th>
                <th>{{ $item->transaksi->barang->nama }}</th>
                <th>{{ $item->nsfp->nomor }}</th>
                <th>{{ $item->subtotal }}</th>

                @if ($item->transaksi->barang->status_ppn == 'ya')
                    <th>{{ $item->transaksi->barang->value_ppn }}%</th>
                @else
                    <th>0%</th>
                @endif

                @if ($item->transaksi->barang->status_ppn == 'ya')
                    <th>{{ round($item->subtotal + ($item->subtotal * ($item->transaksi->barang->value_ppn / 100))) }}</th>
                @else
                    <th>{{ $item->subtotal }}</th>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>

<script>

</script>