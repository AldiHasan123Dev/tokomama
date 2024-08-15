<x-Layout.layout>
    <style>
        #param {
            border: 1px solid black;
            border-collapse: collapse;
        }

        #param th{
            border: 1px solid black;
            border-collapse: collapse;
        }

        #param td{
            border: 1px solid black;
            border-collapse: collapse;
        }

        #maintable td {
            padding: 10px;
        }

        #maintable th {
            padding: 10px;
        }
    </style>

    <x-keuangan.card-keuangan>
        <x-slot:tittle>Form Jurnal Manual</x-slot:tittle>
        <div class="overflow-x-auto">
            <form action="{{ route('jurnal-manual.store') }}" method="post" id="form-jurnal">
                @csrf
                <input type="hidden" name="total_debit" id="total_debit">
                <input type="hidden" name="total_credit" id="total_credit">
                <input type="hidden" name="counter" id="counter">
                <table id="param" class="mb-10">
                    <thead>
                        <th>Customer [1]</th>
                        <th>Supplier [2]</th>
                        <th>Barang [3]</th>
                        <th>Quantity [4]</th>
                        <th>Satuan [5]</th>
                        <th>Harsat Beli [6]</th>
                        <th>Harsat Jual [7]</th>
                        <th>Keterangan [8]</th>
                    </thead>
                    <tbody id="tableParam">
                        <tr id="table-row-top">
                            <td>
                                <input type="text" name="param1[0]" id="param1-1i" class="w-full py-0">
                            </td>
                            <td>
                                <input type="text" name="param2[0]" id="param2-1i" class="w-full py-0">
                            </td>
                            <td>
                                <input type="text" name="param3[0]" id="param3-1i" class="w-full py-0">
                            </td>
                            <td>
                                <input type="text" name="param4[0]" id="param4-1i" class="w-full py-0">
                            </td>
                            <td>
                                <input type="text" name="param5[0]" id="param5-1i" class="w-full py-0">
                            </td>
                            <td>
                                <input type="text" name="param6[0]" id="param6-1i" class="w-full py-0">
                            </td>
                            <td>
                                <input type="text" name="param7[0]" id="param7-1i" class="w-full py-0">
                            </td>
                            <td>
                                <input type="text" name="param8[0]" id="param8-1i" class="w-full py-0">
                            </td>
                        </tr>
                </tbody>
                <div class="grid grid-cols-2 justify-items-start mb-10">
                    <div class="w-full">
                        <label class="form-control w-full max-w-xs mb-5">
                            <div class="label">
                                <span class="label-text">Template Jurnal</span>
                            </div>
                            <select name="template" id="template" class="select select-bordered w-full max-w-xs">
                                <option disabled selected></option>
                                @foreach ($templates as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="self-center w-fit">
                        <button id="terapkan" class="btn bg-green-500 text-white" type="button">Terapkan</button>
                        <button id="reset" class="btn bg-orange-500 text-white" type="button">Reset</button>
                    </div>
                </div>

                <div class="grid grid-cols-3 justify-items-start mb-10">
                    <div class="w-full">
                        <label class="form-control w-full max-w-xs mb-5">
                            <div class="label">
                                <span class="label-text">Tipe Jurnal</span>
                            </div>
                            <select name="tipe" id="tipe" class="select select-bordered w-full max-w-xs" required>
                                <option selected></option>
                                <option value="Jurnal - {{ $no_JNL }}/{{'JNL'}}-SB/{{ date('y') }}">Jurnal - {{ $no_JNL }}/{{'JNL'}}-SB/{{ date('y') }}</option>
                                <option value="Kas Keluar - {{ $no_BKK }}/{{'BKK'}}-SB/{{ date('y') }}">Kas Keluar - {{ $no_BKK }}/{{'BKK'}}-SB/{{ date('y') }}</option>
                                <option value="Kas Masuk - {{ $no_BKM }}/{{'BKM'}}-SB/{{ date('y') }}">Kas Masuk - {{ $no_BKM }}/{{'BKM'}}-SB/{{ date('y') }}</option>
                                <option value="Bank Keluar - {{ $no_BBK }}/{{'BBK'}}-SB/{{ date('y') }}">Bank Keluar - {{ $no_BBK }}/{{'BBK'}}-SB/{{ date('y') }}</option>
                                <option value="Bank Masuk - {{ $no_BBM }}/{{'BBM'}}-SB/{{ date('y') }}">Bank Masuk - {{ $no_BBM }}/{{'BBM'}}-SB/{{ date('y') }}</option>
                            </select>
                        </label>
                    </div>

                    <div class="w-full">
                        <label class="form-control w-full max-w-xs mb-5">
                            <div class="label">
                                <span class="label-text">Tanggal Jurnal</span>
                            </div>
                            <input type="date" class="input input-sm input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white" id="tanggal_jurnal" name="tanggal_jurnal" autocomplete="off" value="{{ date('Y-m-d') }}" />
                        </label>
                    </div>

                    <div class="self-center w-fit">
                        <button type="button" id="addBarisTemplate" class="btn bg-blue-500 text-white">Tambah Baris Template</button>
                        <button id="addRow" type="button" class="btn bg-blue-400 text-white">Tambah Baris</button>
                    </div>
                </div>
                <table class="table" id="maintable">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice</th>
                            <th>Nopol</th>
                            <th>Akun Debet</th>
                            <th>Akun Kredit</th>
                            <th>Keterangan</th>
                            <th>Nominal</th>
                            <th>Invoice External</th>
                            <th>Keterangan Buku Besar Pembantu </th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <tr id="table-row">
                            <td>
                                <input type="hidden" name="check[0]" id="check0h" value="0" checked>
                                <input type="checkbox" name="check[0]" id="check0i" value="1" checked>
                            </td>
                            <td>
                                <input type="hidden" name="invoice[0]" value="">
                                <select class="select select-bordered w-36" name="invoice[0]" id="invoice-1i">
                                    <option value="0" selected></option>
                                    @foreach ($processedInvoices as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="hidden" name="nopol[0]" value="">
                                <select class="select select-bordered w-36" name="nopol[0]" id="nopol-1i">
                                    @foreach ($nopol as $item)
                                        <option disabled selected></option>
                                        <option value="{{ $item->nopol }}">{{ $item->nopol }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="hidden" name="akun_debet[0]" value="">
                                <select class="select select-bordered w-36 calc_debit-1 1debit-0 debit-1" name="akun_debet[0]" id="akun_debet-1i">
                                    <option value="0"></option>
                                    @foreach ($coa as $item)
                                    <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="hidden" name="akun_kredit[0]" value="">
                                <select class="select select-bordered w-36 calc_kredit-1 1credit-0 credit-1" name="akun_kredit[0]" id="akun_kredit-1i">
                                    <option value="0"></option>
                                    @foreach ($coa as $item)
                                    <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" class="input input-sm input-bordered w-32 h-6 bg-transparent rounded-md" name="keterangan[0]" id="keterangan-1i" />
                            </td>
                            <td>
                                <input type="number" onkeyup="total()" class="input input-sm input-bordered w-32 h-6 bg-transparent rounded-md nominal 1nominal-0 nominal-1" min="0" name="nominal[0]" id="nominal-1i" />
                            </td>
                            <td>
                                <input type="hidden" name="invoice_external[0]" value="">
                                <select class="select select-bordered w-36" name="invoice_external[0]" id="invoice_external-1i">
                                    @foreach ($procTransactions as $item)
                                        <option value="0" selected></option>
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                            <input type="hidden" name="keterangan_buku_besar_pembantu[0]" value="">
                            <select name="keterangan_buku_besar_pembantu[0]" id="keterangan_buku_besar_pembantu-1i" class="select select-bordered w-full max-w-xs">
                                <option value=""></option>
                                @foreach($uniqueNomors as $nomor)
                                    <option value="{{ $nomor }}">{{ $nomor }}</option>
                                @endforeach
                            </select>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h3 class="font-bold">TOTAL DEBET : <span id="td"></span></h3>
                <h3 class="font-bold mb-5">TOTAL CREDIT : <span id="tc"></span></h3>

                <button type="button" id="simpan" class="btn bg-green-500 text-white w-5/12 ms-10 mb-5">Simpan Jurnal</button>
            </form>
        </div>
    </x-keuangan.card-keuangan>

    <script>

    let totaltdtc = 0;
    let totaltd = 0;
    let totaltc = 0;
    let dataTemp = [];
    let debitarr = [];
    let kreditarr = [];
    let num = 1;

    $(document).ready(function () {
        $('select.select').select2();
        // $(`#template`).select2();
        // $(`#invoice-1`).select2();
        // $(`#nopol-1`).select2();
        // $(`#akun_debet-1`).select2();
        // $(`#akun_kredit-1`).select2();
        // $(`#invoice_external-1`).select2();
        $(`#nominal-1i`).on('keyup', function() {
            //updateTotalDebit(1);
            //updateTotalKredit(1);
            calcDebitCredit(1);
        });

        $('#check0i').click(function() {
            if ($('#check0i').is(':checked')) {
                $('#invoice-1i').prop('disabled', false);
                $('#nopol-1i').prop('disabled', false);
                $('#akun_debet-1i').prop('disabled', false);
                $('#akun_kredit-1i').prop('disabled', false);
                $('#keterangan-1i').prop('readonly', false);
                $('#nominal-1i').prop('readonly', false);
                $('#invoice_external-1i').prop('disabled', false);
                $('#keterangan_buku_besar_pembantu-1i').prop('disabled', false);
            } else {
                $('#invoice-1i').prop('disabled', true);
                $('#nopol-1i').prop('disabled', true);
                $('#akun_debet-1i').prop('disabled', true);
                $('#akun_kredit-1i').prop('disabled', true);
                $('#keterangan-1i').prop('readonly', true);
                $('#nominal-1i').prop('readonly', true);
                $('#invoice_external-1i').prop('disabled', true);
                $('#keterangan_buku_besar_pembantu-1i').prop('disabled', true);
                $('#nominal-1i').val(0);
                //updateTotalDebit(1);
                //updateTotalKredit(1);
                // calcDebitCredit(1);
            }
        });

        bindInvoiceChange(1 + 'i');
        bindInvoiceExternalChange(1 + 'i');
    });

    $(`#terapkan`).on('click', function() {
        $('#table-row').hide();
        $('#table-row-top').hide();
        addTemplate();
    });

    $(`#addBarisTemplate`).on('click', function() {
        addTemplate();
    });

    $('#reset').click(function (e) {
        location.reload();
    });

    function addTemplate() {
        const dataTemplate = $(`#template`).val();
        $.ajax({
            method: 'post',
            url: "{{ route('jurnal.template.terapan') }}",
            data: { template: dataTemplate, },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                for (let i = 0; i < response.count; i++) {
                    let currentNo = no;
                    num++;

                    let html = '';
                    html += `<tr id="table-row">
                                <td>
                                    <input type="hidden" name="check[${no - 1}]" id="check${no - 1}h" value="0" checked>
                                    <input type="checkbox" name="check[${no - 1}]" id="check${no - 1}" value="1" checked>
                                </td>
                                <td>
                                    <input type="hidden" name="invoice[${no - 1}]" value="">
                                    <select class="select select-bordered w-36" name="invoice[${no - 1}]" id="invoice-${no}">
                                        <option selected></option>
                                        @foreach ($processedInvoices as $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" name="nopol[${no - 1}]" value="">
                                    <select class="select select-bordered w-36" name="nopol[${no - 1}]" id="nopol-${no}">
                                        @foreach ($nopol as $item)
                                        <option selected></option>
                                            <option value="{{ $item->nopol }}">{{ $item->nopol }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" name="akun_debet[${no - 1}]" value="">
                                    <select class="select select-bordered w-36 calc_debit-${no - 1} debit-${num}" onchange="total()" name="akun_debet[${no - 1}]" id="akun_debet-${no}i">
                                        <option id="option_debet-${no - 1}" value="0"></option>
                                        @foreach ($coa as $item)
                                        <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" name="akun_kredit[${no - 1}]" value="">
                                    <select class="select select-bordered w-36 calc_kredit-${no} credit-${num}" onchange="total()" name="akun_kredit[${no - 1}]" id="akun_kredit-${no}i">
                                        <option id="option_kredit-${no - 1}" value="0"></option>
                                        @foreach ($coa as $item)
                                        <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="input input-sm input-bordered w-32 h-6 bg-transparent rounded-md" name="keterangan[${no - 1}]" id="keterangan-${no}" value="${response.keterangan[i] ?? ""}" required />
                                </td>
                                <td>
                                    <input type="number" onkeyup="total()" class="nominal input input-sm input-bordered w-32 h-6 bg-transparent rounded-md nominal-${num}" min="0" name="nominal[${no}]" id="nominal-${no}" required />
                                </td>
                                <td>
                                    <input type="hidden" name="invoice_external[${no - 1}]" value="">
                                    <select class="select select-bordered w-36" name="invoice_external[${no - 1}]" id="invoice_external-${no}">
                                        @foreach ($procTransactions as $item)
                                            <option disabled selected></option>
                                            <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" name="keterangan_buku_besar_pembantu[${no - 1}]" value="">
                                    <select name="keterangan_buku_besar_pembantu[${no - 1}]" id="keterangan_buku_besar_pembantu-${no}" class="select select-bordered w-full max-w-xs">
                                        <option value=""></option>
                                        @foreach($uniqueNomors as $nomor)
                                            <option value="{{ $nomor }}">{{ $nomor }}</option>
                                        @endforeach
                                    </select>
                            </td>

                            </tr>`;

                        // Object.is(response.coa_debit[i], null) ? (response.coa_debit[i] = 0) : (response.coa_debit[i] = response.coa_debit[i]);

                    $('#maintable').append(html);

                    let param = `
                        <tr>
                            <td><input type="text" name="param1[${no - 1}]" id="param1-${no}" class="w-full py-0"></td>
                            <td><input type="text" name="param2[${no - 1}]" id="param2-${no}" class="w-full py-0"></td>
                            <td><input type="text" name="param3[${no - 1}]" id="param3-${no}" class="w-full py-0"></td>
                            <td><input type="text" name="param4[${no - 1}]" id="param4-${no}" class="w-full py-0"></td>
                            <td><input type="text" name="param5[${no - 1}]" id="param5-${no}" class="w-full py-0"></td>
                            <td><input type="text" name="param6[${no - 1}]" id="param6-${no}" class="w-full py-0"></td>
                            <td><input type="text" name="param7[${no - 1}]" id="param7-${no}" class="w-full py-0"></td>
                            <td><input type="text" name="param8[${no - 1}]" id="param8-${no}" class="w-full py-0"></td>
                        </tr>
                        `;

                    $(`#tableParam`).append(param);

                    if (response.coa_debit[i] == null) {
                        $('#option_debet-' + (no - 1)).val(0);
                        $('#option_debet-' + (no - 1)).text(0);
                    } else {
                        $('#option_debet-' + (no - 1)).val(response.coa_debit[i].id);
                        $('#option_debet-' + (no - 1)).text(response.coa_debit[i].no_akun + ' - ' + response.coa_debit[i].nama_akun);
                    }

                    if (response.coa_kredit[i] == null) {
                        $('#option_kredit-' + (no - 1)).val(0);
                        $('#option_kredit-' + (no - 1)).text(0);
                    } else {
                        $('#option_kredit-' + (no - 1)).val(response.coa_kredit[i].id);
                        $('#option_kredit-' + (no - 1)).text(response.coa_kredit[i].no_akun + ' - ' + response.coa_kredit[i].nama_akun);
                    }

                    $(`#check${currentNo - 1}`).click(function() {
                        console.log('clicked' + (currentNo - 1));
                        if ($(`#check${currentNo - 1}`).is(':checked')) {
                            $(`#invoice-${currentNo}`).prop('disabled', false);
                            $(`#nopol-${currentNo}`).prop('disabled', false);
                            $(`#akun_debet-${currentNo}`).prop('disabled', false);
                            $(`#akun_kredit-${currentNo}`).prop('disabled', false);
                            $(`#keterangan-${currentNo}`).prop('readonly', false);
                            $(`#nominal-${currentNo}`).prop('readonly', false);
                            $(`#invoice_external-${currentNo}`).prop('disabled', false);
                            $(`#keterangan_buku_besar_pembantu-${currentNo}`).prop('disabled', false);
                        } else {
                            $(`#invoice-${currentNo}`).prop('disabled', true);
                            $(`#nopol-${currentNo}`).prop('disabled', true);
                            $(`#akun_debet-${currentNo}`).prop('disabled', true);
                            $(`#akun_kredit-${currentNo}`).prop('disabled', true);
                            $(`#keterangan-${currentNo}`).prop('readonly', true);
                            $(`#nominal-${currentNo}`).prop('readonly', true);
                            $(`#invoice_external-${currentNo}`).prop('disabled', true);
                            $(`#keterangan_buku_besar_pembantu-${currentNo}`).prop('disabled', true);
                            $(`#nominal-${currentNo}`).val(0);
                            // updateTotalDebit(no - 1);
                            // updateTotalKredit(no - 1);
                        }
                    });

                    bindInvoiceChange(no);
                    bindInvoiceExternalChange(no);

                    $('select.select').select2();

                    $('#counter').val(no);
                    no++;
                }

                $('#simpan').click(function (e) {
                    var totaltd = $('#total_debit').val();
                    var totaltc = $('#total_credit').val();

                    if(totaltd != totaltc) {
                        alert("Total Debit dan Kredit tidak sama");
                        return
                    } else {
                        if (confirm('are you sure?')) {
                            $('#form-jurnal').submit();
                        }
                    }
                });
            },

            error: function(xhr, status, error) {
                console.log('Error:', error);
                console.log('Status:', status);
                console.dir(xhr);
            }
        });
    }

    var no = 1;
    $(`#counter`).val(no);
    function bindInvoiceChange(rowId) {
        $(`#invoice-${rowId}`).on('change', function() {
            const procdata = $(this).val();
            let datainv = procdata.split('_')[0];
            let no = procdata.split('_')[1] - 1;
            $.ajax({
                method: 'post',
                url: "{{ route('jurnal.sj.whereInv') }}",
                data: { invoice: datainv, },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    console.log(response)
                    $(`#param1-${rowId}`).val(response.customer[no]);
                    $(`#param2-${rowId}`).val(response.supplier[no]);
                    $(`#param3-${rowId}`).val(response.barang[no]);
                    $(`#param4-${rowId}`).val(response.quantity[no]);
                    $(`#param5-${rowId}`).val(response.satuan[no]);
                    $(`#param6-${rowId}`).val(response.harsat_beli[no]);
                    $(`#param7-${rowId}`).val(response.harsat_jual[no]);
                    $(`#param8-${rowId}`).val(response.keterangan[no]);
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                    console.log('Status:', status);
                    console.dir(xhr);
                }
            });
        });
    }

    function bindInvoiceExternalChange(rowId) {
        $(`#invoice_external-${rowId}`).on('change', function() {
            const procdata = $(this).val();
            const datainvext = procdata.split('_')[0];
            const no = procdata.split('_')[1] - 1;
            $.ajax({
                method: 'post',
                url: "{{ route('jurnal.sj.whereInvExt') }}",
                data: { invoice_ext: datainvext, },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    console.log(response);
                    $(`#param1-${rowId}`).val(response.customer[no]);
                    $(`#param2-${rowId}`).val(response.supplier[no]);
                    $(`#param3-${rowId}`).val(response.barang[no]);
                    $(`#param4-${rowId}`).val(response.quantity[no]);
                    $(`#param5-${rowId}`).val(response.satuan[no]);
                    $(`#param6-${rowId}`).val(response.harsat_beli[no]);
                    $(`#param7-${rowId}`).val(response.harsat_jual[no]);
                    $(`#param8-${rowId}`).val(response.keterangan[no]);
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                    console.log('Status:', status);
                    console.dir(xhr);
                }

            })
        });
    }

    function calcDebitCredit(id) {
         totaltd = 0;
         totaltc = 0;
        // $(`input[name="nominal[${id - 1}]"]`).each(function() {
        //     let value = parseInt($(this).val());
        //      console.log(value);
        //     if ($(`.calc_debit-${id}`).val() != "0" && $(`.calc_kredit-${id}`).val() != "0") {
        //         // masukkan ke array debit dan kredit
        //         totaltd += value;
        //         totaltc += value;
        //     } else if($(`.calc_debit-${id}`).val() != "0" && $(`.calc_kredit-${id}`).val() == "0") {
        //         // masukkan ke array debit
        //         totaltd += value;
        //     } else if($(`.calc_debit-${id}`).val() == "0" && $(`.calc_kredit-${id}`).val() != "0") {
        //         // masukkan ke array kredit
        //         totaltc += value;
        //     }
        // });

        // calcUpdate();
    }

    $('select').change(function (e) {
        total();
    });

    $('.nominal').keyup(function (e) {
        total();
    });

    function total(){
        totaltc = 0;
        totaltd = 0;
        for (let i = 1; i <= num; i++) {
            let coa_debit = $(".debit-"+i+"").val();
            let coa_credit = $(".credit-"+i+"").val();
            let nominal = parseFloat($(`.nominal-${i}`).val());

            if(coa_debit != 0) {
                totaltd += nominal;
            }
            if (coa_credit != 0) {
                totaltc += nominal;
            }
        }
        $('#total_debit').val(totaltd);
        $('#total_credit').val(totaltc);
        $('#td').html(totaltd.toLocaleString('en-US'));
        $('#tc').html(totaltc.toLocaleString('en-US'));
    }

    function doTotal(){
        console.log('total running')
        totaltc = 0;
        totaltd = 0;
        console.log("no : " + no);
        for (let i = 0; i < no; i++) {
            let coa_debit = $(".debit-"+i+"").val();
            let coa_credit = $(".credit-"+i+"").val();
            let nominal = parseFloat($(`.nominal-${i}`).val());

            if(coa_debit != 0) {
                totaltd += nominal;
            }
            if (coa_credit != 0) {
                totaltc += nominal;
            }
            console.log("Coa Debit: " + i + ": " + coa_debit);
            console.log("Coa Kredit: " + i + ": " + coa_debit);
            console.log("Nominal: " + i + ": " + coa_debit);
        }
        $('#total_debit').val(totaltd);
        $('#total_credit').val(totaltc);
        $('#td').html(totaltd.toLocaleString('en-US'));
        $('#tc').html(totaltc.toLocaleString('en-US'));
    }

    $('#simpan').click(function (e) {
        var totaltd = $('#total_debit').val();
        var totaltc = $('#total_credit').val();

        if(totaltd != totaltc) {
            alert("Total Debit dan Kredit tidak sama");
            return
        }else{
            if(confirm('are you sure?')){
                $('#form-jurnal').submit();
            }
        }
    });

    function calcUpdate() {
        $(`#td`).text(totaltd);
        $(`#tc`).text(totaltc);
    }


    $('#addRow').on('click', function() {
        no = $(`#counter`).val();
        console.log("no_first: " + no);
        no++;
        num++;
        $(`#counter`).val(no);
        let newRowId = no;

        let html = `
        <tr>
            <td>
                <input type="hidden" name="check[${newRowId - 1}]" id="check${newRowId - 1}h" value="0" checked>
                <input type="checkbox" name="check[${newRowId - 1}]" id="check${newRowId - 1}" value="1" checked>
            </td>
            <td>
                <input type="hidden" name="invoice[${newRowId - 1}]" value="">
                <select class="select select-bordered w-36 max-w-xs" name="invoice[${newRowId - 1}]" id="invoice-${newRowId}">
                    <option selected></option>
                    @foreach ($processedInvoices as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="hidden" name="nopol[${newRowId - 1}]" value="">
                <select class="select select-bordered w-36 max-w-xs" name="nopol[${newRowId - 1}]" id="nopol-${newRowId}">
                    @foreach ($nopol as $item)
                    <option disabled selected></option>
                        <option value="{{ $item->nopol }}">{{ $item->nopol }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="hidden" name="akun_debet[${newRowId - 1}]" value="">
                <select class="select select-bordered w-36 max-w-xs calc_debit-${newRowId - 1} debit-${num}" onchange="total()" name="akun_debet[${newRowId - 1}]" id="akun_debet-${newRowId}i">
                    @foreach ($coa as $item)
                    <option value="0" selected></option>
                    <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="hidden" name="akun_kredit[${newRowId - 1}]" value="">
                <select class="select select-bordered w-36 max-w-xs calc_kredit-${newRowId} credit-${num}" onchange="total()" name="akun_kredit[${newRowId - 1}]" id="akun_kredit-${newRowId}i">
                    @foreach ($coa as $item)
                    <option value="0" selected></option>
                    <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text" class="input input-sm input-bordered w-32 h-6 max-w-xs bg-transparent rounded-md" name="keterangan[${newRowId}]" id="keterangan-${newRowId}" value="" required />
            </td>
            <td>
                <input type="number" onkeyup="total()" class="input nominal input-sm input-bordered w-32 h-6 max-w-xs bg-transparent rounded-md nominal-${num}" min="0" name="nominal[${newRowId - 1}]" id="nominal-${newRowId}" value="" required />
            </td>
            <td>
                <input type="hidden" name="invoice_external[${newRowId - 1}]" value="">
                <select class="select select-bordered w-36 max-w-xs" name="invoice_external[${newRowId - 1}]" id="invoice_external-${newRowId}">
                    @foreach ($procTransactions as $item)
                        <option disabled selected></option>
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="hidden" name="keterangan_buku_besar_pembantu[${newRowId - 1}]" value="">
                <select name="keterangan_buku_besar_pembantu[${newRowId - 1}]" id="keterangan_buku_besar_pembantu-${newRowId}" class="select select-bordered w-full max-w-xs">
                    <option value=""></option>
                    @foreach($uniqueNomors as $nomor)
                        <option value="{{ $nomor }}">{{ $nomor }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        `;
        $(`#tableBody`).append(html);

        let param = `
        <tr>
            <td><input type="text" name="param1[]" id="param1-${newRowId}" class="w-full py-0"></td>
            <td><input type="text" name="param2[]" id="param2-${newRowId}" class="w-full py-0"></td>
            <td><input type="text" name="param3[]" id="param3-${newRowId}" class="w-full py-0"></td>
            <td><input type="text" name="param4[]" id="param4-${newRowId}" class="w-full py-0"></td>
            <td><input type="text" name="param5[]" id="param5-${newRowId}" class="w-full py-0"></td>
            <td><input type="text" name="param6[]" id="param6-${newRowId}" class="w-full py-0"></td>
            <td><input type="text" name="param7[]" id="param7-${newRowId}" class="w-full py-0"></td>
            <td><input type="text" name="param8[]" id="param8-${newRowId}" class="w-full py-0"></td>
        </tr>
        `;
        $(`#tableParam`).append(param);

        // $(`#invoice-${newRowId}`).select2();
        // $(`#nopol-${newRowId}`).select2();
        // $(`#akun_debet-${newRowId}`).select2();
        // $(`#akun_kredit-${newRowId}`).select2();
        // $(`#invoice_external-${newRowId}`).select2();

        $('select.select').select2();

        $(`#check${newRowId - 1}`).click(function() {
            if ($(`#check${newRowId - 1}`).is(':checked')) {
                $(`#invoice-${newRowId}`).prop('disabled', false);
                $(`#nopol-${newRowId}`).prop('disabled', false);
                $(`#akun_debet-${newRowId}`).prop('disabled', false);
                $(`#akun_kredit-${newRowId}`).prop('disabled', false);
                $(`#keterangan-${newRowId}`).prop('readonly', false);
                $(`#nominal-${newRowId}`).prop('readonly', false);
                $(`#invoice_external-${newRowId}`).prop('disabled', false);
                $(`#keterangan_buku_besar_pembantu-${newRowId}`).prop('disabled', false);
            } else {
                $(`#invoice-${newRowId}`).prop('disabled', true);
                $(`#nopol-${newRowId}`).prop('disabled', true);
                $(`#akun_debet-${newRowId}`).prop('disabled', true);
                $(`#akun_kredit-${newRowId}`).prop('disabled', true);
                $(`#keterangan-${newRowId}`).prop('readonly', true);
                $(`#nominal-${newRowId}`).prop('readonly', true);
                $(`#invoice_external-${newRowId}`).prop('disabled', true);
                $(`#keterangan_buku_besar_pembantu-${newRowId}`).prop('disabled', true);
                $(`#nominal-${newRowId}`).val(0);
                //updateTotalDebit(newRowId);
                //updateTotalKredit(newRowId);
                //calcDebitCredit(newRowId);
            }
        });

        $(`#nominal-${newRowId}`).on('keyup', function() {
            // updateTotal()
            //updateTotalDebit(newRowId);
            //updateTotalKredit(newRowId);
            calcDebitCredit(newRowId);
        });
        bindInvoiceChange(newRowId);
        bindInvoiceExternalChange(newRowId);
    });
</script>

</x-Layout.layout>
