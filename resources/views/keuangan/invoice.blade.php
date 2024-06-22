<x-Layout.layout>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="grid grid-cols-5">
                <div>
                    <button class="btn btn-sm bg-green-400 text-white font-bold w-fit">Edit tanggal</button>
                </div>
                <div>
                    <p>List Semua Invoice </p>
                </div>
                <div>
                    <p class="font-bold">INVOICE (selected): </p>
                </div>
                <div>
                    <button class="btn btn-sm bg-blue-400 text-white font-bold w-fit">Rekap Invoice Excel</button>
                </div>
                <div>
                    <button class="btn btn-sm bg-green-400 text-white font-bold w-fit"><i class="fas fa-print"></i>
                        Cetak Invoice Ulang</button>
                </div>
            </div>
            <table id="myTable" class="display mt-3"></table>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script>
        var data = [
            {
                "name": "Tiger Nixon",
                "position": "System Architect",
                "salary": "$3,120",
                "start_date": "2011/04/25",
                "office": "Edinburgh",
                "extn": "5421"
            },
            {
                "name": "Garrett Winters",
                "position": "Director",
                "salary": "$5,300",
                "start_date": "2011/07/25",
                "office": "Edinburgh",
                "extn": "8422"
            }
        ]

        $(document).ready(function () {
            table = $('#myTable').DataTable({
                data: data,
                columns: [
                    { title: "Name", data: 'name', selected: true },
                    { data: 'position' },
                    { data: 'salary' },
                    { data: 'office' }
                ]
            });

            var dataku = $('#myTable').DataTable().row('.selected').data();

            table.rows({ selected: true });
            table.columns({ selected: true });
            table.cells({ selected: true });
        });
    </script>
</x-Layout.layout>