<x-Layout.layout>
    <x-keuangan.card-keuangan>
        <x-slot:tittle>Buku Besar Pembantu</x-slot:tittle>
        <div class="overflow-x-auto">
            <form method="GET" action="{{ route('buku-besar-pembantu.index') }}" id="filter-form">
                <div class="flex justify-between w-full">
                    <div>
                        <label class="form-control w-full max-w-xs">
                            <div class="label w-full">
                                <span class="label-text">Subjek</span>
                            </div>
                            <select class="js-example-basic-single w-64" name="state" id="subject-select">
                                <option value="customer" {{ request('state', 'customer') == 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="supplier" {{ request('state') == 'supplier' ? 'selected' : '' }}>Supplier</option>
                            </select>
                        </label>
                    </div>
                    <div>
                        <label class="form-control w-full max-w-xs">
                            <div class="label">
                                <span class="label-text">Akun</span>
                            </div>
                            <select class="js-example-basic-single" name="coa_id" id="coa-select">
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
                            <select class="js-example-basic-single w-64" name="year" id="year-select">
                                @for($year = 2030; $year >= 2023; $year--)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </label>
                    </div>
                </div>
                <label for="tahun" class="mr-2 margin-top:40px">Bulan:</label>
                @foreach (['Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4, 'Mei' => 5, 'Jun' => 6, 'Jul' => 7, 'Aug' => 8, 'Sep' => 9, 'Okt' => 10, 'Nov' => 11, 'Des' => 12] as $monthName => $monthNumber)
                    <button class="btn my-5 py-4 font-bold border-black {{ $selectedMonth == $monthNumber ? 'bg-green-600 text-white' : 'bg-white text-black hover:bg-green-600 hover:text-white' }}" name="month" value="{{ $monthNumber }}" type="submit" {{ $selectedMonth == $monthNumber ? 'disabled' : '' }}>
                        {{ $monthName }}
                    </button>
                @endforeach
               
            </form>
            <!-- customer -->
            <div id="customer-table" class="{{ request('state', 'customer') == 'supplier' ? 'hidden' : '' }}">
            <table id="table-customer" class="w-full">
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
                            <td>
                            @if ($tipe=='K')
                                {{ $customer->kredit - $customer->debit }}
                            @else
                                {{ $customer->debit - $customer->kredit }}
                            @endif</td>
                            <td>
                                <button class="bg-blue-400 text-white py-1 px-3 rounded hover:bg-blue-300" onclick="showDetailModal({{ $customer->id }}, {{ $selectedYear }}, {{ $selectedMonth }}, {{ $selectedCoaId }})">Detail</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-center">Total</th>
                        <th>{{ $customers->sum('debit') }}</th>
                        <th>{{ $customers->sum('kredit') }}</th>
                        <th>
                            @if ($tipe=='K')
                                {{ $view_total = $customers->sum('kredit') - $customers->sum('debit') }}
                            @else
                                {{ $view_total = $customers->sum('debit') - $customers->sum('kredit') }}
                            @endif
                        </th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
            </div>
            <!-- Tabel Supplier -->
            <div id="supplier-table" class="{{ request('state', 'customer') == 'customer' ? 'hidden' : '' }}">
                <table id="table-supplier" class="w-full">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Supplier</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                            <th>Saldo</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $key => $supplier)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $supplier->nama }}</td>
                                <td>0</td> <!-- Placeholder untuk Debit -->
                                <td>0</td> <!-- Placeholder untuk Kredit -->
                                <td>0</td> <!-- Placeholder untuk Saldo -->
                                <td></td> <!-- Aksi lainnya -->
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="2" class="text-center">Total</th>
                        <th>0</th>
                        <th>0</th>
                        <th>
                            0
                        </th>
                        <th></th>
                    </tr>
                </tfoot>
                </table>
            </div>
        </div>
    </x-keuangan.card-keuangan>

    <!-- Modal -->
    <div id="detailModal" class="hidden fixed z-10 inset-0 overflow-y-auto h-full  bg-gray-50">
        <div class="flex items-center justify-center min-h-screen border-black">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="modal-header flex justify-between items-center">
                    <h2 class="text-s font-bold" id="modalTitle">Detail Buku Besar Pembantu</h2>
                    <button class=" text-red-500 font-bold text-xl" onclick="closeModal()"> X </button>
                </div>
                <div class="modal-body">
                    <table id="table-detail-buku-besar" class="w-full border-collapse border border-gray-200">
                        <thead>
                            <tr>
                            <th class="border border-gray-300 px-4 py-2">Tanggal</th>
                            <th class="border border-gray-300 px-4 py-2">Invoice</th>
                            <th class="border border-gray-300 px-4 py-2">Debit</th>
                            <th class="border border-gray-300 px-4 py-2">Kredit</th>
                            <th class="border border-gray-300 px-4 py-2">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="modalBody" class=" text-center border border-gray-300 px-4 py-2">
                            <!-- Data will be inserted here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
        $('.js-example-basic-single').select2();

        $('#subject-select').on('change', function() {
            const selectedSubject = $(this).val();
            if (selectedSubject === 'customer') {
                $('#customer-table').removeClass('hidden');
                $('#supplier-table').addClass('hidden');
            } else if (selectedSubject === 'supplier') {
                $('#customer-table').addClass('hidden');
                $('#supplier-table').removeClass('hidden');
            }
        });

        $('#coa-select, #year-select').on('change', function() {
            $('#filter-form').submit();
        });

        // Initialize DataTable for both tables
        $('#table-customer').DataTable();
        $('#table-supplier').DataTable();
    });

        function showDetailModal(customerId, year, month, coaId) {
    $.ajax({
        url: '{{ route("buku-besar-pembantu.showDetail", ["customer" => ":customerId"]) }}'.replace(':customerId', customerId),
        method: 'GET',
        data: {
            year: year,
            month: month,
            coa_id: coaId
        },
        success: function(response) {
            // Periksa apakah data coa tersedia
            if (response.coa) {
                // Populate modal with data
                $('#modalTitle').text('Detail Buku Besar Pembantu: ' + response.customer.nama + '||' + 'Akun: ' + response.coa.no_akun + ' - ' + response.coa.nama_akun);
                $('#modalBody').empty();

                let totalDebit = 0;
                let totalKredit = 0;

                response.details.forEach(detail => {
                    totalDebit += detail.debit;
                    totalKredit += detail.kredit;

                    $('#modalBody').append(
                        `<tr>
                            <td class="border border-gray-300 px-4 py-2">${detail.tgl}</td>
                            <td class="border border-gray-300 px-4 py-2">${detail.invoice}</td>
                            <td class="border border-gray-300 px-4 py-2">${detail.debit}</td>
                            <td class="border border-gray-300 px-4 py-2">${detail.kredit}</td>
                            <td class="border border-gray-300 px-4 py-2 text-start">${detail.keterangan}</td>
                        </tr>`
                    );
                });

                $('#modalBody').append(
                    `<tr>
                        <td colspan="2" class="border border-gray-300 px-4 py-2 font-bold">Total</td>
                        <td class="border border-gray-300 px-4 py-2 font-bold">${totalDebit}</td>
                        <td class="border border-gray-300 px-4 py-2 font-bold">${totalKredit}</td>
                        <td class="border border-gray-300 px-4 py-2 font-bold"> SALDO :{{ $view_total }}</td>
                    </tr>`
                );

                $('#detailModal').removeClass('hidden');
            } else {
                console.error('Data COA tidak ditemukan dalam respons.');
            }
        }
    });
}

function closeModal() {
    $('#detailModal').addClass('hidden');
}

    </script>
</x-Layout.layout>
