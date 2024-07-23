<x-Layout.layout>
    <style>
        tr.selected{
            background-color: lightskyblue !important;
        }
    </style>
    <x-keuangan.card-keuangan>
        <x-slot:tittle>Tabel Invoice</x-slot:tittle>
        <div class="overflow-x-auto">
            <a href="#" target="_blank"
                class="btn bg-green-400 text-white my-5 py-4 font-bold hidden" id="print">
                <i class="fas fa-print"></i> Cetak Invoice</button>
            </a>
            <table class="table" id="surat_jalan_table">
                <!-- head -->
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>NSFP</th>
                        <th>Invoice</th>
                        <th>DPP</th>
                        <th>PPN</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </x-keuangan.card-keuangan>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.3/js/dataTables.select.js"></script>
    <script>
        $(document).ready(function () {
            var table = $('#surat_jalan_table').DataTable({
                serverSide: true,
                select:true,
                ajax: {
                    url: "{{ route('invoice.data') }}",
                    type: 'POST',
                    data:{
                        invoice:1
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'number'},
                    { data: 'nsfp' },
                    { data: 'invoice' },
                    { data: 'subtotal' },
                    { data: 'ppn' },
                    { data: 'total' },
                ]
            });

            $('#surat_jalan_table tbody').on( 'click', 'tr', function () {
                let row =  table.row( this ).data();
                $('.btn').removeClass('hidden');
                $('#print').attr('href', "{{ url('keuangan/cetak-invoice') }}"+'/?invoice='+row.invoice);
            });
        });
    </script>
</x-Layout.layout>
