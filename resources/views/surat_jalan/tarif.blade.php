<x-Layout.layout>
    <dialog id="my_modal_5" class="modal">
        <div class="modal-box w-11/12 max-w-2xl pl-10">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold">Input Harga: <span id="barang"></span></h3>
            <label class="form-control w-full max-w">
                <div class="label">
                    <span class="label-text">Harga Jual</span>
                </div>
                <input type="text" class="form-control input-bordered w-full max-w" id="harga_jual" oninput="formatRibuan(this)" onclick="this.select()" />
            </label>
            <label class="form-control w-full max-w">
                <div class="label">
                    <span class="label-text">Harga Beli</span>
                </div>
                <input type="text" class="form-control input-bordered w-full max-w" id="harga_beli" oninput="formatRibuan(this)" onclick="this.select()" />
            </label>
            <label class="form-control w-full max-w">
                <div class="label">
                    <span class="label-text">Profit</span>
                </div>
                <input type="text" class="form-control input-bordered w-full max-w" readonly id="profit" />
            </label>
            <button type="button" class="btn bg-green-400 text-white font-semibold w-full mt-2" onclick="updateTransaksi()">Update</button>
        </div>
    </dialog>

    <x-keuangan.card-keuangan>
        <x-slot:tittle>List Belum Input Harga</x-slot:tittle>
        <div class="overflow-x-auto">
            <table class="table" id="table-non-tarif">
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>No. Surat</th>
                        <th>Barang</th>
                        <th>Jumlah Jual</th>
                        <th>Satuan Jual</th>
                        <th>Jumlah Beli</th>
                        <th>Satuan Beli</th>
                        <th>Harga Jual</th>
                        <th>Harga Beli</th>
                        <th>Profit</th>
                        <th>Nama Kapal</th>
                        <th>No. Count</th>
                        <th>No. Seal</th>
                        <th>No. Pol</th>
                        <th>No. Job</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </x-keuangan.card-keuangan>

    <x-keuangan.card-keuangan class="mt-3">
        <x-slot:tittle>List Sudah Input Harga</x-slot:tittle>
        <div class="overflow-x-auto">
            <table class="table" id="table-tarif">
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>No. Surat</th>
                        <th>Barang</th>
                        <th>Jumlah Jual</th>
                        <th>Satuan Jual</th>
                        <th>Jumlah Beli</th>
                        <th>Satuan Beli</th>
                        <th>Harga Jual</th>
                        <th>Harga Beli</th>
                        <th>Profit</th>
                        <th>Nama Kapal</th>
                        <th>No. Count</th>
                        <th>No. Seal</th>
                        <th>No. Pol</th>
                        <th>No. Job</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </x-keuangan.card-keuangan>

    <x-slot:script>
        <script>
            function formatRibuan(input) {
                let angka = input.value.replace(/,/g, '');  // Hapus koma
                input.value = angka.replace(/\B(?=(\d{3})+(?!\d))/g, ',');  // Format dengan koma
            }

            function getCleanNumber(value) {
                return parseInt(value.replace(/,/g, '')) || 0;  // Ubah ke integer, default 0 jika NaN
            }

            let id = null;
            let jumlah = 0;

            let table1 = $('#table-tarif').DataTable({
                order: [
                    [0]
                ],
                pageLength: 100,
                ajax: {
                    method: "POST",
                    url: "{{ route('transaksi.data') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        tarif: 1
                    }
                },
                columns: [
                    { data: 'aksi', name: 'aksi' },
                    { data: 'nomor_surat', name: 'No. Surat' },
                    { data: 'barang', name: 'barang' },
                    { data: 'jumlah_jual', name: 'jumlah_jual' },
                    { data: 'satuan_jual', name: 'satuan_jual' },
                    { data: 'jumlah_beli', name: 'jumlah_beli' },
                    { data: 'satuan_beli', name: 'satuan_jual' },
                    { data: 'harga_jual', name: 'harga_jual' },
                    { data: 'harga_beli', name: 'harga_beli' },
                    { data: 'profit', name: 'profit' },
                    { data: 'nama_kapal', name: 'nama_kapal' },
                    { data: 'no_cont', name: 'no_cont' },
                    { data: 'no_seal', name: 'no_seal' },
                    { data: 'no_pol', name: 'no_pol' },
                    { data: 'id', name: 'id', visible: false },
                ]
            });

            let table2 = $('#table-non-tarif').DataTable({
                order: [
                    [0]
                ],
                pageLength: 100,
                ajax: {
                    method: "POST",
                    url: "{{ route('transaksi.data') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        non_tarif: 1
                    }
                },
                columns: [
                    { data: 'aksi', name: 'aksi' },
                    { data: 'nomor_surat', name: 'No. Surat' },
                    { data: 'barang', name: 'barang' },
                    { data: 'jumlah_jual', name: 'jumlah_jual' },
                    { data: 'satuan_jual', name: 'jumlah_jual' },
                    { data: 'jumlah_beli', name: 'jumlah_beli' },
                    { data: 'satuan_beli', name: 'jumlah_jual' },
                    { data: 'harga_jual', name: 'harga_jual' },
                    { data: 'harga_beli', name: 'harga_beli' },
                    { data: 'profit', name: 'profit' },
                    { data: 'nama_kapal', name: 'nama_kapal' },
                    { data: 'no_cont', name: 'no_cont' },
                    { data: 'no_seal', name: 'no_seal' },
                    { data: 'no_pol', name: 'no_pol' },
                    { data: 'id', name: 'id', visible: false },
                ]
            });

            function inputTarif(id_transaksi, jual, beli, margin, qty, nama_barang, satuan_jual) {
                id = id_transaksi;
                jumlah = qty;
                $('#harga_jual').val(jual);
                $('#harga_beli').val(beli);
                $('#profit').val(margin);
                document.getElementById('barang').innerHTML = `${nama_barang} (Harga PER - ${satuan_jual})`;
                my_modal_5.showModal();
            }

            function calculateProfit() {
                const jual = getCleanNumber($('#harga_jual').val()) * jumlah;
                const beli = getCleanNumber($('#harga_beli').val()) * jumlah;
                const margin = jual - beli;
                $('#profit').val(margin);
                formatRibuan(document.getElementById('profit'));
            }

            $('#harga_jual, #harga_beli').on('input', calculateProfit);

            function updateTransaksi() {
                if (confirm('Apakah anda yakin?')) {
                    $.ajax({
                        type: "PUT",
                        url: "{{ route('transaksi.update') }}",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}",
                            harga_jual: getCleanNumber($('#harga_jual').val()),
                            harga_beli: getCleanNumber($('#harga_beli').val()),
                            margin: getCleanNumber($('#profit').val()),
                        },
                        success: function (response) {
                            table1.ajax.reload();
                            table2.ajax.reload();
                            alert("Update Berhasil!");
                            my_modal_5.close();
                            location.reload();
                        }
                    });
                }
            }

            $(document).ready(function() {
                // Jika ingin memformat profit saat halaman dimuat
                formatRibuan(document.getElementById('profit'));
            });
        </script>
    </x-slot:script>
</x-Layout.layout>
