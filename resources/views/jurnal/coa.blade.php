<x-Layout.layout>
    <x-keuangan.card-keuangan>
        <x-slot:tittle>Tabel COA</x-slot:tittle>
        <div class="overflow-x-auto">
            <form action="{{ route('jurnal.coa') }}" method="post">
                @csrf
                @foreach($coa as $c)
                    <input type="hidden" name="coa" id="{{ $c->id }}" value="{{ $c->id }}">
                @endforeach
                <button class="btn bg-green-400 text-white my-5 py-4 font-bold hidden" id="aktif" type="submit">Ubah Status COA</button>
                <table class="table" id="coa_table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. Akun</th>
                            <th>Nama Akun</th>
                            <th>Status</th>
                            <th>Tabel</th>
                        </tr>
                    </thead>
                </table>
            </form>
        </div>
    </x-keuangan.card-keuangan>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.3/js/dataTables.select.js"></script>
    <script>
        $(document).ready(function () {
            var table = $('#coa_table').DataTable({
                serverSide: true,
                select:true,
                ajax: {
                    url: "{{ route('coa.data') }}",
                    type: 'POST'
                },
                columns: [
                    { data: '#' },
                    { data: 'no_akun' },
                    { data: 'nama_akun' },
                    { data: 'status' },
                    { data: 'tabel' }
                ]
            });

            $('#coa_table tbody').on('click', 'tr', function () {
                let row =  table.row( this ).data();
                $('.btn').removeClass('hidden');
                $('#print').attr('href', "{{ route('invoice.print', ['id' => ':id']) }}".replace(':id', row.id));
            });
        });
    </script>
</x-Layout.layout>