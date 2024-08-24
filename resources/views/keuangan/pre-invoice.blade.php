<x-Layout.layout>
    <style>
        tr.selected{
            background-color: lightskyblue !important;
        }
    </style>
    <x-keuangan.card-keuangan>
        <x-slot:tittle>Pengambilan Nomor Faktur Untuk Invoice</x-slot:tittle>
        <x-slot:button>
            <form action="{{ route('invoice-transaksi.index') }}" method="get" id="form">
                <input type="hidden" name="id_transaksi" id="id_transaksi">
                <div class="flex gap-2">
                    <div class="flex-gap-2">
                        <label for="count">Jumlah Invoice</label>
                        <input type="number" name="invoice_count" id="count" value="1" class=" rounded-md form-control text-center" min="1" style="height: 28px">
                    </div>
                    <button type="submit" class="btn font-semibold bg-green-500 btn-sm text-white mt-4">Buat Draf Invoice</button>
                </div>
            </form>
        </x-slot:button>
        <div class="overflow-x-auto">
            <table class="table" id="table-getfaktur">
                <!-- head -->
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No</th>
                        <th>Invoice</th>
                        <th>No. Surat</th>
                        <th>Customer</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th>Nama Kapal</th>
                        <th>No. Count</th>
                        <th>No. Seal</th>
                        <th>No. Pol</th>
                        <th>No. Job</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </x-keuangan.card-keuangan>

    {{-- <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script> --}}
    <x-slot:script>
        {{-- <script src="https://cdn.datatables.net/select/2.0.3/js/dataTables.select.js"></script>
        <script src="https://cdn.datatables.net/select/2.0.3/js/select.dataTables.js"></script> --}}
        <script>
            let table = $(`#table-getfaktur`).DataTable({
                pageLength: 100,
                ajax: {
                    url: "{{route('invoice.pre-invoice')}}",
                    dataSrc: "data"
                },
                columns: [
                    { data: 'checkbox', name: 'checkbox'},
                    { data: 'DT_RowIndex', name: 'number'},
                    { data: 'invoice', name: 'No. Surat' },
                    { data: 'nomor_surat', name: 'No. Surat' },
                    { data: 'customer', name: 'No. Surat' },
                    { data: 'nama_barang', name: 'nama_barang' },
                    { data: 'sisa', name: 'sisa' },
                    { data: 'harga_jual', name: 'harga_jual' },
                    { data: 'subtotal', name: 'subtotal' },
                    { data: 'nama_kapal', name: 'nama_kapal' },
                    { data: 'no_cont', name: 'no_cont' },
                    { data: 'no_seal', name: 'no_seal' },
                    { data: 'no_pol', name: 'no_pol' },
                    { data: 'id', name: 'id', visible:false},
                ]
            });

            $('#form').submit(function (e) {
                e.preventDefault();
                var ids = $("#table-getfaktur input:checkbox:checked").map(function(){
                    return $(this).val();
                }).get();
                $('#id_transaksi').val(ids);
                this.submit();
            });
        </script>

    </x-slot:script>
</x-Layout.layout>
