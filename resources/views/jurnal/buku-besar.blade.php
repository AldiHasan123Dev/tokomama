<x-Layout.layout>
    <x-keuangan.card-keuangan>
        <x-slot:tittle>Jurnal Buku Besar</x-slot:tittle>
        <div class="overflow-x-auto">
            <button class="btn bg-green-500 text-white mt-3 mb-5" type="button"><i class="fa-solid fa-file-excel"></i> Export Excel</button>

            <div class="grid grid-cols-4">
                <div class="font-bold">Akun : </div>
                <div>
                    <select class="js-example-basic-single w-1/2" name="akun" id="coas">
                        @foreach ($coa as $c)
                            <option disabled selected></option>
                            <option value="{{ $c->id }}">{{ $c->no_akun }} - {{ $c->nama_akun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="font-bold">Tahun : </div>
                <div>
                    <select class="js-example-basic-single w-1/2" name="akun" id="thn">
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

            
            <div class="mb-16 mt-8 flex">
                <label for="month" class="font-bold">Bulan:</label>
                <form action="" method="GET">
                    <input type="hidden" name="month" value="1">
                    <input type="hidden" name="year" id="y1" value="{{ date('Y') }}">
                    <input type="hidden" name="coa" id="c1">
                    <button class="px-4 py-3 border-2 border-green-600 hover:bg-green-600 hover:text-white duration-300 rounded-xl mx-1">Jan</button>
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
            </div>
            

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
            
            //const date = new Date();
            //const month = date.getMonth() //+ 1;
            //const year = date.getFullYear();

            $(`#coas`).on(`change`, function() {
                $(`#c1`).val($(this).val())
                $(`#c2`).val($(this).val())
                $(`#c3`).val($(this).val())
                $(`#c4`).val($(this).val())
                $(`#c5`).val($(this).val())
                $(`#c6`).val($(this).val())
                $(`#c7`).val($(this).val())
                $(`#c8`).val($(this).val())
                $(`#c9`).val($(this).val())
                $(`#c10`).val($(this).val())
                $(`#c11`).val($(this).val())
                $(`#c12`).val($(this).val())
            });

            $(`#thn`).on(`change`, function() {
                $(`#y1`).val($(this).val())
                $(`#y2`).val($(this).val())
                $(`#y3`).val($(this).val())
                $(`#y4`).val($(this).val())
                $(`#y5`).val($(this).val())
                $(`#y6`).val($(this).val())
                $(`#y7`).val($(this).val())
                $(`#y8`).val($(this).val())
                $(`#y9`).val($(this).val())
                $(`#y10`).val($(this).val())
                $(`#y11`).val($(this).val())
                $(`#y12`).val($(this).val())
            })

            const searchParams = new URLSearchParams(window.location.search);
            let month = searchParams.get("month");
            let year = searchParams.get("year");
            let coa = searchParams.get("coa");

            var table = $('#table-buku-besar').DataTable({
                select:true,
                ajax: {
                    url: `{{ url('/bb-data/${month}/${year}/${coa}') }}`,
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
