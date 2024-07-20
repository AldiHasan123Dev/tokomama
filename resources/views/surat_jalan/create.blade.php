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

        #table-barang td {
            padding: 0px;
        }
    </style>
    <form action="{{ route('surat-jalan.store') }}" method="post" class="grid grid-cols-3 gap-3" id="reset">
        <div class="card w-fit bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Form Surat Jalan</h2>
                <div>
                    @csrf
                    {{-- <div>
                        <label class="form-control w-full max-w-xs">
                            <div class="label">
                                <span class="label-text">No. Surat</span>
                            </div>
                            <input type="text"
                                class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                id="nomor_surat" name="nomor_surat" readonly />
                        </label>
                    </div> --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <input type="hidden" name="id_ekspedisi" id="id_ekspedisi">
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Ekspedisi <span class="text-red-500">*</span></span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="kepada" name="kepada" list="ekspedisi_list" required />
                                <datalist id="ekspedisi_list">
                                    @foreach ($ekspedisi as $item)
                                    <option data-id="{{$item->id}}" data-alamat="{{$item->alamat}}"
                                        data-kota="{{ $item->kota }}" value="{{ $item->nama }}">{{ $item->nama }}
                                    </option>
                                    @endforeach
                                </datalist>
                            </label>
                        </div>
                        {{-- <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Alamat Ekspedisi <span class="text-red-500">*</span></span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="alamat_ekspedisi" name="alamat_ekspedisi" required />
                            </label>
                        </div> --}}
                        <input type="hidden" name="kota_ekspedisi" id="kota_ekspedisi">
                        <!-- <div>
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
                                    id="satuan" name="satuan" placeholder="(ZAK, BALL, KARTON, DLL)" />
                            </label>
                        </div> -->
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Nama Kapal <span class="text-red-500">*</span></span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="nama_kapal" name="nama_kapal" required />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">No. Cont <span class="text-red-500">*</span></span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="no_cont" name="no_cont" required />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">No. Seal <span class="text-red-500">*</span></span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="no_seal" name="no_seal" required />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">No. Pol <span class="text-red-500">*</span></span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="no_pol" name="no_pol" list="no_pol_list" />
                                <input type="hidden" name="id_nopol" id="id_nopol">
                                <datalist id="no_pol_list">
                                    @foreach ($nopol as $np)
                                    <option data-id="{{$np->id}}}" value="{{ $np->nopol }}">{{ $np->nopol }}</option>
                                    @endforeach
                                </datalist>
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">No. PO <span class="text-red-500">*</span></span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="no_po" name="no_po" value="-" required />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">No. Job <span class="text-red-500">*</span></span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="no_job" name="no_job" required />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Tujuan/NamaCustomer <span class="text-red-500">*</span></span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="tujuan" name="tujuan" list="customer_list" required />
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
                                    <span class="label-text">Kota Pengirim <span class="text-red-500">*</span></span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="kota_pengirim" name="kota_pengirim" value="Surabaya" required />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Nama Pengirim <span class="text-red-500">*</span></span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="nama_pengirim" name="nama_pengirim" value="FIRDA" required />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Nama Penerima <span class="text-red-500">*</span></span>
                                </div>
                                <input type="text"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="nama_penerima" name="nama_penerima" value="IFAN" required />
                            </label>
                        </div>
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Tanggal Surat Jalan <span
                                            class="text-red-500">*</span></span>
                                </div>
                                <input type="date"
                                    class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white"
                                    id="tgl_sj" name="tgl_sj" value="{{ date('Y-m-d') }}" required />
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
                                    {{-- <th>Harsat Beli</th> --}}
                                    <th>Jumlah Beli</th>
                                    <th>Satuan Beli</th>
                                    {{-- <th>Harsat Jual</th> --}}
                                    <th>Jumlah Jual</th>
                                    <th>Satuan Jual</th>
                                    <th>Supplier</th>
                                    <th>Keterangan</th>
                                    {{-- <th>Profit</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i < 5; $i++) <input type="hidden" name="id_barang[]" id="id_barang-{{ $i }}" />
                                <input type="hidden" name="nama_satuan[]" id="nama_satuan-{{ $i }}" />
                                <tr>
                                    <td class="text-center">{{ $i }}</td>
                                    <td>
                                        <input type="text" onchange="inputBarang()" name="barang[]" id="barang-{{ $i }}"
                                            class="form-control" list="barang_list">
                                    </td>
                                    <td>
                                        <input type="number" style="width:120px" onchange="inputBarang()"
                                            name="jumlah_beli[]" id="jumlah_beli-{{ $i }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" style="width:120px" onchange="inputBarang()" name="satuan_beli[]" id="satuan_beli-{{ $i }}" class="form-control" placeholder="(ZAK, BALL, KARTON, DLL)" list="satuan_beli_list" autocomplete="off">
                                    </td>
                                    <td>
                                        <input type="number" style="width:120px" onchange="inputBarang()"
                                            name="jumlah_jual[]" id="jumlah_jual-{{ $i }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" style="width:120px" onchange="inputBarang()"
                                            name="satuan_jual[]" id="satuan_jual-{{ $i }}" class="form-control"
                                            placeholder="(ZAK, BALL, KARTON, DLL)" list="satuan_jual_list" autocomplete="off">
                                    </td>
                                    <td>
                                        <input type="text" style="width:120px" onchange="inputBarang()" name="supplier[]" id="supplier-{{ $i }}"
                                            class="form-control" list="supplier_list" autocomplete="off">
                                    </td>
                                    <td>
                                        <input type="text" style="width:120px" onchange="inputBarang()" name="keterangan[]" id="keterangan-{{ $i }}"
                                            class="form-control">
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                        <datalist id="barang_list">
                            @foreach ($barang as $mb)
                            <option data-id="{{$mb->id}}" data-value="{{ $mb->value }}" data-satuan="{{ $mb->nama_satuan }}" value="{{ $mb->nama }}">{{ $mb->nama }} {{ $mb->nama_satuan }}</option>
                            @endforeach
                        </datalist>
                        <datalist id="satuan_beli_list">
                            @foreach ($satuan as $st)
                            <option data-id="{{$st->id}}" value="{{ $st->nama_satuan }}">{{ $st->nama_satuan }}</option>
                            @endforeach
                        </datalist>
                        <datalist id="satuan_jual_list">
                            @foreach ($satuan as $st)
                            <option data-id="{{$st->id}}" value="{{ $st->nama_satuan }}">{{ $st->nama_satuan }}</option>
                            @endforeach
                        </datalist>
                        <datalist id="supplier_list">
                            @foreach ($supplier as $sp)
                            <option data-id="{{$sp->id}}" value="{{ $sp->nama }}">{{ $sp->nama }}</option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 justify-items-stretch">
                <div class="grid grid-cols-3">
                    <div>
                        <img src="{{ asset('/assets/img/logo_sb.svg') }}" alt="Logo SB" class="w-20 mx-auto">
                    </div>
                    <div class="font-bold font-serif col-span-2">
                        <p>CV.SARANA BAHAGIA</p>
                        <p>JL.Kalianak 55 BLOK G, SURABAYA</p>
                        <p>Telp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;031-123456
                        </p>
                    </div>
                </div>
                <div class="justify-self-end font-bold font-serif">
                    <p>Kepada: </p>
                    <p id="txt_kepada"></p>
                    <p id="alamat_ekspedisi_txt"></p>
                    <p id="kota_ekspedisi_txt"></p>
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
                            <th class="text-center border border-black" rowspan="7"
                                style="vertical-align: top; padding-top: 20px; line-height: 1.5rem">
                                @for($i = 1; $i < 5; $i++) <span id="txt_nomor{{$i}}"></span><br>
                                    @endfor
                            </th>
                            <td class="text-center border border-black" rowspan="7"
                                style="vertical-align: top; padding-top: 20px; line-height: 1.5rem">
                                @for($i = 1; $i < 5; $i++) <span id="txt_jumlah{{ $i }}"></span><br>
                                    @endfor
                            </td>
                            <td class="text-center border border-black" rowspan="7"
                                style="vertical-align: top; padding-top: 20px; line-height: 1.5rem">
                                @for($i = 1; $i < 5; $i++) <span id="txt_satuan{{ $i }}"></span><br>
                                    @endfor
                            </td>
                            <td class="border border-black" id="barang-list">

                            </td>
                            <td class="text-center border border-black" rowspan="7"><span id="txt_tujuan"></td>
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
                        <tr>
                            <td class="border border-black py-1">
                                No. PO: <span id="txt_no_po">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="mb-5">Note: &nbsp; Barang yang diterima dalam keadaan baik dan lengkap</p>
                <div class="grid grid-cols-2 justify-items-stretch mx-20 mb-3">
                    <div class="justify-self-start"></div>
                    <div class="justify-self-end">
                        <p class="text-center"><span id="txt_kota_pengirim"></span>, <span id="txt_tgl_sj">{{ date('d F
                                Y') }}</span></p>
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
        $('#kepada').on('input', function () {
            var inputValue = $(this).val();
            var id = $("#ekspedisi_list option[value='" + inputValue + "']").data('id');
            var alamat = $("#ekspedisi_list option[value='" + inputValue + "']").data('alamat');
            var kota = $('#ekspedisi_list option[value="' + inputValue + '"]').data('kota');
            $('#txt_kepada').text(inputValue);
            $('#alamat_ekspedisi_txt').text(alamat);
            $('#kota_ekspedisi_txt').text(kota);
            $('#alamat_ekspedisi').val(alamat);
            $('#id_ekspedisi').val(id);
        });

        // $('#kepada').on('input', function () {
        //     var inputValue = $(this).val();
        //     $('#txt_kepada').text(inputValue);
        // });

        $('#no_po').on('input', function () {
            var inputValue = $(this).val();
            $('#txt_no_po').text(inputValue);
        });

        $('#jenis_barang').on('input', function () {
            var inputValue = $(this).val();
            $('#txt_jenis_barang').text(inputValue);
            var text = $("#jenis_barang_list option[value='" + inputValue + "']").data('text');
            $('#txt_jenis_barang').text(inputValue);
            $('#txt_total').text($('#jumlah').val() * $('#jumlah_satuan').val() * text);
            $('#total').val($('#jumlah').val() * $('#jumlah_satuan').val() * text);

        });

        $('#nama_kapal').on('input', function () {
            var inputValue = $(this).val();
            $('#txt_nama_kapal').text(inputValue);
        });

        $('#no_cont').on('input', function () {
            var inputValue = $(this).val();
            $('#txt_no_cont').text(inputValue);
        });

        $('#no_seal').on('input', function () {
            var inputValue = $(this).val();
            $('#txt_no_seal').text(inputValue);
        });

        $('#no_pol').on('input', function () {
            var inputValue = $(this).val();
            $('#txt_no_pol').text(inputValue);
        });

        $('#no_job').on('input', function () {
            var inputValue = $(this).val();
            $('#txt_no_job').text(inputValue);
        });

        $('#tujuan').on('input', function () {
            var inputValue = $(this).val();
            var id = $("#customer_list option[value='" + inputValue + "']").data('id');
            $('#id_customer').val(id);
            $('#txt_tujuan').text(inputValue);
        });

        //$('#harga_jual').on('click', function () {
        //    var harga_jual = $('#harga_jual').val();
        //    var harga_beli = $('#harga_beli').val();
        //    var total = $('#txt_total').text();
        //    $('#profit').val((harga_jual * total) - (harga_beli * total));
        //});

        //jquery ready function
        $(document).ready(function () {
            $('#txt_nomor_surat').text($('#nomor_surat').val());
            $('#txt_kota_pengirim').text($('#kota_pengirim').val());
            $('#txt_nama_pengirim').text($('#nama_pengirim').val());
            $('#txt_nama_penerima').text($('#nama_penerima').val());
            $('#txt_no_po').text($('#no_po').val());
        });

        $("#kota_pengirim").on({
            input: function () {
                var inputValue = $(this).val();
                $('#txt_kota_pengirim').text(inputValue);
            },
            click: function () {
                var inputValue = $(this).val();
                $('#txt_kota_pengirim').text(inputValue);
            }
        });

        $("#tgl_sj").on({
            input: function () {
            var inputValue = $(this).val();
            let newData = new Date(inputValue).toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'short',
                day: '2-digit'
            });
            $('#txt_tgl_sj').text(newData);
        },
            click: function () {
            var inputValue = $(this).val();
            let newData = new Date(inputValue).toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'short',
            day: '2-digit'
            });
            $('#txt_tgl_sj').text(newData);
        }
        });

        $("#nama_pengirim").on({
            input: function () {
                var inputValue = $(this).val();
                $('#txt_nama_pengirim').text(inputValue);
            },
            click: function () {
                var inputValue = $(this).val();
                $('#txt_nama_pengirim').text(inputValue);
            }
        });

        $("#nama_penerima").on({
            input: function () {
                var inputValue = $(this).val();
                $('#txt_nama_penerima').text(inputValue);
            },
            click: function () {
                var inputValue = $(this).val();
                $('#txt_nama_penerima').text(inputValue);
            }
        });

        function inputBarang() {
            for(let i = 1; i < 5; i++) {
                const jumlah_beli = $('#jumlah_beli-' + i).val();
                const satuan_beli = $('#satuan_beli-' + i).val();
                const jumlah_jual =  $('#jumlah_jual-' + i).val(jumlah_beli);
                const satuan_jual = $('#satuan_jual-' + i).val(satuan_beli);
            }
            let text = '';
            for (let i = 1; i < 5; i++) {
                const barang = $('#barang-' + i).val();
                const jumlah_beli = $('#jumlah_beli-' + i).val();
                const satuan_beli = $('#satuan_beli-' + i).val();
                // const harga_beli = $('#harga_beli-' + i).val();
                const jumlah_jual =  $('#jumlah_jual-' + i).val();
                const satuan_jual = $('#satuan_jual-' + i).val();
                const keterangan = $('#keterangan-' + i).val();
                // const harga_jual = $('#harga_jual-' + i).val();

                if (barang != '' && typeof (barang) != undefined) {
                    var id_barang = $("#barang_list option[value='" + barang + "']").data('id');
                    var value_barang = $("#barang_list option[value='" + barang + "']").data('value');
                    var nama_satuan = $("#barang_list option[value='" + barang + "']").data('satuan');
                    $("#id_barang-" + i).val(id_barang);
                    if (satuan_jual.includes(nama_satuan)){
                        var total_jumlah = parseInt(jumlah_jual);
                    } else {
                        var total_jumlah = parseFloat(value_barang) * parseInt(jumlah_jual);
                    }
                    var txt_total = '';
                    // if(barang.includes("@")){
                        if(satuan_jual.includes(nama_satuan)) {
                            txt_total += `<p>${keterangan!=''?' = '+keterangan:''}</p>`;
                        } else {
                            txt_total += `<p>(Total: ${total_jumlah} ${nama_satuan} ${keterangan!=''?' = '+keterangan:''})</p>`;
                        }
                    // }
                    text += `
                            <div class="flex justify-between mt-3">
                                <span>${barang}</span>
                                <span>(${jumlah_jual} ${satuan_jual})</span>
                            </div>
                            ${txt_total}
                            `;
                            $('#txt_nomor' + i).html(i);

                            // var test = $('#profit-' + i).val(jumlah_jual * harga_jual - jumlah_beli * harga_beli);
                }

                $('#jumlah_beli-' + i).on('input', function () {
                    var inputValue = $(this).val();
                    $('#txt_jumlah' + i).html(inputValue);
                });

                $('#satuan_beli-' + i).on('input', function () {
                    var inputValue = $(this).val();
                    $('#txt_satuan' + i).html(inputValue);
                });

            }
            $('#barang-list').html(text);
        }
    </script>

</x-Layout.layout>
