<x-Layout.layout>
    <x-keuangan.card-keuangan>
        <x-slot:tittle>Menu Jurnal</x-slot:tittle>
        <div class="overflow-x-auto">
            <a href="{{ route('jurnal-manual.index') }}">
                <button class="btn bg-green-500 text-white font-bold hover:bg-green-700">Jurnal Manual</button>
            </a>

            <a href="{{ route('jurnal.jurnal-merger') }}">
                <button class="btn bg-gray-500 text-white font-bold hover:bg-gray-700">Merge Jurnal</button>
            </a>

            <div class="flex flex-row mb-16 mt-8">
                <label for="month" class="font-bold mt-4">Bulan:</label>
                <form action="" method="GET">
                    <input type="hidden" name="month" value="1">
                    <input type="hidden" name="year" id="y1" value="{{ date('Y') }}">
                    <input type="hidden" name="coa" id="c1">
                    <button class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1 @if(isset($_GET['month']) && $_GET['month'] == 1) bg-green-500 text-white @endif">Jan</button>
                </form>
                <form action="" method="GET">
                    <input type="hidden" name="month" value="2">
                    <input type="hidden" name="year" id="y2" value="{{ date('Y') }}">
                    <input type="hidden" name="coa" id="c2">
                    <button class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Feb</button>
                </form>
                <form action="" method="GET">
                    <input type="hidden" name="month" value="3">
                    <input type="hidden" name="year" id="y3" value="{{ date('Y') }}">
                    <input type="hidden" name="coa" id="c3">
                    <button class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Mar</button>
                </form>
                <form action="" method="GET">
                    <input type="hidden" name="month" value="4">
                    <input type="hidden" name="year" id="y4" value="{{ date('Y') }}">
                    <input type="hidden" name="coa" id="c4">
                    <button class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Apr</button>
                </form>
                <form action="" method="GET">
                    <input type="hidden" name="month" value="5">
                    <input type="hidden" name="year" id="y5" value="{{ date('Y') }}">
                    <input type="hidden" name="coa" id="c5">
                    <button class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Mei</button>
                </form>
                <form action="" method="GET">
                    <input type="hidden" name="month" value="6">
                    <input type="hidden" name="year" id="y6" value="{{ date('Y') }}">
                    <input type="hidden" name="coa" id="c6">
                    <button class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Jun</button>
                </form>
                <form action="" method="GET">
                    <input type="hidden" name="month" value="7">
                    <input type="hidden" name="year" id="y7" value="{{ date('Y') }}">
                    <input type="hidden" name="coa" id="c7">
                    <button class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Jul</button>
                </form>
                <form action="" method="GET">
                    <input type="hidden" name="month" value="8">
                    <input type="hidden" name="year" id="y8" value="{{ date('Y') }}">
                    <input type="hidden" name="coa" id="c8">
                    <button class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Agu</button>
                </form>
                <form action="" method="GET">
                    <input type="hidden" name="month" value="9">
                    <input type="hidden" name="year" id="y9" value="{{ date('Y') }}">
                    <input type="hidden" name="coa" id="c9">
                    <button class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Sep</button>
                </form>
                <form action="" method="GET">
                    <input type="hidden" name="month" value="10">
                    <input type="hidden" name="year" id="y10" value="{{ date('Y') }}">
                    <input type="hidden" name="coa" id="c10">
                    <button class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Okt</button>
                </form>
                <form action="" method="GET">
                    <input type="hidden" name="month" value="11">
                    <input type="hidden" name="year" id="y11" value="{{ date('Y') }}">
                    <input type="hidden" name="coa" id="c11">
                    <button class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Nov</button>
                </form>
                <form action="" method="GET">
                    <input type="hidden" name="month" value="12">
                    <input type="hidden" name="year" id="y12" value="{{ date('Y') }}">
                    <input type="hidden" name="coa" id="c12">
                    <button class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Des</button>
                </form>

                <div class="w-full ml-10 mt-3">
                    <b>Tahun : </b>
                    <select class="js-example-basic-single w-1/2" name="akun" id="thn">
                        <option selected value="{{ date('Y') }}">{{ date('Y') }}</option>
                        @for($year = date('Y'); $year >= 2024; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 mb-10">
                <div>
                    Filter Tanggal : <input type="date" name="tanggal" id="tanggal">
                </div>
                <div>
                    <div class="flex flex-row">
                        <label for="month" class="font-bold mt-3">Tipe : </label>
                        <form action="" method="GET">
                            <input type="hidden" name="month" value="1">
                            <input type="hidden" name="year" id="y1" value="{{ date('Y') }}">
                            <input type="hidden" name="coa" id="c1">
                            <button class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1 @if(isset($_GET['month']) && $_GET['month'] == 1) bg-green-500 text-white @endif">BANK</button>
                        </form>
                        <form action="" method="GET">
                            <input type="hidden" name="month" value="2">
                            <input type="hidden" name="year" id="y2" value="{{ date('Y') }}">
                            <input type="hidden" name="coa" id="c2">
                            <button class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">KAS</button>
                        </form>
                        <form action="" method="GET">
                            <input type="hidden" name="month" value="3">
                            <input type="hidden" name="year" id="y3" value="{{ date('Y') }}">
                            <input type="hidden" name="coa" id="c3">
                            <button class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">JNL</button>
                        </form>
                        <form action="" method="GET">
                            <input type="hidden" name="month" value="4">
                            <input type="hidden" name="year" id="y4" value="{{ date('Y') }}">
                            <input type="hidden" name="coa" id="c4">
                            <button class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">TEST</button>
                        </form>
                    </div>
                </div>
                <div>
                    <form action="{{ route('jurnal.edit') }}" method="get">
                        <input type="hidden" name="tipe" id="tipe">
                        <input type="hidden" name="no" id="no">
                        <input type="hidden" name="tgl" id="tgl">
                        <button class="btn bg-yellow-500 text-white font-bold hover:bg-yellow-700" id="edit">Edit Jurnal</button>
                    </form>
                </div>
            </div>

            <table class="table" id="coa_table">
                <!-- head -->
                <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Tipe</th>
                    <th>Nomor</th>
                    <th>No. Akun</th>
                    <th>Nama Akun</th>
                    <th>Invoice</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                    <th>Keterangan</th>
                    <th>Invoice External</th>
                    <th>Nopol</th>
                    <th>Container</th>
                </tr>
                </thead>
            </table>
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
                    url: "{{ route('jurnal.data') }}",
                    type: 'POST'
                },
                columns: [
                    { data: 'tgl' },
                    { data: 'tipe' },
                    { data: 'nomor' },
                    { data: 'no_akun' },
                    { data: 'nama_akun' },
                    { data: 'invoice' },
                    { data: 'debit' },
                    { data: 'kredit' },
                    { data: 'keterangan' },
                    { data: 'invoice_external' },
                    { data: 'nopol' },
                    { data: 'container' },
                ]
            });

            $('#coa_table tbody').on('click', 'tr', function () {
                const row =  table.row( this ).data();
                $('#tipe').val(row.tipe);
                $('#no').val(row.no);
                $('#tgl').val(row.tgl);
                $('.btn').removeClass('hidden');
                $('#print').attr('href', "{{ route('invoice.print', ['id' => ':id']) }}".replace(':id', row.id));
            });
        });
    </script>

</x-Layout.layout>
