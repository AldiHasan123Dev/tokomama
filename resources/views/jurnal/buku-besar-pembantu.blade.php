<x-Layout.layout>
    <x-keuangan.card-keuangan>
        <x-slot:tittle>Jurnal Buku Besar Pembantu</x-slot:tittle>
        <div class="overflow-x-auto">
            <form method="GET" action="{{ route('buku-besar-pembantu.index') }}" id="filter-form">
                <div class="grid grid-cols-3 mb-5">
                    <div>
                        <label class="form-control w-full max-w-xs">
                            <div class="label">
                                <span class="label-text">Subjek</span>
                            </div>
                            <select class="js-example-basic-single" name="state">
                                <option value="AL">Customer</option>
                                <!-- Other options -->
                                <option value="WY">Supliers</option>
                            </select>
                        </label>
                    </div>
                    <div>
                        <label class="form-control w-full max-w-xs">
                            <div class="label">
                                <span class="label-text">Akun</span>
                            </div>
                            <select class="js-example-basic-single" name="coa_id" id="coa-select"> <!-- Added id -->
                                @foreach ($coa as $c)
                                    <option value="{{ $c->id }}" {{ $selectedCoaId == $c->id ? 'selected' : '' }}>{{ $c->no_akun }} - {{ $c->nama_akun }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <div>
                        <label class="form-control w-full max-w-xs">
                            <div class="label">
                                <span class="label-text">Tahun</span>
                            </div>
                            <select class="js-example-basic-single w-1/2" name="year" id="year-select"> <!-- Added id -->
                                @for($year = 2030; $year >= 2023; $year--)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </label>
                    </div>
                </div>
                <label for="tahun" class="mr-2 margin-top:40px">Bulan:</label>
                @foreach (['Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4, 'Mei' => 5, 'Jun' => 6, 'Jul' => 7, 'Aug' => 8, 'Sep' => 9, 'Okt' => 10, 'Nov' => 11, 'Des' => 12] as $monthName => $monthNumber)
                    <button class="btn my-5 py-4 font-bold border-black 
                        {{ $selectedMonth == $monthNumber ? 'bg-green-600 text-white' : 'bg-white text-black hover:bg-green-600 hover:text-white' }}" 
                        name="month" value="{{ $monthNumber }}" type="submit" {{ $selectedMonth == $monthNumber ? 'disabled' : '' }}>
                        {{ $monthName }}
                    </button>
                @endforeach
                <button type="submit" class="btn">Filter</button> <!-- Optional filter button -->
            </form>

            <table id="table-buku-besar">
                <thead>
                    <tr>
                        <th>No.</th>
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
                            <td>{{ $customer->debit }}</td>
                            <td>{{ $customer->kredit }}</td>
                            <td>{{ $customer->debit - $customer->kredit }}</td>
                            <td>#</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-keuangan.card-keuangan>

    <script>
        $(document).ready(function () {
            $('.js-example-basic-single').select2();

            // Add change event listeners
            $('#coa-select, #year-select').on('change', function() {
                $('#filter-form').submit(); // Submit the form automatically
            });

            var table = $('#table-buku-besar').DataTable({
                data: {!! json_encode($customers) !!},
                columns: [
                    { data: null, render: function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; }},
                    { data: 'nama' },
                    { data: 'debit' },
                    { data: 'kredit' },
                    { data: null, render: function (data, type, row) { return row.debit - row.kredit; }},
                    { data: null, defaultContent: '' }
                ]
            });
        });
    </script>
</x-Layout.layout>
