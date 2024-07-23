<x-Layout.layout>
    <style>
        tr.selected {
            background-color: lightskyblue !important;
        }
    </style>
    <x-keuangan.card-keuangan>
        <x-slot:tittle>Laporan Omzet</x-slot:tittle>
        <div class="overflow-x-auto">
            <table class="table" id="table-omzet">
                <!-- head -->
                <thead>
                    <tr>
                        <th>NO. </th>
                        <th>TGL STUFFING</th>
                        <th>NO. SURAT JALAN</th>
                        <th>NO. INV</th>
                        <th>No. Faktur Pajak</th>
                        <th>PO CUSTOMER</th>
                        <th>CUSTOMER</th>
                        <th>TUJUAN (Kota Cust)</th>
                        <th>NAMA KAPAL</th>
                        <th>Cont</th>
                        <th>Seal</th>
                        <th>Job</th>
                        <th>Nopol</th>
                        <th>JENIS BARANG</th>
                        <th>QUANTITY</th>
                        <th>HARGA JUAL</th>
                        <th>TOTAL TAGIHAN</th>
                        <th>SUPPLIER</th>
                        <th>HARGA BELI</th>
                        <th>TOTAL</th>
                        <th>TGL. PEMBAYARAN</th>
                        <th>NO. VOUCHER</th>
                        <th>MARGIN</th>
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
            let table = $(`#table-omzet`).DataTable({
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