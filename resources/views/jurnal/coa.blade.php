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
                            <th>Kategori-LR</th>
                        </tr>
                    </thead>
                </table>
            </form>
        </div>

        <x-master.card-master>
            <x-slot:tittle>Menambah Data COA</x-slot:tittle>
            <form action="{{ route('jurnal.coa.store') }}" method="post" class="grid grid-cols-3 gap-5">
                @csrf
                <label class="form-control w-full max-w-xs col-start-1">
                    <div class="label">
                        <span class="label-text">No. Akun <span class="text-red-500">*</span></span>
                    </div>
                    <input type="text" placeholder="No. Akun" name="no_akun" class="input input-bordered w-full max-w-xs rounded-md" required />
                </label>
                <label class="form-control w-full max-w-xs col-start-2">
                    <div class="label">
                        <span class="label-text">Nama Akun <span class="text-red-500">*</span></span>
                    </div>
                    <input type="text" placeholder="Nama Akun" name="nama_akun" class="input input-bordered w-full max-w-xs rounded-md" required />
                </label>
                <label class="input border flex items-center gap-2 mt-3">
                    Status:
                    <select name="status" class="select select-sm select-bordered w-full max-w-xs">
                        <option disabled selected>Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="non-aktif">Non-Aktif</option>
                    </select>
                </label>
                <label class="input border flex items-center gap-2 mt-3">
                    Tabel:
                    <select name="tabel" class="select select-sm select-bordered w-full max-w-xs">
                        <option disabled selected></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                    </select>
                </label>
                <div class="col-span-3 mt-8 text-center">
                    <button type="submit" class="btn text-semibold text-white bg-green-500 w-1/3 mx-auto">Simpan Data COA</button>
                </div>
            </form>
        </x-master.card-master>
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
