<x-Layout.layout>
    <x-keuangan.card-keuangan>
        <x-slot:tittle>Jurnal Buku Besar Pembantu</x-slot:tittle>
        <div class="overflow-x-auto">
            <div class="grid grid-cols-3 mb-5">
                <div>
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text">Subjek</span>
                        </div>
                        <select class="js-example-basic-single" name="state">
                            <option value="AL">Alabama</option>
                              ...
                            <option value="WY">Wyoming</option>
                        </select>
                    </label>
                </div>
                <div>
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text">Akun</span>
                        </div>
                        <select class="js-example-basic-single" name="state">
                            @foreach ($coa as $c)
                                <option disabled selected></option>
                                <option value="{{ $c->id }}">{{ $c->no_akun }} - {{ $c->nama_akun }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div>
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text">Tahun</span>
                        </div>
                        <select class="js-example-basic-single w-1/2" name="akun">
                            <option selected value="{{ date('Y') }}">{{ date('Y') }}</option>
                            @for($year = date('Y'); $year >= 2024; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </label>
                </div>
            </div>

            <label for="tahun" class="mr-2 margin-top:40px">Bulan:</label>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black " id="aktif" type="submit">Jan</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Feb</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Mar</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Apr</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Mei</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Jun</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Jul</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Aug</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Sep</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Okt</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Nov</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Des</button>

            <table id="table-buku-besar">
                <thead>
                    <tr>
                        <th>No. </th>
                        <th>Customer</th>
                        <th>Debit</th>
                        <th>Kredit</th>
                        <th>Saldo</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
    @foreach ($customers as $key => $customer)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $customer->nama }}</td> 
            <td>{{ $customer->debit }}</td>  <!-- Menampilkan total debit -->
            <td>{{ $customer->kredit }}</td>  <!-- Menampilkan total kredit -->
            <td>{{ $customer->debit - $customer->kredit }}</td>  <!-- Menghitung saldo -->
            <td><button class="btn btn-primary">Aksi</button></td> 
        </tr>
    @endforeach
</tbody>

            </table>

        </div>
    </x-keuangan.card-keuangan>

    <script>
   $(document).ready(function () {
    $('.js-example-basic-single').select2();

    var table = $('#table-buku-besar').DataTable({
        data: {!! json_encode($customers) !!}, 
        columns: [
            { data: null, render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1; 
            }},
            { data: 'nama' }, // Kolom customer
            { data: 'debit' }, // Ambil nilai debit dari model
            { data: 'kredit' }, // Ambil nilai kredit dari model
            { 
                data: null, 
                render: function (data, type, row) {
                    return row.debit - row.kredit; // Menghitung saldo
                } 
            },
            { data: null, defaultContent: '<button class="btn btn-primary">Aksi</button>' } 
        ]
    });
});

</script>

</x-Layout.layout>
