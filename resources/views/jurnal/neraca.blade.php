<x-Layout.layout>
    <x-keuangan.card-keuangan>
        <x-slot:tittle>Laporan Neraca</x-slot:tittle>
        <div class="overflow-x-auto">
            <form action="{{ route('jurnal.coa') }}" method="post">
                @csrf
            <div>
            <div>
            <a href="#" target="_blank"
                class="btn bg-green-400 text-white my-5 py-4 font-bold" id="print">
                <i class="fas fa-print"></i> Print Laporan</button>
            </a>
            <div class="flex justify-between">
                <div>
                    <label for="bulan" class="mr-2 margin-top:40px">Bulan:</label>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Jan</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Feb</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Mar</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Apr</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Mei</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Jun</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Jul</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Aug</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Sep</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Okt</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Nov</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Des</button>
                </div>
                    <div class="flex items-center">
                        <label for="tahun" class="mr-2">Tahun:</label>
                        <input type="text" id="tahun" name="tahun" class="input input-bordered rounded-lg dark:text-black my-3 py-3">
                    </div>
                </div>
            </div>

                <table class="table" id="coa_table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>No. Akun</th>
                            <th>Nama Akun</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                </table>
            </form>
        </div>
    </x-keuangan.card-keuangan>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.3/js/dataTables.select.js"></script>
    <script>
        $(document).ready(function () {
            var table = $('#coa_table').DataTable({
                serverSide: true,
                select:true,
                ajax: {
                    url: "{{ route('coa.data') }}",
                    type: 'POST'
                },
                columns: [
                    { data: 'no_akun' },
                    { data: 'nama_akun' },
                    { data: 'status' },
                ]
            });

            $('#coa_table tbody').on('click', 'tr', function () {
                let row =  table.row( this ).data();
                $('.btn').removeClass('hidden');
                $('#print').attr('href', "{{ route('invoice.print', ['id' => ':id']) }}".replace(':id', row.id));
            });
        });
    </script>
</x-Layout.layout>