<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Invoice</th>
            <th>NPWP</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Nama NPWP</th>
            <th>Alamat NPWP</th>
            <th>Tanggal Faktur</th>
            <th>Tujuan / Nama Customer</th>
            <th>Uraian</th>
            <th>Faktur</th>
            <th>Sub Total</th>
            <th>PPN</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($surat_jalan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->invoice }}</td>
                <td>{{ $item->customer->npwp }}</td>
                <td>{{ $item->customer->nik }}</td>
                <td>{{ $item->customer->nama }}</td>
                <td>{{ $item->customer->nama_npwp }}</td>
                <td>{{ $item->customer->alamat_npwp }}</td>
                <td>{{ $item->tgl_invoice }}</td>
                <td>{{ $item->customer->alamat }} / {{ $item->customer->nama }}</td>
                <td>{{ $item->nsfp->keterangan }}</td>
                <td>{{ $item->nsfp->nomor }}</td>
                <td>1000 belum</td>
                <td>11%</td>
                <td>Belum</td>
            </tr>
        @endforeach

    </tbody>
</table>