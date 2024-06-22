<x-Layout.layout>
    <div class="grid grid-cols-3 gap-3">
        <div class="card w-fit bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Form Surat Jalan</h2>
                <form action="#" method="post">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">No. Surat</span>
                                </div>
                                <input type="text" class="input input-bordered w-full max-w-xs rounded-lg"
                                    id="no_surat" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Kepada</span>
                                </div>
                                <input type="text" class="input input-bordered w-full max-w-xs rounded-lg"
                                    id="kepada" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Jumlah</span>
                                </div>
                                <input type="number" class="input input-bordered w-full max-w-xs rounded-lg"
                                    id="jumlah" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Satuan</span>
                                </div>
                                <input type="text" class="input input-bordered w-full max-w-xs rounded-lg"
                                    id="satuan" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Jenis Barang</span>
                                </div>
                                <input type="text" class="input input-bordered w-full max-w-xs rounded-lg"
                                    id="jenis_barang" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Nama Kapal</span>
                                </div>
                                <input type="text" class="input input-bordered w-full max-w-xs rounded-lg"
                                    id="nama_kapal" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">No. Cont</span>
                                </div>
                                <input type="text" class="input input-bordered w-full max-w-xs rounded-lg"
                                    id="no_cont" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">No. Seal</span>
                                </div>
                                <input type="text" class="input input-bordered w-full max-w-xs rounded-lg"
                                    id="no_seal" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">No. Pol</span>
                                </div>
                                <input type="text" class="input input-bordered w-full max-w-xs rounded-lg"
                                    id="no_pol" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Tujuan/Nama Customer</span>
                                </div>
                                <input type="text" class="input input-bordered w-full max-w-xs rounded-lg"
                                    id="tujuan" />
                            </label>
                        </div>
                    </div>
                    <button class="btn btn-sm w-full bg-green-500 text-white rounded-lg mt-3">
                        <span><i class="fas fa-print"></i></span> Cetak
                    </button>
                </form>
            </div>
        </div>
        <div class="col-span-2">
            <div class="grid grid-cols-2 justify-items-stretch">
                <div class="grid grid-cols-3">
                    <div>
                        <img src="https://cdn.dribbble.com/users/1814782/screenshots/8500787/media/43acdb907462e9c7055110773f9d683f.jpg"
                            alt="company_logo" class="w-32">
                    </div>
                    <div class="font-bold font-serif col-span-2">
                        <p>CV.SARANA BAHAGIA</p>
                        <p>JL.Kalianak 55 BLOK G, SURABAYA</p>
                        <p>Telp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;031-123456
                        </p>
                        <p>Fax &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            031-123456</p>
                    </div>
                </div>
                <div class="justify-self-end font-bold font-serif">
                    <p>Kepada: <span id="txt_kepada"></span></p>
                    <p>Ekspedisi RAS</p>
                    <p>Jl.Kalianak 55 G, Surabaya</p>
                    <p>Surabaya</p>
                </div>
            </div>
            <p class="font-bold font-serif mb-5">SURAT JALAN No.: &nbsp; <span id="txt_no_surat"></span></p>
            <div class="overflow-x-auto">
                <table class="table border border-black">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th class="text-center border border-black">NO</th>
                            <th class="text-center border border-black">JUMLAH</th>
                            <th class="text-center border border-black">SATUAN</th>
                            <th class="text-center border border-black">JENIS BARANG</th>
                            <th class="text-center border border-black">TUJUAN / NAMA CUSTOMER</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-center border border-black" rowspan="5">1</th>
                            <td class="text-center border border-black" rowspan="5"><span id="txt_jumlah"></td>
                            <td class="text-center border border-black" rowspan="5"><span id="txt_satuan"></td>
                            <td class="border border-black"><span id="txt_jenis_barang"></td>
                            <td class="text-center border border-black" rowspan="5"><span id="txt_tujuan"></td>
                        </tr>
                        <tr>
                            <td class="border border-black py-1">
                                Nama Kapal: <span id="txt_nama_kapal">
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-black py-1">
                                No. Cont: <span id="txt_no_cont">
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-black py-1">
                                No. Seal: <span id="txt_no_seal">
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-black py-1">
                                No. Pol: <span id="txt_no_pol">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="mb-5">Note: &nbsp; Barang yang diterima dalam keadaan baik dan lengkap</p>
                <div class="grid grid-cols-2 justify-items-stretch mx-20 mb-3">
                    <div class="justify-self-start"></div>
                    <div class="justify-self-end">
                        <p class="text-center">Surabaya, 13 Maret 2003</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 justify-items-stretch mx-20">
                    <div class="justify-self-start font-bold">
                        <p class="mb-20 text-center">Penerima</p>
                        <p>(Galeh Ariya Irwana)</p>
                    </div>
                    <div class="justify-self-end font-bold">
                        <p class="mb-20 text-center">Pengirim</p>
                        <p>(Nanda Dwi Cahyo Wibowo)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#no_surat').on('input', function() {
            var inputValue = $(this).val();
            $('#txt_no_surat').text(inputValue);
        });
        $('#kepada').on('input', function() {
            var inputValue = $(this).val();
            $('#txt_kepada').text(inputValue);
        });
        $('#jumlah').on('input', function() {
            var inputValue = $(this).val();
            $('#txt_jumlah').text(inputValue);
        });
        $('#satuan').on('input', function() {
            var inputValue = $(this).val();
            $('#txt_satuan').text(inputValue);
        });
        $('#jenis_barang').on('input', function() {
            var inputValue = $(this).val();
            $('#txt_jenis_barang').text(inputValue);
        });
        $('#nama_kapal').on('input', function() {
            var inputValue = $(this).val();
            $('#txt_nama_kapal').text(inputValue);
        });
        $('#no_cont').on('input', function() {
            var inputValue = $(this).val();
            $('#txt_no_cont').text(inputValue);
        });
        $('#no_seal').on('input', function() {
            var inputValue = $(this).val();
            $('#txt_no_seal').text(inputValue);
        });
        $('#no_pol').on('input', function() {
            var inputValue = $(this).val();
            $('#txt_no_pol').text(inputValue);
        });
        $('#tujuan').on('input', function() {
            var inputValue = $(this).val();
            $('#txt_tujuan').text(inputValue);
        });
    </script>
</x-Layout.layout>