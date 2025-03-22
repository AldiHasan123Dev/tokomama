<x-Layout.layout>
    <x-keuangan.card-keuangan>
        <x-slot:tittle>Report Fee Sales</x-slot:tittle>

        <form action="{{ route('laporan.FLS') }}" method="GET">
            <div class="form-container">
                <div class="mb-3 mt-3">
                    <label for="year" class="form-label">Pilih Tahun</label>
                    <div class="input-group">
                        <select name="year" id="year" class="form-select">
                            <option value="" disabled selected>Pilih Tahun</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </div>
        </form>
        
        <style>
            /* Membuat kolom 'Sales' tetap terlihat saat digulir */
th.bg-total-thn, td.bg-thn {
    position: sticky;
    left: 0;
    background-color: #6e791c; /* Warna tetap agar terlihat */
    z-index: 2; /* Pastikan tetap di atas elemen lain */
}

/* Untuk total tahunan tetap terlihat saat digeser */
td.bg-total-thn {
    position: sticky;
    left: 0;
    background-color: #44390f;
    z-index: 2;
}

/* Membuat header "Sales" tetap terlihat */
th.bg-total-thn {
    background-color: #44390f;
    z-index: 3;
}

/* Pastikan tabel memiliki overflow agar bisa digeser */
.table-container {
    overflow-x: auto;
    white-space: nowrap;
}

            table { border-collapse: collapse; width: 100%; margin: 0 auto; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); font-size: 12px; }
            th, td { padding: 8px 10px; border: 1px solid #ddd; transition: background-color 0.3s ease; text-align: right; }
            th { background-color: #294774; color: white; position: sticky; top: 0; z-index: 1; }
            td { background-color: #f9f9f9; }
            tr:hover { background-color: #f1f1f1; }
            
            /* Warna khusus untuk elemen penting */
            .bg-thn { background-color: #6e791c; font-weight: bold; color: white; text-align: center; }
            .bg-total { background-color: #93685b; color: white; font-weight: bold; text-align: center; }
            .bg-total1 { background-color: #474539; color: white; font-weight: bold; text-align: right; border: 2px solid rgb(255, 255, 255);}
            .bg-total-thn { background-color: #44390f; color: white; font-weight: bold; text-align: center; border: 2px solid rgb(255, 255, 255); }
            .bg-total-monthly { background-color: #f7c842; font-weight: bold; text-align: right; border: 2px solid rgb(218, 207, 207);} /* Warna khusus untuk total per bulan */
        </style>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="bg-total-thn" rowspan="2">Sales</th>
                        @foreach ($months as $month)
                            <th colspan="{{ count($satuan) }}" style="text-align: center;">{{ $month }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($months as $month)
                            @foreach ($satuan as $s)
                                <th style="text-align: center;">{{ $s}}</th>
                            @endforeach
                        @endforeach
                    </tr>
                </thead>
                
                <tbody>
                    @foreach ($mergedResults as $customer_sales => $customerData)
                        @php $totalOmzet = 0; @endphp
                        <tr>
                            <td class="bg-thn">{{ $customerData['sales_name'] }}</td>
                            @foreach ($months as $month)
                            @foreach ($satuan as $s)
                                @php
                                    $data = $customerData['years'][request('year') ?? 2025][$month] ?? null;
                                    $omzet = $data['omzet'] ?? 0;
                                    $totalOmzet += $omzet;
                                @endphp
                                <td>{{ number_format($omzet, 0, ',', '.') }}</td>
                            @endforeach
                            @endforeach
                        </tr>
                    @endforeach
                    <tr>
                        <td class="bg-total-thn">{{ request('year') ?? 2025 }}</td>
                        @php $totalYearlyOmzet = 0; @endphp
                        @foreach ($months as $month)
                        @foreach ($satuan as $s)
                            @php
                                $monthlyOmzet = $monthlyTotals[request('year') ?? 2025][$month] ?? 0;
                                $totalYearlyOmzet += $monthlyOmzet;
                            @endphp
                            <td class="bg-total-monthly">{{ number_format($monthlyOmzet, 0, ',', '.') }}</td>
                            @endforeach
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </x-keuangan.card-keuangan>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</x-Layout.layout>
