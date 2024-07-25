<x-Layout.layout>
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
                                <option disabled selected></option>
                                <option value="JNL">JNL</option>
                                <option value="BBK">BBK</option>
                                <option value="BKK">BKK</option>
                                <option value="BBM">BBM</option>
                                <option value="BKM">BKM</option>
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
                            <th>Invoice</th>
                            <th>Nopol</th>
                            <th>Akun Debet</th>
                            <th>Akun Kredit</th>
                            <th>Keterangan</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" name="check" id="check">
                            </td>
                            <td>
                                <input type="text" class="input input-sm input-bordered w-full max-w-xs bg-transparent rounded-xl" name="invoice" id="invoice" />
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
                        </tr>
                    </tbody>
                </table>

                <h3 class="font-bold">TOTAL DEBET</h3>
                <h3 class="font-bold mb-5">TOTAL CREDIT</h3>

                <button class="btn bg-green-500 text-white w-5/12 ms-10">Simpan Jurnal</button>
                <button class="btn bg-orange-500 text-white w-5/12 float-end me-10">Simpan Tampungan</button>
            </form>
        </div>
    </x-keuangan.card-keuangan>

    <script>
        $(document).ready(function () {
            $('#nopol').select2();
            $('#akun_debet').select2();
            $('#akun_kredit').select2();
        });
    </script>
</x-Layout.layout>