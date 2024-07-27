<x-Layout.layout>
    <style>
        #param {
            border: 1px solid black;
            border-collapse: collapse;
        }

        #param th{
            border: 1px solid black;
            border-collapse: collapse;
        }
        
        #param td{
            border: 1px solid black;
            border-collapse: collapse;
        }

    </style>
    <x-keuangan.card-keuangan>
    <x-slot:tittle>Params</x-slot:tittle>
    <table border="1" id="param">
        <thead>
            <th>Customer [1]</th>
            <th>Supplier [2]</th>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" name="param1" id="param1"></td>
                <td><input type="text" name="param2" id="param2"></td>
            </tr>
        </tbody>
    </table>
    </x-keuangan.card-keuangan>

    <x-keuangan.card-keuangan>
        <x-slot:tittle>Form Jurnal Manual</x-slot:tittle>
        <div class="overflow-x-auto">
            <form action="{{ route('jurnal.coa') }}" method="post">
                @csrf
                <div class="grid grid-cols-2 justify-items-start">
                    <div class="w-full">
                        <label class="form-control w-full max-w-xs mb-5">
                            <div class="label">
                                <span class="label-text">Template Jurnal</span>
                            </div>
                            <select name="tipe" id="tipe" class="select select-bordered w-full max-w-xs">
                                <option disabled selected></option>
                                @foreach ($templates as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="self-center w-fit">
                        <button class="btn bg-green-500 text-white">Terapkan</button>
                        <button class="btn bg-orange-500 text-white">Reset</button>
                    </div>
                </div>

                <div class="grid grid-cols-3 justify-items-start">
                    <div class="w-full">
                        <label class="form-control w-full max-w-xs mb-5">
                            <div class="label">
                                <span class="label-text">Tipe Jurnal</span>
                            </div>
                            <select name="tipe" id="tipe" class="select select-bordered w-full max-w-xs">
                                <option selected></option>
                                <option value="{{ $tipe_jurnal_jnl->nama_tipe }}">{{ $tipe_jurnal_jnl->nama_tipe }} - {{ $tipe_jurnal_jnl->no + 1 }}/{{ $tipe_jurnal_jnl->tipe_jurnal }}-SB/{{ date('y') }}</option>
                                <option value="{{ $tipe_jurnal_bkk->nama_tipe }}">{{ $tipe_jurnal_bkk->nama_tipe }} - {{ $tipe_jurnal_bkk->no + 1 }}/{{ $tipe_jurnal_bkk->tipe_jurnal }}-SB/{{ date('y') }}</option>
                                <option value="{{ $tipe_jurnal_bkm->nama_tipe }}">{{ $tipe_jurnal_bkm->nama_tipe }} - {{ $tipe_jurnal_bkm->no + 1 }}/{{ $tipe_jurnal_bkm->tipe_jurnal }}-SB/{{ date('y') }}</option>
                                <option value="{{ $tipe_jurnal_bbk->nama_tipe }}">{{ $tipe_jurnal_bbk->nama_tipe }} - {{ $tipe_jurnal_bbk->no + 1 }}/{{ $tipe_jurnal_bbk->tipe_jurnal }}-SB/{{ date('y') }}</option>
                                <option value="{{ $tipe_jurnal_bbm->nama_tipe }}">{{ $tipe_jurnal_bbm->nama_tipe }} - {{ $tipe_jurnal_bbm->no + 1 }}/{{ $tipe_jurnal_bbm->tipe_jurnal }}-SB/{{ date('y') }}</option>
                            </select>
                        </label>
                    </div>
                
                    <div class="w-full">
                        <label class="form-control w-full max-w-xs mb-5">
                            <div class="label">
                                <span class="label-text">Tanggal Jurnal</span>
                            </div>
                            <input type="date" class="input input-sm input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white" id="tanggal_jurnal" name="tanggal_jurnal" autocomplete="off" value="{{ date('Y-m-d') }}" />
                        </label>
                    </div>

                    <div class="self-center w-fit">
                        <button class="btn bg-blue-500 text-white">Tambah Baris Template</button>
                        <button class="btn bg-blue-400 text-white">Tambah Baris</button>
                    </div>
                </div>
                <table class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID Job/Seal</th>
                            <th>Nopol</th>
                            <th>Akun Debet</th>
                            <th>Akun Kredit</th>
                            <th>Keterangan</th>
                            <th>Nominal</th>
                            <th>Invoice External</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" name="check" id="check" checked>
                            </td>
                            <td>
                                <select class="select select-bordered w-full max-w-xs" name="seal_job" id="seal_job" id="seal_job">
                                    <option selected></option>
                                    @foreach ($surat_jalan as $item)
                                        <option value="{{ $item->no_job }}">{{ $item->no_seal }}/{{ $item->no_job }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="select select-bordered w-full max-w-xs" name="nopol" id="nopol">
                                    @foreach ($nopol as $item)
                                    <option disabled selected></option>
                                        <option value="{{ $item->nopol }}">{{ $item->nopol }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="select select-bordered w-full max-w-xs" name="akun_debet" id="akun_debet">
                                    @foreach ($coa as $item)
                                    <option disabled selected></option>
                                    <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="select select-bordered w-full max-w-xs" name="akun_kredit" id="akun_kredit">
                                    @foreach ($coa as $item)
                                        <option disabled selected></option>
                                        <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" class="input input-sm input-bordered w-full max-w-xs bg-transparent rounded-xl" name="keterangan" id="keterangan" />
                            </td>
                            <td>
                                <input type="number" class="input input-sm input-bordered w-full max-w-xs bg-transparent rounded-xl text-white" name="nominal" id="nominal" />
                            </td>
                            <td>
                                <input type="text" class="input input-sm input-bordered w-full max-w-xs bg-transparent rounded-xl">
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h3 class="font-bold">TOTAL DEBET</h3>
                <h3 class="font-bold mb-5">TOTAL CREDIT</h3>

                <button class="btn bg-green-500 text-white w-5/12 ms-10">Simpan Jurnal</button>
            </form>
        </div>
    </x-keuangan.card-keuangan>

    <script>
        $(document).ready(function () {
            $('.select').select2();
        });

        $('#seal_job').on('change', function() {
            $.ajax
            ({
                method: 'post',
                url: "{{ route('jurnal.sj.wherejob') }}",
                data: { job: $(this).val(),},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) 
                {
                    response.forEach(item => {
                        $(`#param1`).val(item.customer.nama)
                    })
                },
                error: function(xhr, status, error) 
                {
                    console.log('Error:', error);
                    console.log('Status:', status);
                    console.dir(xhr);
                }
            })
        })
    </script>
</x-Layout.layout>