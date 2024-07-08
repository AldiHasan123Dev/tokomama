<x-Layout.layout>
    <style>
        @media print {
            #print .header {
                margin-top: 10px;
            }

            #print,
            #print * {
                visibility: visible !important;
                font-family: 'Open Sans', sans-serif;
                font-size: .7rem !important;
                color: black !important;
            }

            #print {
                width: 100%;
                font-family: 'Open Sans', sans-serif;
            }

            .card {
                display: none !important;
            }

            #reset {
                all: unset !important;
            }
        }

        #table-barang td{
            padding: 0px;
        }
    </style>
    <form action="{{ route('surat-jalan.store') }}" method="post" class="grid grid-cols-3 gap-3" id="reset">
        <div class="card w-fit bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Form Surat Jalan</h2>
                <div>
                    <input type="hidden" name="no" value="{{ $no }}">
                    @csrf
                    <div>
                        <label class="form-control w-full max-w-xs">
                            <div class="label">
                                <span class="label-text">No. Surat</span>
                            </div>
                            <input type="text"
                                class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                id="nomor_surat" name="nomor_surat" readonly value="{{ $nomor }}" />
                        </label>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Kepada</span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="kepada" name="kepada" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Jumlah</span>
                                </div>
                                <input type="number"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="jumlah" min="0" name="jumlah" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Satuan</span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="satuan" name="satuan" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Nama Kapal</span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="nama_kapal" name="nama_kapal" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">No. Cont</span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="no_cont" name="no_cont" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">No. Seal</span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="no_seal" name="no_seal" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">No. Pol</span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="no_pol" name="no_pol" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">No. Job</span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="no_job" name="no_job" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Tujuan/Nama Customer</span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="tujuan" name="tujuan" list="customer_list" />
                                    <input type="hidden" name="id_customer" id="id_customer">
                                    <datalist id="customer_list">
                                        @foreach ($customer as $mb)
                                        <option data-id="{{$mb->id}}" value="{{ $mb->nama }}">{{ $mb->nama }}</option>
                                        @endforeach
                                    </datalist>
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Kota Pengirim</span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="kota_pengirim" name="kota_pengirim" value="Surabaya" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Nama Pengirim</span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="nama_pengirim" name="nama_pengirim" value="FIRDA" />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Nama Penerima</span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="nama_penerima" name="nama_penerima" value="IFAN" />
                            </label>
                        </div>
                    </div>
                    <input type="hidden" name="total" id="total">
                    <button type="submit" onclick="return confirm('Apakah anda yakin?')"
                        class="btn btn-sm w-full bg-green-500 text-white rounded-lg mt-3">
                        Konfirmasi Surat Jalan
                    </button>
                </div>
            </div>
        </div>
        <div class="col-span-2" id="print">
            <div class="card bg-base-100 shadow-xl mb-5">
                <div class="card-body">
                    <div class="block overflow-x-auto w-full">
                        <table class="table w-full border-collapse" id="table-barang" style="font-size: .7rem">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga Beli</th>
                                    <th>Jumlah Beli</th>
                                    <th>Satuan Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Jumlah Jual</th>
                                    <th>Satuan Jual</th>
                                    <th>Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i < 5; $i++)
                                <input type="hidden" name="id_barang[]" id="id_barang-{{ $i }}" />
                                <tr>
                                    <td class="text-center">{{ $i }}</td>
                                    <td>
                                        <input type="text" onchange="inputBarang()" name="barang[]" id="barang-{{ $i }}" class="form-control" list="barang_list">
                                    </td>
                                    <td>
                                        <input type="text" onchange="inputBarang()" name="jumlah[]" id="jumlah-{{ $i }}" class="form-control" list="barang_list">
                                    </td>
                                    <td>
                                        <input type="number" style="width:120px" onchange="inputBarang()" name="harga_beli[]" id="harga_beli-{{ $i }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" style="width:120px" onchange="inputBarang()" name="jumlah_beli[]" id="jumlah_beli-{{ $i }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" style="width:120px" onchange="inputBarang()" name="satuan_beli[]" id="satuan_beli-{{ $i }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" style="width:120px" onchange="inputBarang()" name="harga_jual[]" id="harga_jual-{{ $i }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" style="width:120px" onchange="inputBarang()" name="jumlah_jual[]" id="jumlah_jual-{{ $i }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" style="width:120px" onchange="inputBarang()" name="satuan_jual[]" id="satuan_jual-{{ $i }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" style="width:120px" onchange="inputBarang()" name="profit[]" id="profit-{{ $i }}" class="form-control">
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                        <datalist id="barang_list">
                            @foreach ($barang as $mb)
                            <option data-id="{{$mb->id}}" value="{{ $mb->nama }}">{{ $mb->nama }}</option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
            </div>
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
            <p class="font-bold font-serif mb-5">SURAT JALAN No.: &nbsp; <span id="txt_nomor_surat"></span></p>
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
                            <th class="text-center border border-black" rowspan="6">1</th>
                            <td class="text-center border border-black" rowspan="6"><span id="txt_jumlah"></td>
                            <td class="text-center border border-black" rowspan="6"><span id="txt_satuan"></td>
                            <td class="border border-black" id="barang-list">

                            </td>
                            <td class="text-center border border-black" rowspan="6"><span id="txt_tujuan"></td>
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
                        <tr>
                            <td class="border border-black py-1">
                                No. Job: <span id="txt_no_job">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="mb-5">Note: &nbsp; Barang yang diterima dalam keadaan baik dan lengkap</p>
                <div class="grid grid-cols-2 justify-items-stretch mx-20 mb-3">
                    <div class="justify-self-start"></div>
                    <div class="justify-self-end">
                        <p class="text-center"><span id="txt_kota_pengirim"></span>, {{ now()->format('d F Y') }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 justify-items-stretch mx-20">
                    <div class="justify-self-start font-bold">
                        <p class="mb-20 text-center">Penerima</p>
                        <p>(<span id="txt_nama_penerima">IFAN</span>)</p>
                    </div>
                    <div class="justify-self-end font-bold">
                        <p class="mb-20 text-center">Pengirim</p>
                        <p>(<span id="txt_nama_pengirim">FIRDA</span>)</p>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        $('#kepada').on('input', function() {
            var inputValue = $(this).val();
            $('#txt_kepada').text(inputValue);
        });
        
        $('#jumlah').on('input', function() {
            var inputValue = $(this).val();
            $('#txt_jumlah').text(inputValue);
            $('#txt_total').text(inputValue);
        });
        
        $('#jumlah_satuan').on('input', function() {
            var inputValue = $(this).val();
            $('#txt_total').text($('#jumlah').val() * inputValue);
        });
        
        $('#satuan').on('input', function() {
            var inputValue = $(this).val();
            $('#txt_satuan').text(inputValue);
        });
        
        $('#jenis_barang').on('input', function() {
            var inputValue = $(this).val();
            $('#txt_jenis_barang').text(inputValue);
            var text = $("#jenis_barang_list option[value='"+inputValue+"']").data('text');
            $('#txt_jenis_barang').text(inputValue);
            $('#txt_total').text($('#jumlah').val() * $('#jumlah_satuan').val() * text);
            $('#total').val($('#jumlah').val() * $('#jumlah_satuan').val() * text);

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
        
        $('#no_job').on('input', function() {
            var inputValue = $(this).val();
            $('#txt_no_job').text(inputValue);
        });
        
        $('#tujuan').on('input', function() {
            var inputValue = $(this).val();
            var id = $("#customer_list option[value='"+inputValue+"']").data('id');
            $('#id_customer').val(id);
            $('#txt_tujuan').text(inputValue);
        });

        $('#harga_jual').on('click', function() {
            var harga_jual = $('#harga_jual').val();
            var harga_beli = $('#harga_beli').val();
            var total = $('#txt_total').text();

            $('#profit').val((harga_jual * total) - (harga_beli * total));
        });

        //jquery ready function
        $(document).ready( function(){
            $('#txt_nomor_surat').text($('#nomor_surat').val());
            $('#txt_kota_pengirim').text($('#kota_pengirim').val());
            $('#txt_nama_pengirim').text($('#nama_pengirim').val());
            $('#txt_nama_penerima').text($('#nama_penerima').val());
        });
        
        $("#kota_pengirim").on({
            input: function(){
                var inputValue = $(this).val();
                $('#txt_kota_pengirim').text(inputValue);
            },
            click: function(){
                var inputValue = $(this).val();
                $('#txt_kota_pengirim').text(inputValue);
            }
        });
        
        $("#nama_pengirim").on({
            input: function(){
                var inputValue = $(this).val();
                $('#txt_nama_pengirim').text(inputValue);
            },
            click: function(){
                var inputValue = $(this).val();
                $('#txt_nama_pengirim').text(inputValue);
            }
        });
        
        $("#nama_penerima").on({
            input: function(){
                var inputValue = $(this).val();
                $('#txt_nama_penerima').text(inputValue);
            },
            click: function(){
                var inputValue = $(this).val();
                $('#txt_nama_penerima').text(inputValue);
            }
        });

        function inputBarang()
            {
                let text = '';
                for (let i = 1; i  < 5; i++) {
                    const barang = $('#barang-' + i).val();
                    const jumlah_jual = $('#jumlah_jual-' + i).val(); 
                    const satuan_jual = $('#satuan_jual-' + i).val();
                    if(barang!='' && typeof(barang) != undefined){
                        var id_barang = $("#barang_list option[value='"+barang+"']").data('id');
                        console.log(id_barang);
                        console.log(barang);
                        $("#id_barang-"+i).val(id_barang);
                        text += `
                            <div class="flex justify-between mt-3">
                                <span>${barang}</span>
                                <span>(${jumlah_jual} ${satuan_jual})</span>
                            </div>`;

                        }
                    }
                    $('#barang-list').html(text);
            }
    </script>

</x-Layout.layout>