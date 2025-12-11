<x-Layout.layout>
    <style>
        .btn-coklat {
            background-color: #6B4F1F;
            color: white;
            font-weight: bold;
            padding: 10px 8px;
            border-radius: 8px;
            border: 2px solid #6B4F1F;
            transition: 0.3s ease;
        }

        .btn-coklat:hover {
            background-color: #8B5A2B;
            transform: scale(1.05);
        }

        #loading-overlay {
            backdrop-filter: blur(2px);
        }

        .btn-hijau {
            background-color: #1f6b49;
            color: white;
            font-weight: bold;
            padding: 10px 8px;
            border-radius: 8px;
            border: 2px solid #1f6b49;
            transition: 0.3s ease;
        }

        .btn-hijau:hover {
            background-color: #2c9365;
            transform: scale(1.05);
        }

        .btn-pair {
            background-color: #3b82f6;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: 0.2s;
        }

        .btn-pair:hover {
            background-color: #1d4ed8;
        }

        .select2-container .select2-selection--single {
            height: 38px !important;
            border-radius: 8px !important;
            display: flex;
            align-items: center;
        }

        .select2-selection__rendered {
            line-height: 38px !important;
            padding-left: 12px !important;
        }

        .select2-selection__arrow {
            height: 38px !important;
            top: 0;
            right: 8px;
        }

        #loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(3px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s ease;
        }

        #loading-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        /* SPINNER GLOW */
        .spinner {
            width: 70px;
            height: 70px;
            border: 6px solid rgba(255, 255, 255, 0.35);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite, glow 1.2s ease-in-out infinite alternate;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes glow {
            0% {
                box-shadow: 0 0 6px white;
            }

            100% {
                box-shadow: 0 0 16px white;
            }
        }

        /* TEKS LOADING */
        .loading-text {
            margin-top: 18px;
            color: white;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            animation: fadeText 1s infinite alternate;
        }

        @keyframes fadeText {
            0% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }

        #result-table .overflow-auto {
            scrollbar-width: thin;
            scrollbar-color: #ccc #f5f5f5;
        }
    </style>

    <x-keuangan.card-keuangan>
        <x-slot:tittle>Jurnal Balik</x-slot:tittle>

        <div class="container">

            {{-- FILTER RANGE TANGGAL --}}
            <div class="flex flex-row flex-wrap mb-10 mt-6 items-center gap-8">
                <div class="flex flex-col w-72">
                    <label class="font-bold">Tanggal Awal:</label>
                    <input type="date" id="tanggal-awal" class="border rounded-lg px-3 py-2">
                </div>

                <div class="flex flex-col w-72">
                    <label class="font-bold">Tanggal Akhir:</label>
                    <input type="date" id="tanggal-akhir" class="border rounded-lg px-3 py-2">
                </div>

                {{-- Kode Jurnal --}}
                <div class="flex flex-col w-72">
                    <label class="font-bold">Kode Jurnal:</label>
                    <select id="filter-code" class="border rounded-lg px-3 py-2">
                        <option value=""></option>
                        @foreach ($journals as $j)
                            <option value="{{ $j->kode }}">{{ $j->kode }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- FILTER COA --}}
            <div class="flex flex-row flex-wrap mb-10 mt-4 items-start gap-6">

                <div class="flex flex-col w-[280px]">
                    <label class="font-bold">COA Debit Awal:</label>
                    <select id="filter-coa-1" class="border rounded-lg w-[280px]">
                        <option value=""></option>
                        @foreach ($coa as $c)
                            <option value="{{ $c->id }}">{{ $c->no_akun }} - {{ $c->nama_akun }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col w-[280px]">
                    <label class="font-bold">COA Kredit Awal:</label>
                    <select id="filter-coa-2" class="border rounded-lg w-[280px]">
                        <option value=""></option>
                        @foreach ($coa as $c)
                            <option value="{{ $c->id }}">{{ $c->no_akun }} - {{ $c->nama_akun }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col w-[280px]">
                    <label class="font-bold">COA Debit Tujuan:</label>
                    <select id="filter-coa-4" class="border rounded-lg w-[280px]">
                        <option value=""></option>
                        @foreach ($coa as $c)
                            <option value="{{ $c->id }}">{{ $c->no_akun }} - {{ $c->nama_akun }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col w-[280px]">
                    <label class="font-bold">COA Kredit Tujuan:</label>
                    <select id="filter-coa-3" class="border rounded-lg w-[280px]">
                        <option value=""></option>
                        @foreach ($coa as $c)
                            <option value="{{ $c->id }}">{{ $c->no_akun }} - {{ $c->nama_akun }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- BUTTON PAIRING --}}
                <div class="flex flex-col gap-3 mt-5">
                    <button id="cari-jurnal" class="btn-pair">Cari Jurnal</button>
                </div>

            </div>

            <div id="result-table" class="hidden mt-4 p-5 bg-white border rounded-xl shadow-lg">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-xl font-bold">Hasil Pencarian Jurnal</h2>
                </div>

                <div id="summary-hasil" class="hidden mb-3 p-3 border rounded-lg bg-gray-50 flex gap-10 font-semibold">
                    <div>Total Record: <span id="sum-record-hasil">0</span></div>
                    <div>Total Debit: <span id="sum-debit-hasil">0</span></div>
                    <div>Total Kredit: <span id="sum-kredit-hasil">0</span></div>
                </div>

                <div class="overflow-auto max-h-[400px] border rounded-lg">
                    <table id="tabel-hasil" class="min-w-max w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border px-3 py-2">#</th>
                                <th class="border px-3 py-2">ID</th>
                                <th class="border px-3 py-2">Nomor Jurnal</th>
                                <th class="border px-3 py-2">Tanggal</th>
                                <th class="border px-3 py-2">COA</th>
                                <th class="border px-3 py-2">Debit</th>
                                <th class="border px-3 py-2">Kredit</th>
                                <th class="border px-3 py-2">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <div class="flex items-end justify-end mt-3 mb-3 ml-2 mr-2">
                        <button id="btn-simpan-penampungan" class="btn-hijau">Simpan Ke Penampungan</button>
                    </div>
                </div>
            </div>


            <div id="result-table-penampungan" class="hidden mt-4 p-5 bg-white border rounded-xl shadow-lg">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h2 class="text-xl font-bold">Pre-View Jurnal Balik</h2>
                    </div>
                </div>


                <div id="summary-penampungan"
                    class="hidden mb-3 p-3 border rounded-lg bg-gray-50 flex gap-10 font-semibold">
                    <div>Total Record: <span id="sum-record-penampungan">0</span></div>
                </div>

                <div class="overflow-auto max-h-[400px] border rounded-lg">
                    <table id="tabel-penampungan" class="min-w-max w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border px-3 py-2">#</th>
                                <th class="border px-3 py-2">ID</th>
                                <th class="border px-3 py-2">Nomor Jurnal</th>
                                <th class="border px-3 py-2">Tanggal</th>
                                <th class="border px-3 py-2">COA</th>
                                <th class="border px-3 py-2">Debit</th>
                                <th class="border px-3 py-2">Kredit</th>
                                <th class="border px-3 py-2">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <div class="flex items-center justify-between mt-3 mb-3 ml-2 mr-2">
                        <input type="text" class="mt-2 border rounded px-3 py-1 bg-gray-100"
                            value="{{ $nomor }}" disabled>

                        <!-- INPUT HIDDEN UNTUK KIRIM NILAI ASLI -->
                        <input type="hidden" id ="no" name="no" value="{{ $no }}">
                        <input type="hidden" id ="nomor" name="nomor" value="{{ $nomor }}">
                        <button id="btn-simpan-jurnal-balik" class="btn-hijau">Proses Jurnal Balik</button>
                    </div>
                </div>
            </div>



        </div>
        <!-- LOADING OVERLAY -->
        <div id="loading-overlay">
            <div class="spinner"></div>
            <div class="loading-text">Loading...</div>
        </div>

    </x-keuangan.card-keuangan>

    {{-- Select2 --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            // INIT SELECT2
            $('#filter-coa-1, #filter-coa-2, #filter-coa-3, #filter-coa-4').select2({
                placeholder: "Pilih COA",
                allowClear: true,
                width: 'resolve'
            });
            $('#filter-code').select2({
                placeholder: "Pilih Kode Jurnal",
                allowClear: true,
                width: 'resolve'
            });

            // PAIRING 1 -> 3
            $('#filter-coa-1').on('change', function() {
                const val = $(this).val();
                if (val !== "") {
                    $('#filter-coa-3').val(val).trigger('change');
                    $('#filter-coa-4').prop('disabled', true);
                } else {
                    $('#filter-coa-4').prop('disabled', false);
                    $('#filter-coa-3').val("").trigger('change');
                }
            });

            // PAIRING 2 -> 4
            $('#filter-coa-2').on('change', function() {
                const val = $(this).val();
                if (val !== "") {
                    $('#filter-coa-4').val(val).trigger('change');
                    $('#filter-coa-1').prop('disabled', true);
                } else {
                    $('#filter-coa-1').prop('disabled', false);
                    $('#filter-coa-4').val("").trigger('change');
                }
            });



            // ======================================================
            //                  CARI JURNAL
            // ======================================================
            $('#cari-jurnal').on('click', function() {

                $("#loading-overlay").addClass("active");

                let data = {
                    tanggal_awal: $('#tanggal-awal').val(),
                    tanggal_akhir: $('#tanggal-akhir').val(),
                    kode: $('#filter-code').val(),
                    coa1: $('#filter-coa-1').val(),
                    coa2: $('#filter-coa-2').val(),
                    coa3: $('#filter-coa-3').val(),
                    coa4: $('#filter-coa-4').val()
                };

                $.ajax({
                    url: "{{ route('jurnal-balik.cari') }}",
                    type: "GET",
                    data: data,

                    success: function(res) {

                        let tbody = $("#tabel-hasil tbody");
                        tbody.empty();

                        // Reset Penampungan
                        $("#tabel-penampungan tbody").empty();

                        // TAMPILKAN SUMMARY
                        $("#summary-hasil").removeClass("hidden");
                        $("#sum-debit-hasil").text(res.sum_debit.toLocaleString());
                        $("#sum-kredit-hasil").text(res.sum_kredit.toLocaleString());
                        $("#sum-record-hasil").text(res.total_record);

                        $("#tabel-penampungan tbody").empty();

                        // Reset Summary Penampungan
                        $("#summary-penampungan").addClass("hidden");
                        $("#sum-record-penampungan").text(0);
                        $("#sum-debit-penampungan").text(0);
                        $("#sum-kredit-penampungan").text(0);

                        // Jika tidak ada data
                        if (res.data.length === 0) {
                            tbody.append(`
                        <tr><td colspan="8" class="text-center py-3">Tidak ada data</td></tr>
                    `);
                        } else {
                            res.data.forEach(r => {
                                tbody.append(`
                            <tr>
                                <td class="border px-3 py-2 text-center">
                                    <input type="checkbox" class="pilih-jurnal" value="${r.id}" checked>
                                </td>
                                <td class="border px-3 py-2">${r.id}</td>
                                <td class="border px-3 py-2">${r.nomor}</td>
                                <td class="border px-3 py-2">${r.tgl}</td>
                                <td class="border px-3 py-2">${r.akun}</td>
                                <td class="border px-3 py-2 text-right">${r.debit}</td>
                                <td class="border px-3 py-2 text-right">${r.kredit}</td>
                                <td class="border px-3 py-2">${r.keterangan}</td>
                            </tr>
                        `);
                            });
                        }

                        $("#result-table").removeClass("hidden");
                        $("#result-table-penampungan").removeClass("hidden");
                    },

                    error: function() {
                        alert('Terjadi kesalahan pada server');
                    },

                    complete: function() {
                        setTimeout(() => {
                            $("#loading-overlay").removeClass("active");
                        }, 200);
                    }
                });

            });




            // ======================================================
            //       UPDATE SUMMARY (SISA DATA DI TABEL HASIL)
            // ======================================================
            function updateSummaryHasil() {

                let totalRecord = 0;
                let totalDebit = 0;
                let totalKredit = 0;

                $("#tabel-hasil tbody tr").each(function() {

                    let debit = parseFloat($(this).find("td:eq(6)").text().replace(/[,.]/g, "")) || 0;
                    let kredit = parseFloat($(this).find("td:eq(5)").text().replace(/[,.]/g, "")) || 0;

                    totalRecord++;
                    totalDebit += debit;
                    totalKredit += kredit;
                });

                $("#sum-record-hasil").text(totalRecord);
            }



            // ======================================================
            //       UPDATE SUMMARY PENAMPUNGAN
            // ======================================================
            function updateSummaryPenampungan() {

                let totalRecord = 0;
                let totalDebit = 0;
                let totalKredit = 0;

                $("#tabel-penampungan tbody tr").each(function() {

                    let debit = parseFloat($(this).find("td:eq(5)").text().replace(/[,.]/g, "")) || 0;
                    let kredit = parseFloat($(this).find("td:eq(6)").text().replace(/[,.]/g, "")) || 0;

                    totalRecord++;
                    totalDebit += debit;
                    totalKredit += kredit;
                });

                $("#summary-penampungan").removeClass("hidden");
                $("#sum-record-penampungan").text(totalRecord);
            }




            // ======================================================
            //        BUTTON SIMPAN KE PENAMPUNGAN
            // ======================================================
            $(document).on("click", "#btn-simpan-penampungan", function() {

                let checked = $(".pilih-jurnal:checked");

                if (checked.length === 0) {
                    alert("Pilih minimal 1 jurnal!");
                    return;
                }

                let penampunganBody = $("#tabel-penampungan tbody");

                checked.each(function() {

                    let tr = $(this).closest("tr");
                    let clone = tr.clone();

                    // Hapus checkbox
                    clone.find("td:first").html("-");

                    // =============================================
                    //  🔥 BALIKKAN DEBIT & KREDIT
                    // =============================================
                    let debit = clone.find("td:eq(5)").text();
                    let kredit = clone.find("td:eq(6)").text();

                    clone.find("td:eq(5)").text(kredit); // debit jadi kredit
                    clone.find("td:eq(6)").text(debit); // kredit jadi debit

                    // Masukkan clone ke tabel penampungan
                    penampunganBody.append(clone);

                    // Hapus baris asli
                    tr.remove();
                });

                // Hapus empty row lama
                penampunganBody.find("tr.row-kosong").remove();

                // ======================================================
                // Ambil COA Tujuan dari Select Filter
                // ======================================================
                let coa3Val = $("#filter-coa-3").val();
                let coa4Val = $("#filter-coa-4").val();

                let coaText = "";

                if (coa3Val) {
                    coaText = $("#filter-coa-3 option:selected").text();
                } else if (coa4Val) {
                    coaText = $("#filter-coa-4 option:selected").text();
                }

                // ======================================================
                // Hitung ulang debit & kredit penampungan
                // ======================================================
                let totalDebit = 0;
                let totalKredit = 0;

                penampunganBody.find("tr").each(function() {
                    let debit = parseFloat($(this).find("td:eq(5)").text().replace(/[,.]/g, "")) ||
                        0;
                    let kredit = parseFloat($(this).find("td:eq(6)").text().replace(/[,.]/g, "")) ||
                        0;
                    let invoice
                    totalDebit += debit;
                    totalKredit += kredit;
                });

                let fDebit = totalDebit.toLocaleString();
                let fKredit = totalKredit.toLocaleString();

                // ======================================================
                // Baris Kosong dengan debit-kredit DIBALIK
                // ======================================================
                let emptyRow = `
        <tr class="row-kosong bg-gray-100 font-bold">
            <td class="border px-3 py-2">-</td>
            <td class="border px-3 py-2"></td>
            <td class="border px-3 py-2"></td>
            <td class="border px-3 py-2"></td>
            <td class="border px-3 py-2">${coaText}</td>
            <td class="border px-3 py-2 text-right">${fKredit}</td>  <!-- Debit dibalik -->
            <td class="border px-3 py-2 text-right">${fDebit}</td>   <!-- Kredit dibalik -->
            <td class="border px-3 py-2">
                <input type="text" id="keterangan_new" class="form-control w-full px-2 py-1 border rounded"
                    placeholder="Keterangan tambahan">
            </td>
        </tr>
    `;

                penampunganBody.append(emptyRow);

                updateSummaryHasil();
                updateSummaryPenampungan();

                alert("Data berhasil dimasukkan ke Penampungan!");
            });


        });

        // ======================================================
        //        BUTTON PROSES JURNAL BALIK
        // ======================================================
        $(document).on("click", "#btn-simpan-jurnal-balik", function() {

            // TAMPILKAN LOADING
            $("#loading-overlay").addClass("active");

            // Ambil nilai hidden input
            let no = $("#no").val();
            let nomor = $("#nomor").val();
            let awal_debit = $("#filter-coa-1").val();
            let awal_credit = $("#filter-coa-2").val();
            let tujuan_credit = $("#filter-coa-3").val();
            let tujuan_debit = $("#filter-coa-4").val();
            let kode = $("#filter-code").val();
            let new_keterangan = $("#keterangan_new").val() || "";

            if (!no) {
                alert("Terjadi kesalahan dalam mengambil data, silahkan tekan tombol cari jurnal ulang!");
                $("#loading-overlay").removeClass("active");
                return;
            }
            if (!nomor) {
                alert("Terjadi kesalahan dalam mengambil data, silahkan tekan tombol cari jurnal ulang!");
                $("#loading-overlay").removeClass("active");
                return;
            }
            if (!kode) {
                alert("Terjadi kesalahan dalam mengambil data, silahkan tekan tombol cari jurnal ulang!");
                $("#loading-overlay").removeClass("active");
                return;
            }
            if (!awal_debit && !awal_credit) {
                alert("COA awal wajib dipilih (debit atau kredit)!");
                $("#loading-overlay").removeClass("active");
                return;
            }
            if (!tujuan_debit && !tujuan_credit) {
                alert("COA tujuan wajib dipilih (debit atau kredit)!");
                $("#loading-overlay").removeClass("active");
                return;
            }
             if (!new_keterangan) {
                alert("Keterangan wajib diisi pada baris kosong!");
                $("#loading-overlay").removeClass("active");
                return;
            }

            // Kumpulkan semua data di penampungan
            let dataJurnal = [];

            $("#tabel-penampungan tbody tr").each(function() {

                dataJurnal.push({
                    id: $(this).find("td:eq(1)").text().trim(),
                    nomor: $(this).find("td:eq(2)").text().trim(),
                    tanggal: $(this).find("td:eq(3)").text().trim(),
                    coa: $(this).find("td:eq(4)").text().trim(),
                    debit: $(this).find("td:eq(5)").text().replace(/[,.]/g, "").trim(),
                    kredit: $(this).find("td:eq(6)").text().replace(/[,.]/g, "").trim(),
                    keterangan: $(this).find("td:eq(7)").text().trim()
                });

            });

            if (dataJurnal.length === 0) {
                $("#loading-overlay").removeClass("active");
                alert("Tidak ada jurnal di penampungan!");
                return;
            }

            $.ajax({
                url: "{{ route('jurnal-balik.proses') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    no: no,
                    tujuan_debit: tujuan_debit,
                    tujuan_credit: tujuan_credit,
                    awal_debit: awal_debit,
                    awal_credit: awal_credit,
                    nomor: nomor,
                    new_keterengan: new_keterangan,
                    tipe: 'BKK',
                    kode: kode,
                    jurnal: dataJurnal
                },

                success: function(res) {
                    alert("Jurnal balik berhasil diproses!");

                    // Optional: reset tabel penampungan
                    $("#tabel-penampungan tbody").empty();
                    $("#summary-penampungan").addClass("hidden");
                },

                error: function() {
                    alert("Terjadi kesalahan saat memproses jurnal balik!");
                },

                complete: function() {
                    $("#loading-overlay").removeClass("active");
                }
            });

        });
    </script>

</x-Layout.layout>
