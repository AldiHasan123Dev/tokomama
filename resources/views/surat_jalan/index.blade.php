<x-Layout.layout>
    <x-keuangan.card-keuangan>
        <x-slot:tittle>List Surat Jalan</x-slot:tittle>
        <div class="overflow-x-auto">
            <table class="table" id="table-getfaktur">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>Invoice</th>
                        <th>No. Surat</th>
                        <th>Kepada</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Jenis Barang</th>
                        <th>Nama Kapal</th>
                        <th>No. Count</th>
                        <th>No. Seal</th>
                        <th>No. Pol</th>
                        <th>No. Job</th>
                        <th>No. Tujuan</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </x-keuangan.card-keuangan>

    {{-- <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script> --}}
    <x-slot:script>
        <script>
            let table = $(`#table-getfaktur`).DataTable({
                ajax: {
                    method:"POST",
                    url: "{{route('surat-jalan.data')}}",
                    data:{
                        _token: "{{csrf_token()}}"
                    }
                },
                // scrollX:true,
                columns: [
                    { data: 'aksi', name: 'aksi' },
                    { data: 'invoice', name: 'No. Invoice' },
                    { data: 'nomor_surat', name: 'No. Surat' },
                    { data: 'kepada', name: 'kepada' },
                    { data: 'jumlah', name: 'jumlah' },
                    { data: 'satuan', name: 'satuan' },
                    { data: 'jenis_barang', name: 'jenis_barang' },
                    { data: 'nama_kapal', name: 'nama_kapal' },
                    { data: 'no_cont', name: 'no_cont' },
                    { data: 'no_seal', name: 'no_seal' },
                    { data: 'no_pol', name: 'no_pol' },
                    { data: 'tujuan', name: 'tujuan' },
                    { data: 'id', name: 'id', visible:false},
                    
                ]
            });
        </script>

    </x-slot:script>
</x-Layout.layout>