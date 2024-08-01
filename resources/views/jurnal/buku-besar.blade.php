<x-Layout.layout>
    <x-keuangan.card-keuangan>
        <x-slot:tittle>Jurnal Buku Besar</x-slot:tittle>
        <div class="overflow-x-auto">
            <button class="btn bg-green-500 text-white mt-3 mb-5" type="button"><i class="fa-solid fa-file-excel"></i> Export Excel</button>

            <div class="grid grid-cols-4">
                <div class="font-bold">Akun : </div>
                <div>
                    <select class="js-example-basic-single w-1/2" name="akun">
                        @foreach ($coa as $c)
                            <option disabled selected></option>
                            <option value="{{ $c->id }}">{{ $c->no_akun }} - {{ $c->nama_akun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="font-bold">Tahun : </div>
                <div>
                    <select class="js-example-basic-single w-1/2" name="akun">
                        <option selected value="{{ date('Y') }}">{{ date('Y') }}</option>
                        @for($year = date('Y'); $year >= 2024; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <table class="table mb-10">
                <!-- head -->
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Jan</th>
                    <th>Feb</th>
                    <th>Mar</th>
                    <th>Apr</th>
                    <th>Mei</th>
                    <th>Jun</th>
                    <th>Jul</th>
                    <th>Agu</th>
                    <th>Sep</th>
                    <th>Okt</th>
                    <th>Nov</th>
                    <th>Des</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- row 1 -->
                  <tr>
                    <th>Saldo Awal</th>
                  </tr>
                  <!-- row 2 -->
                  <tr class="hover">
                    <th>Debit</th>
                  </tr>
                  <!-- row 3 -->
                  <tr>
                    <th>Credit</th>
                  </tr>
                  <!-- row 4 -->
                  <tr>
                    <th>Saldo Akhir</th>
                  </tr>
                </tbody>
              </table>

            <label for="month" class="font-bold">Bulan:</label>

            <!--<a href="/bb-data/1/2024/1" class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Jan</a>
            <a href="/bb-data/2/2024/1" class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Feb</a>
            <a href="/bb-data/3/2024/1" class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Mar</a>
            <a href="/bb-data/4/2024/1" class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Apr</a>
            <a href="/bb-data/5/2024/1" class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Mei</a>
            <a href="/bb-data/6/2024/1" class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Jun</a>
            <a href="/bb-data/7/2024/1" class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Jul</a>
            <a href="/bb-data/8/2024/1" class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Agu</a>
            <a href="/bb-data/9/2024/1" class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Sep</a>
            <a href="/bb-data/10/2024/1" class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Okt</a>
            <a href="/bb-data/11/2024/1" class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Nov</a>
            <a href="/bb-data/12/2024/1" class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Des</a> -->

            <table id="table-buku-besar" class="cell-border hover display nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>No. Jurnal</th>
                        <th>No. Akun</th>
                        <th>Akun</th>
                        <th>Nopol</th>
                        <th>Invoice</th>
                        <th>Keterangan</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
    </x-keuangan.card-keuangan>
    <script src="https://cdn.datatables.net/2.1.0/js/dataTables.tailwindcss.js"></script>
    <script>
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
            
            const date = new Date();
            const month = date.getMonth() //+ 1;
            const year = date.getFullYear();


            var table = $('#table-buku-besar').DataTable({
                select:true,
                ajax: {
                    url: `{{ url('/buku-besar/${month}/${year}') }}`,
                    type: 'GET'
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'number'},
                    { data: 'tgl', name: 'tanggal' },
                    { data: 'nomor', name: 'nomor jurnal' },
                    { data: 'no_akun', name: 'nomor akun' },
                    { data: 'akun', name: 'akun' },
                    { data: 'nopol', name: 'nomor polisi' },
                    { data: 'invoice', name: 'invoice' },
                    { data: 'keterangan', name: 'Keterangan' },
                    { data: 'debit', name: 'debit' },
                    { data: 'kredit', name: 'kredit' },
                    { data: 'saldo', name: 'saldo' },
                    { data: 'id', name: 'id', visible:false},
                ]
            });
        });
    </script>
</x-Layout.layout>
