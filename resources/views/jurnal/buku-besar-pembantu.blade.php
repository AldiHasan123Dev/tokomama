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
                        <option value="2030">2030</option>
                        <option value="2029">2029</option>
                        <option value="2028">2028</option>
                        <option value="2027">2027</option>
                        <option value="2026">2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                        <option value="2020">2020</option>
                        <option value="2019">2019</option>
                        <option value="2018">2018</option>
                        <option value="2017">2017</option>
                        <option value="2016">2016</option>
                        <option value="2015">2015</option>
                        <option value="2014">2014</option>
                        <option value="2013">2013</option>
                        <option value="2012">2012</option>
                        <option value="2011">2011</option>
                        <option value="2010">2010</option>
                    </select>
                </div>
            </div>

            <table class="table">
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

            <label for="tahun" class="mr-2 margin-top:40px">Bulan:</label>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black " id="aktif" type="submit">Jan</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Feb</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Mar</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Apr</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Mei</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Jun</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Jul</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Aug</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Sep</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Okt</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Nov</button>
            <button class="btn dark:text-white dark:bg-blue-500 bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Des</button>

            <table id="table-buku-besar">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No. Jurnal</th>
                        <th>No. Akun</th>
                        <th>Akun</th>
                        <th>No. Cont</th>
                        <th>Nopol</th>
                        <th>No. Job</th>
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

    <script>
        $(document).ready(function () {
            $('.js-example-basic-single').select2();

            var table = $('#table-buku-besar').DataTable({
                select:true,
                ajax: {
                    url: "{{ route('coa.data') }}",
                    type: 'POST'
                },
                columns: [
                    { data: '#' },
                    { data: 'no_akun' },
                    { data: 'nama_akun' },
                    { data: 'status' },
                ]
            });
        });
    </script>
</x-Layout.layout>