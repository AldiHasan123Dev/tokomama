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
            <form action="{{ route('jurnal.store') }}" method="post">
                @csrf
                <input type="hidden" name="counter" id="counter">
                <table id="param" class="mb-10">
                    <thead>
                        <th>Customer [1]</th>
                        <th>Supplier [2]</th>
                        <th>Barang [3]</th>
                    </thead>
                    <tbody id="tableParam">
                        <tr>
                            <td>
                                <input type="text" name="param1[]" id="param1-1" class="w-full py-0">
                            </td>
                            <td>
                                <input type="text" name="param2[]" id="param2-1" class="w-full py-0">
                            </td>
                            <td>
                                <input type="text" name="param3[]" id="param3-1" class="w-full py-0">
                            </td>
                        </tr>
                </tbody>
                <div class="grid grid-cols-2 justify-items-start mb-10">
                    <div class="w-full">
                        <label class="form-control w-full max-w-xs mb-5">
                            <div class="label">
                                <span class="label-text">Template Jurnal</span>
                            </div>
                            <select name="tipe" id="tipe" class="select select-bordered w-full max-w-xs">
                                <option disabled selected></option>
                                @foreach ($templates as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="self-center w-fit">
                        <button class="btn bg-green-500 text-white">Terapkan</button>
                        <button class="btn bg-orange-500 text-white">Reset</button>
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
                        <button type="submit" class="btn bg-blue-500 text-white">Tambah Baris Template</button>
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
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <tr>
                            <td>
                                <input type="hidden" name="check[0]" id="check0h" value="0" checked>
                                <input type="checkbox" name="check[0]" id="check0" value="1" checked>
                            </td>
                            <td>
                                <select class="select select-bordered w-36" name="invoice[]" id="invoice-1">
                                    <option selected></option>
                                    @foreach ($invoice as $item)
                                        <option value="{{ $item->invoice }}">{{ $item->invoice }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="select select-bordered w-36" name="nopol[]" id="nopol-1">
                                    @foreach ($nopol as $item)
                                    <option disabled selected></option>
                                        <option value="{{ $item->nopol }}">{{ $item->nopol }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="select select-bordered w-36" name="akun_debet[]" id="akun_debet-1" required>
                                    @foreach ($coa as $item)
                                    <option value="0" selected></option>
                                    <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="select select-bordered w-36" name="akun_kredit[]" id="akun_kredit-1" required>
                                    @foreach ($coa as $item)
                                    <option value="0" selected></option>
                                    <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" class="input input-sm input-bordered w-32 h-6 bg-transparent rounded-md" name="keterangan[]" id="keterangan-1" required />
                            </td>
                            <td>
                                <input type="number" class="input input-sm input-bordered w-32 h-6 bg-transparent rounded-md" min="0" name="nominal[]" id="nominal-1" required />
                            </td>
                            <td>
                                <select class="select select-bordered w-36" name="invoice_external[]" id="invoice_external-1">
                                    @foreach ($transaksi as $item)
                                        <option disabled selected></option>
                                        <option value="{{ $item->invoice_external }}">{{ $item->invoice_external }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h3 class="font-bold">TOTAL DEBET : <span id="td"></span></h3>
                <h3 class="font-bold mb-5">TOTAL CREDIT : <span id="tc"></span></h3>

                <button class="btn bg-green-500 text-white w-5/12 ms-10 mb-5">Simpan Jurnal</button>
            </form>
        </div>
    </x-keuangan.card-keuangan>

    <script>

    let totaltdtc = 0;
    let dataTemp = [];

    $(document).ready(function () {
        $(`#invoice-1`).select2();
        $(`#nopol-1`).select2();
        $(`#akun_debet-1`).select2();
        $(`#akun_kredit-1`).select2();
        $(`#invoice_external-1`).select2();
        $(`#nominal-1`).on('keyup', function() {
            updateTotal();
        });

        $('#check0').click(function() {
            if ($('#check0').is(':checked')) {
                $('#invoice-1').prop('disabled', false);
                $('#nopol-1').prop('disabled', false);
                $('#akun_debet-1').prop('disabled', false);
                $('#akun_kredit-1').prop('disabled', false);
                $('#keterangan-1').prop('disabled', false);
                $('#nominal-1').prop('disabled', false);
                $('#invoice_external-1').prop('disabled', false);
            } else {
                $('#invoice-1').prop('disabled', true);
                $('#nopol-1').prop('disabled', true);
                $('#akun_debet-1').prop('disabled', true);
                $('#akun_kredit-1').prop('disabled', true);
                $('#keterangan-1').prop('disabled', true);
                $('#nominal-1').prop('disabled', true);
                $('#invoice_external-1').prop('disabled', true);
                $('#nominal-1').val(0);
                updateTotal();
            }
        });

        bindInvoiceChange(1);
    });

    let no = 1;
    $(`#counter`).val(no);
    function bindInvoiceChange(rowId) {
        $(`#invoice-${rowId}`).on('change', function() {
            $.ajax({
                method: 'post',
                url: "{{ route('jurnal.sj.whereInv') }}",
                data: { invoice: $(this).val(), },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    $(`#param1-${rowId}`).val(response.suratJalans[0]);
                    $(`#param2-${rowId}`).val(response.invoices[0]['transaksi']['suppliers']['nama']);
                    $(`#param3-${rowId}`).val(response.invoices[0]['transaksi']['barang']['nama']);
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                    console.log('Status:', status);
                    console.dir(xhr);
                }
            });
        });
    }

    function updateTotal() {
        totaltdtc = 0;
        $(`input[name="nominal[]"]`).each(function() {
            let value = parseInt($(this).val());
            if (!isNaN(value)) {
                totaltdtc += value;
            }
        });
        $(`#td`).text(totaltdtc);
        $(`#tc`).text(totaltdtc);
    }

    $('#addRow').on('click', function() {
        no++;
        $(`#counter`).val(no);
        let newRowId = no;

        let html = `
        <tr>
            <td>
                <input type="hidden" name="check[${newRowId - 1}]" id="check${newRowId - 1}h" value="0" checked>
                <input type="checkbox" name="check[${newRowId - 1}]" id="check${newRowId - 1}" value="1" checked>
            </td>
            <td>
                <select class="select select-bordered w-36 max-w-xs" name="invoice[]" id="invoice-${newRowId}">
                    <option selected></option>
                    @foreach ($invoice as $item)
                        <option value="{{ $item->invoice }}">{{ $item->invoice }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="select select-bordered w-36 max-w-xs" name="nopol[]" id="nopol-${newRowId}">
                    @foreach ($nopol as $item)
                    <option disabled selected></option>
                        <option value="{{ $item->nopol }}">{{ $item->nopol }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="select select-bordered w-36 max-w-xs" name="akun_debet[]" id="akun_debet-${newRowId}" required>
                    @foreach ($coa as $item)
                    <option value="0" selected></option>
                    <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="select select-bordered w-36 max-w-xs" name="akun_kredit[]" id="akun_kredit-${newRowId}" required>
                    @foreach ($coa as $item)
                    <option value="0" selected></option>
                    <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text" class="input input-sm input-bordered w-32 h-6 max-w-xs bg-transparent rounded-md" name="keterangan[]" id="keterangan-${newRowId}" required />
            </td>
            <td>
                <input type="number" class="input input-sm input-bordered w-32 h-6 max-w-xs bg-transparent rounded-md" min="0" name="nominal[]" id="nominal-${newRowId}" required />
            </td>
            <td>
                <select class="select select-bordered w-36 max-w-xs" name="invoice_external[]" id="invoice_external-${newRowId}">
                    @foreach ($transaksi as $item)
                        <option disabled selected></option>
                        <option value="{{ $item->invoice_external }}">{{ $item->invoice_external }}</option>
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
        </tr>
        `;
        $(`#tableParam`).append(param);

        $(`#invoice-${newRowId}`).select2();
        $(`#nopol-${newRowId}`).select2();
        $(`#akun_debet-${newRowId}`).select2();
        $(`#akun_kredit-${newRowId}`).select2();
        $(`#invoice_external-${newRowId}`).select2();


        $(`#check${newRowId - 1}`).click(function() {
            if ($(`#check${newRowId - 1}`).is(':checked')) {
                $(`#invoice-${newRowId}`).prop('disabled', false);
                $(`#nopol-${newRowId}`).prop('disabled', false);
                $(`#akun_debet-${newRowId}`).prop('disabled', false);
                $(`#akun_kredit-${newRowId}`).prop('disabled', false);
                $(`#keterangan-${newRowId}`).prop('disabled', false);
                $(`#nominal-${newRowId}`).prop('disabled', false);
                $(`#invoice_external-${newRowId}`).prop('disabled', false);
            } else {
                $(`#invoice-${newRowId}`).prop('disabled', true);
                $(`#nopol-${newRowId}`).prop('disabled', true);
                $(`#akun_debet-${newRowId}`).prop('disabled', true);
                $(`#akun_kredit-${newRowId}`).prop('disabled', true);
                $(`#keterangan-${newRowId}`).prop('disabled', true);
                $(`#nominal-${newRowId}`).prop('disabled', true);
                $(`#invoice_external-${newRowId}`).prop('disabled', true);
                $(`#nominal-${newRowId}`).val(0);
                updateTotal();
            }
        });

        $(`#nominal-${newRowId}`).on('keyup', function() {
            updateTotal();
        });
        bindInvoiceChange(newRowId);
    });

</script>

</x-Layout.layout>
