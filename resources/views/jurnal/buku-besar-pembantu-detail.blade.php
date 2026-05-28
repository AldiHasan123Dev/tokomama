<x-Layout.layout>
    <style>
        /* Container tabel */
        .table-responsive {
            font-size: 12px;
        }

        /* Tabel utama */
        #table-ncs {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        /* Header tabel */
        #table-ncs thead th {
            background: #f3f4f6;
            font-weight: 600;
            padding: 4px 6px;
            text-align: center;
            border: 1px solid black;
            font-size: 11px;
        }

        /* Body tabel */
        #table-ncs tbody td {
            padding: 3px 6px;
            border: 1px solid black;
            font-size: 11px;
        }

        /* Footer */
        #table-ncs tfoot th {
            padding: 4px 6px;
            font-size: 11px;
            font-weight: bold;
            background: #f9fafb;
        }

        /* Kurangi lebar minimum */
        th,
        td {
            min-width: 80px;
        }

        /* Kolom nomor lebih kecil */
        th:first-child,
        td:first-child {
            min-width: 40px;
            width: 40px;
        }

        /* Alignment */
        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Hover efek */
        #table-ncs tbody tr:hover {
            background: #f8fafc;
        }
    </style>
    <x-keuangan.card-keuangan>
        <x-slot:tittle>Buku Besar Pembantu</x-slot:tittle>
        <div class="overflow-x-auto">
            <form method="GET" action="{{ route('buku-besar-pembantu.detail') }}" id="filter-form">
                <div class="flex justify-between w-full">
                    <div>
                        <label class="form-control w-full max-w-xs">
                            <div class="label">
                                <span class="label-text">Akun</span>
                            </div>
                            <select class="js-example-basic-single" name="coa_id" id="coa-select">
                                @foreach ($coa as $c)
                                    <option value="{{ $c->id }}"
                                        {{ $selectedCoaId == $c->id ? 'selected' : '' }}>{{ $c->no_akun }} -
                                        {{ $c->nama_akun }}</option>
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
                                @for ($year = 2030; $year >= 2023; $year--)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                        {{ $year }}</option>
                                @endfor
                            </select>
                        </label>
                    </div>
                </div>
                <label for="tahun" class="mr-2 margin-top:40px">Bulan:</label>
                @foreach (['Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4, 'Mei' => 5, 'Jun' => 6, 'Jul' => 7, 'Aug' => 8, 'Sep' => 9, 'Okt' => 10, 'Nov' => 11, 'Des' => 12] as $monthName => $monthNumber)
                    <button
                        class="btn my-5 py-4 font-bold border-black {{ $selectedMonth == $monthNumber ? 'bg-green-600 text-white' : 'bg-white text-black hover:bg-green-600 hover:text-white' }}"
                        name="month" value="{{ $monthNumber }}" type="submit"
                        {{ $selectedMonth == $monthNumber ? 'disabled' : '' }}>
                        {{ $monthName }}
                    </button>
                @endforeach
            </form>
            <!-- Tabel Customer -->


            <!-- Tabel NCS (Non-Customer/Supplier) -->
            <div id="ncs-table">
                <div class="table-responsive" style="overflow-x: auto; border: 1px solid black;">
                    <table id="table-ncs"style="border: 1px solid black;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid black; width: 30px;" class="text-center">No.</th>
                                <th style="border: 1px solid black;" class="text-center">Tanggal (D) </th>
                                <th style="border: 1px solid black;" class="text-center">Nomor (D) </th>
                                <th style="border: 1px solid black;" class="text-center">Tanggal (K) </th>
                                <th style="border: 1px solid black;" class="text-center">Nomor (K) </th>
                                <th style="border: 1px solid black;" class="text-center">Invoice</th>
                                <th style="border: 1px solid black;" class="text-center">Debit</th>
                                <th style="border: 1px solid black;" class="text-center">Kredit</th>
                                <th style="border: 1px solid black;" class="text-center">Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $saldo = 0;
                            @endphp

                            @foreach ($details as $d)
                                @php
                                    $saldo += $d['debit'] - $d['kredit'];
                                @endphp

                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>

                                    <td class="text-center">
                                        {{ $d['tgl_debit'] ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $d['nomor_debit'] ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $d['tgl_kredit'] ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $d['nomor_kredit'] ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $d['invoice'] }}
                                    </td>

                                    <td class="text-right">
                                        {{ number_format($d['debit'], 0, ',', '.') }}
                                    </td>

                                    <td class="text-right">
                                        {{ number_format($d['kredit'], 0, ',', '.') }}
                                    </td>

                                    <td class="text-right">
                                        {{ number_format($saldo, 0, ',', '.') }}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" style="border: 1px solid black;" class="text-center">Total</th>
                                <th style="border: 1px solid black;" class="text-right"></th>
                                <th style="border: 1px solid black;" class="text-right"></th>
                                <th style="border: 1px solid black;" class="text-right">
                                </th>
                                <th style="border: 1px solid black;" colspan="3"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </x-keuangan.card-keuangan>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();

            // Periksa nilai awal dan tampilkan tabel yang sesuai

            // Tampilkan tabel yang sesuai berdasarkan pilihan subjek

            $('#coa-select, #year-select').on('change', function() {
                $('#filter-form').submit();
            });

            // Initialize DataTable for all tables
            // Destroy DataTable sebelumnya, kemudian inisialisasi ulang
            if ($.fn.dataTable.isDataTable('#table-customer')) {
                $('#table-customer').DataTable().destroy();
            }

            $('#table-customer').DataTable({
                ordering: false,
                columnDefs: [{
                    targets: 0,
                    orderable: false
                }]
            });
            // Destroy DataTable sebelumnya, kemudian inisialisasi ulang
            if ($.fn.dataTable.isDataTable('#table-supplier')) {
                $('#table-supplier').DataTable().destroy();
            }

            $('#table-supplier').DataTable({
                ordering: false,
                columnDefs: [{
                    targets: 0,
                    orderable: false
                }]
            });
            $('#table-ncs').DataTable(); // Inisialisasi DataTable untuk tabel NCS
        });


        function number_format(number, decimals = 0, dec_point = ',', thousands_sep = '.') {
            number = parseFloat(number).toFixed(decimals);

            let nstr = number.split('.');
            let x1 = nstr[0];
            let x2 = nstr.length > 1 ? dec_point + nstr[1] : '';
            let rgx = /(\d+)(\d{3})/;

            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');
            }

            return x1 + x2;
        }
    </script>
</x-Layout.layout>
