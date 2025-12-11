<x-Layout.layout>
    <style>
        /* --- STYLE CUSTOM UI --- */
        .btn-coklat {
            background-color: #6B4F1F;
            color: white;
            font-weight: bold;
            padding: 10px 8px;
            border-radius: 8px;
            border: 2px solid #6B4F1F;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-coklat:hover {
            background-color: #8B5A2B;
            transform: scale(1.05);
        }

        .btn-hijau {
            background-color: #1f6b49;
            color: white;
            font-weight: bold;
            padding: 10px 8px;
            border-radius: 8px;
            border: 2px solid #1f6b49;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-hijau:hover {
            background-color: #2c9365;
            transform: scale(1.05);
        }

        .active {
            background-color: #38a169 !important;
            color: white !important;
        }

        .active1 {
            background-color: #3869a1 !important;
            color: white !important;
        }

        #table-loading {
            display: none;
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            background: rgba(255, 255, 255, 0.8);
            padding: 15px 25px;
            border-radius: 8px;
            font-weight: bold;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
        }

        .ui-jqgrid .loading {
            display: none !important;
            visibility: hidden !important;
        }

        /* Wrapper untuk membatasi ukuran tabel */
        .table-wrapper-fixed {
            width: 100%;
            max-width: 100%;
            height: 500px;
            /* Tinggi tetap */
            overflow: auto;
            /* Scroll di dalam tabel */
            position: relative;
            border: 1px solid #ddd;
        }

        /* Tinggi utama select2 */
        .select2-container .select2-selection--single {
            height: 38px !important;
            border-radius: 8px !important;
            display: flex;
            align-items: center;
        }

        /* Atur teks agar center */
        .select2-selection__rendered {
            line-height: 38px !important;
            padding-left: 12px !important;
        }

        /* Atur posisi panah agar center */
        .select2-selection__arrow {
            height: 38px !important;
            top: 0 !important;
            right: 8px !important;
        }
    </style>

    <x-keuangan.card-keuangan>
        <x-slot:tittle>Generate Jurnal Kode</x-slot:tittle>
        <div class="container">

            {{-- FILTER BULAN --}}
            <div class="flex flex-row mb-10 mt-6">
                <label class="font-bold mt-2 mr-3">Bulan:</label>

                @for ($i = 1; $i <= 12; $i++)
                    @php
                        $monthName = date('M', mktime(0, 0, 0, $i, 1));
                        $isActive = request('month', date('n')) == $i;
                    @endphp

                    <button type="button" data-month="{{ $i }}"
                        class="month-btn px-3 py-2 border-2 border-green-300 rounded-xl mx-1 duration-300
                        {{ $isActive ? 'active' : 'hover:bg-green-300 hover:text-white' }}">
                        {{ $monthName }}
                    </button>
                @endfor

                {{-- FILTER COA --}}
                <div class="flex flex-row items-center ml-6">
                    <label class="font-bold mr-3">COA:</label>

                    <select id="filter-coa" class="border rounded-lg min-w-[290px] w-[300px]">
                        <option value="">-- Semua COA --</option>
                        @foreach (\App\Models\Coa::where('status', 'aktif')->orderBy('no_akun')->get() as $c)
                            <option value="{{ $c->id }}" {{ $c->id == 5 ? 'selected' : '' }}>
                                {{ $c->no_akun }} - {{ $c->nama_akun }}
                            </option>
                        @endforeach
                    </select>
                </div>



                {{-- LIST TAHUN DINAMIS --}}
                <div class="ml-6">
                    <label class="font-bold mr-2">Tahun:</label>
                    <select id="filter-year" class="border px-3 py-2 rounded-lg">
                        @php
                            $currentYear = date('Y');
                            $startYear = $currentYear - 5;
                            $endYear = $currentYear + 3;
                        @endphp

                        @for ($y = $startYear; $y <= $endYear; $y++)
                            <option value="{{ $y }}"
                                {{ $y == request('year', $currentYear) ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>

            {{-- FILTER TIPE --}}
            <div class="flex flex-row mb-10 items-center">

                {{-- Label Tipe --}}
                <label class="font-bold mr-3">Tipe:</label>

                {{-- Tombol Tipe --}}
                @php
                    $defaultType = 'bank';
                    $types = [
                        ['key' => 'JNL', 'label' => 'JNL'],
                        ['key' => 'kas', 'label' => 'Kas'],
                        ['key' => 'bank', 'label' => 'Bank'],
                        ['key' => 'ocbc', 'label' => 'OCBC'],
                    ];
                @endphp

                @foreach ($types as $t)
                    <button type="button" data-type="{{ $t['key'] }}"
                        class="type-btn px-3 py-2 border-2 border-green-300 rounded-xl mx-1 duration-300
            {{ $t['key'] == $defaultType ? 'active' : '' }}">
                        {{ $t['label'] }}
                    </button>
                @endforeach

                {{-- Spacer --}}
                <div class="mx-6"></div>

                {{-- Label Posisi --}}
                <label class="font-bold mr-3">Posisi:</label>

                {{-- Tombol Debit / Kredit --}}
                <button type="button" data-value="debit"
                    class="pos-btn px-3 py-2 border-2 border-blue-300 rounded-xl mx-1 duration-300 debit-btn active1">
                    Debit
                </button>

                <button type="button" data-value="kredit"
                    class="pos-btn px-3 py-2 border-2 border-blue-300 rounded-xl mx-1 duration-300 credit-btn">
                    Kredit
                </button>

            </div>




            {{-- BUTTON EDIT --}}
            <div class="mb-8 flex gap-3">
                <button class="btn-coklat" onclick="searchJurnal1()" type="button">Cari Jurnal</button>
                <button class="btn-hijau" type="button" id="simpan-kode">Simpan Kode</button>
            </div>

            {{-- TABLE --}}
            <div class="table-wrapper-fixed">
                <div id="table-loading">Sedang Memuat Data...</div>

                <table id="jqGrid1"></table>
                <div id="jqGridPager1"></div>
            </div>



        </div>
    </x-keuangan.card-keuangan>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/free-jqgrid@4.15.5/css/ui.jqgrid.min.css">
    <script src="https://cdn.jsdelivr.net/npm/free-jqgrid@4.15.5/js/jquery.jqgrid.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#filter-coa').select2({
                placeholder: "Pilih COA",
                allowClear: true,
                width: 'resolve'
            });
            $("#jqGrid1").jqGrid({
                url: "{{ route('jurnal.kode.list') }}",
                mtype: 'GET',
                datatype: 'json',

                postData: function() {
                    return {
                        kategori: "real",
                        month_is: selectedMonth,
                        year_is: $('#filter-year').val(),
                        tipe: selectedType
                    };
                },

                colModel: [{
                        name: 'kode',
                        label: 'Kode',
                        width: 120,
                        formatter: (cell, opts, row) => {
                            let kode = row.kode ?? "";
                            return `<input type="text" value="${kode}" class="form-control form-control-sm kode-input" data-id="${row.id}" />`;
                        },
                        sortable: false,
                        align: 'center'
                    },
                    {
                        name: 'tgl',
                        label: 'Tanggal',
                        width: 110
                    },
                    {
                        name: 'nomor',
                        label: 'Nomor Jurnal',
                        width: 100
                    },
                    {
                        name: 'invoice_external',
                        label: 'Invoice External',
                        width: 150
                    },
                    {
                        name: 'invoice',
                        label: 'Invoice',
                        width: 150
                    },
                    {
                        name: 'keterangan',
                        label: 'Keterangan',
                        width: 450
                    },
                    {
                        name: 'debit',
                        label: 'Debit',
                        width: 120,
                        align: 'right',
                        formatter: function(value) {
                            return value ? new Intl.NumberFormat('id-ID').format(value) : "0";
                        }
                    },
                    {
                        name: 'kredit',
                        label: 'Credit',
                        width: 120,
                        align: 'right',
                        formatter: function(value) {
                            return value ? new Intl.NumberFormat('id-ID').format(value) : "0";
                        }
                    }
                ],

                autowidth: false,
                shrinkToFit: false,
                height: 400,
                width: 1300, // <- silakan ubah sesuai layout
                loadonce: false,
                rowNum: 1000,
                viewrecords: true,
                pager: "#jqGridPager1",
                caption: "Jurnal List",

                beforeRequest: function() {
                    $("#table-loading").show();
                },

                loadComplete: function() {
                    $("#table-loading").hide();
                }
            });

            $('#jqGrid1').jqGrid('navGrid', "#jqGridPager1", {
                search: false,
                add: false,
                edit: false,
                del: false,
                refresh: true
            });
        });


        $('#simpan-kode').on('click', function(e) {
            e.preventDefault();

            let dataToSend = [];

            $('.kode-input').each(function() {
                const kode = $(this).val();
                const id = $(this).data('id');

                dataToSend.push({
                    id,
                    kode: kode.trim() === '' ? null : kode.trim()
                });
            });

            console.log("DATA YANG AKAN DIKIRIM:", dataToSend);

            if (dataToSend.length === 0) {
                alert('Tidak ada data untuk disimpan.');
                return;
            }

            $.ajax({
                url: '{{ route('jurnal.simpanKode') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    data: dataToSend
                },
                beforeSend: function() {
                    console.log("MENGIRIM DATA KE SERVER...");
                },
                success: function(res) {
                    console.log("RESPON BERHASIL:", res);
                    alert('Kode berhasil disimpan!');
                    $("#jqGrid1").trigger('reloadGrid');
                },
                error: function(xhr) {
                    console.log("RESPON ERROR:");
                    console.log("Status:", xhr.status);
                    console.log("Response:", xhr.responseText);
                    alert('Terjadi kesalahan saat menyimpan.');
                }
            });

        });



        let selectedMonth = null;

        $('.month-btn').on('click', function() {
            $('.month-btn').removeClass('active');
            $(this).addClass('active');
            selectedMonth = $(this).data('month');
        });

        let selectedDebit = "";
        let selectedCredit = "";


        $('.debit-btn').on('click', function() {

            $('.credit-btn').removeClass('active1');


            $('.debit-btn').removeClass('active1');
            $(this).addClass('active1');

            selectedDebit = $(this).data('value');
            selectedCredit = "";
        });


        $('.credit-btn').on('click', function() {

            $('.debit-btn').removeClass('active1');


            $('.credit-btn').removeClass('active1');
            $(this).addClass('active1');


            selectedCredit = $(this).data('value');
            selectedDebit = "";
        });


        let selectedType = "";

        $('.type-btn').on('click', function() {
            $('.type-btn').removeClass('active');
            $(this).addClass('active');
            selectedType = $(this).data('type');
        });

        function searchJurnal1() {
            $("#custom-loading").fadeIn(150);

            $("#jqGrid1").jqGrid('setGridParam', {
                postData: {
                    debit_is: selectedDebit,
                    kredit_is: selectedCredit,
                    month_is: selectedMonth,
                    year_is: $('#filter-year').val(),
                    tipe: selectedType,
                    coa_id: $('#filter-coa').val()
                },
                page: 1
            }).trigger('reloadGrid');
        }
    </script>

</x-Layout.layout>
