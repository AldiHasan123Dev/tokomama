<x-Layout.layout>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="grid grid-cols-5">
                <div>
                    <button class="btn btn-sm bg-green-400 text-white font-bold w-fit">Edit tanggal</button>
                </div>
                <div>
                    <p>List Semua Invoice </p>
                </div>
                <div>
                    <p class="font-bold">INVOICE (selected): </p>
                </div>
                <div>
                    <button class="btn btn-sm bg-blue-400 text-white font-bold w-fit">Rekap Invoice Excel</button>
                </div>
                <div>
                    <button class="btn btn-sm bg-green-400 text-white font-bold w-fit"><i class="fas fa-print"></i>
                        Cetak Invoice Ulang</button>
                </div>
            </div>
            <table id="surat_jalan_table" class="display mt-3">
                <thead>
                    <tr>
                        <th>Nomor Surat</th>
                        <th>Kepada</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Jenis Barang</th>
                        <th>Nama Kapal</th>
                        <th>No. Cont</th>
                        <th>No. Seal</th>
                        <th>No. Pol</th>
                        <th>Tujuan</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            var table = $('#surat_jalan_table').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ route('suratJalan.data') }}",
                    dataSrc: 'data',
                    method: 'POST',
                },
                columns: [
                    { data: 'nomor_surat' },
                    { data: 'kepada' },
                    { data: 'jumlah' },
                    { data: 'satuan' },
                    { data: 'jenis_barang' },
                    { data: 'nama_kapal' },
                    { data: 'no_cont' },
                    { data: 'no_seal' },
                    { data: 'no_pol' },
                    { data: 'tujuan' },
                    { data: 'created_at' },
                    { data: 'updated_at' },
                ]
            });

            table.on('draw', function () {
                alert('Table redrawn');
            });
        });
    </script>
</x-Layout.layout>