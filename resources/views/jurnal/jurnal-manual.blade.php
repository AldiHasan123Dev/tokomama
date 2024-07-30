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

    </style>

    <x-keuangan.card-keuangan>
        <x-slot:tittle>Form Jurnal Manual</x-slot:tittle>
        <div class="overflow-x-auto">
            <form action="{{ route('jurnal.store') }}" method="post">
                @csrf
                <input type="hidden" name="counter" id="counter">
                <table border="1" id="param">
                    <thead>
                        <th>Customer [1]</th>
                        <th>Supplier [2]</th>
                        <th>Barang [3]</th>
                    </thead>
                    <tbody id="tableParam">
                        <tr>
                            <td><input type="text" name="param1[]" id="param1-1" class="w-full"></td>
                            <td><input type="text" name="param2[]" id="param2-1" class="w-full"></td>
                            <td><input type="text" name="param3[]" id="param3-1" class="w-full"></td>
                        </tr>
                </tbody>
                <div class="grid grid-cols-2 justify-items-start">
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

                <div class="grid grid-cols-3 justify-items-start">
                    <div class="w-full">
                        <label class="form-control w-full max-w-xs mb-5">
                            <div class="label">
                                <span class="label-text">Tipe Jurnal</span>
                            </div>
                            <select name="tipe" id="tipe" class="select select-bordered w-full max-w-xs">
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
                <table class="table">
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
                                <input type="checkbox" name="check" id="check" checked>
                            </td>
                            <td>
                                <select class="select select-bordered w-full max-w-xs" name="invoice[]" id="invoice-1">
                                    <option selected></option>
                                    @foreach ($invoice as $item)
                                        <option value="{{ $item->invoice }}">{{ $item->invoice }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="select select-bordered w-full max-w-xs" name="nopol[]" id="nopol-1">
                                    @foreach ($nopol as $item)
                                    <option disabled selected></option>
                                        <option value="{{ $item->nopol }}">{{ $item->nopol }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="select select-bordered w-full max-w-xs" name="akun_debet[]" id="akun_debet-1">
                                    @foreach ($coa as $item)
                                    <option disabled selected></option>
                                    <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="select select-bordered w-full max-w-xs" name="akun_kredit[]" id="akun_kredit-1">
                                    @foreach ($coa as $item)
                                    <option disabled selected></option>
                                    <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" class="input input-sm input-bordered w-full max-w-xs bg-transparent rounded-xl" name="keterangan[]" id="keterangan-1" />
                            </td>
                            <td>
                                <input type="number" class="input input-sm input-bordered w-full max-w-xs bg-transparent rounded-xl" min="0" name="nominal[]" id="nominal-1" />
                            </td>
                            <td>
                                <select class="select select-bordered w-full max-w-xs" name="invoice_external[]" id="invoice_external-1">
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

                <button class="btn bg-green-500 text-white w-5/12 ms-10">Simpan Jurnal</button>
            </form>
        </div>
    </x-keuangan.card-keuangan>

    <script>

    let totaltdtc = 0;

    $(document).ready(function () {
        $(`#invoice-1`).select2();
        $(`#nopol-1`).select2();
        $(`#akun_debet-1`).select2();
        $(`#akun_kredit-1`).select2();
        $(`#invoice_external-1`).select2();
        $(`#nominal-1`).on(`change`, function() {
            totaltdtc += parseInt($(this).val());
            $(`#td`).text(totaltdtc);
            $(`#tc`).text(totaltdtc);
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

    $('#addRow').on('click', function() {
        no++;
        $(`#counter`).val(no);
        let newRowId = no;

        let html = `
        <tr>
            <td>
                <input type="checkbox" name="check" id="check-${newRowId}" checked>
            </td>
            <td>
                <select class="select select-bordered w-full max-w-xs" name="invoice[]" id="invoice-${newRowId}">
                    <option selected></option>
                    @foreach ($invoice as $item)
                        <option value="{{ $item->invoice }}">{{ $item->invoice }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="select select-bordered w-full max-w-xs" name="nopol[]" id="nopol-${newRowId}">
                    @foreach ($nopol as $item)
                    <option disabled selected></option>
                        <option value="{{ $item->nopol }}">{{ $item->nopol }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="select select-bordered w-full max-w-xs" name="akun_debet[]" id="akun_debet-${newRowId}">
                    @foreach ($coa as $item)
                    <option disabled selected></option>
                    <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="select select-bordered w-full max-w-xs" name="akun_kredit[]" id="akun_kredit-${newRowId}">
                    @foreach ($coa as $item)
                    <option disabled selected></option>
                    <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text" class="input input-sm input-bordered w-full max-w-xs bg-transparent rounded-xl" name="keterangan[]" id="keterangan-${newRowId}" />
            </td>
            <td>
                <input type="number" class="input input-sm input-bordered w-full max-w-xs bg-transparent rounded-xl" min="0" name="nominal[]" id="nominal-${newRowId}" />
            </td>
            <td>
                <select class="select select-bordered w-full max-w-xs" name="invoice_external[]" id="invoice_external-${newRowId}">
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
            <td><input type="text" name="param1[]" id="param1-${newRowId}" class="w-full"></td>
            <td><input type="text" name="param2[]" id="param2-${newRowId}" class="w-full"></td>
            <td><input type="text" name="param3[]" id="param3-${newRowId}" class="w-full"></td>
        </tr>
        `;
        $(`#tableParam`).append(param);

        $(`#invoice-${newRowId}`).select2();
        $(`#nopol-${newRowId}`).select2();
        $(`#akun_debet-${newRowId}`).select2();
        $(`#akun_kredit-${newRowId}`).select2();
        $(`#invoice_external-${newRowId}`).select2();

        $(`#nominal-${newRowId}`).on(`change`, function() {
            totaltdtc += parseInt($(this).val());
            $(`#td`).text(totaltdtc);
            $(`#tc`).text(totaltdtc);
        });

        bindInvoiceChange(newRowId);
    });
    
</script>

</x-Layout.layout>