<x-Layout.layout>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <x-jurnal.card-jurnal>
        <x-slot:tittle>Template Jurnal</x-slot:tittle>

        <div class="container mt-8">
            <form action="{{route('jurnal.template-jurnal.add')}}" method="POST" class="grid grid-cols-4 gap-3">
                @csrf
                <div class="col-span-4">
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                          <span class="label-text">Nama Template</span>
                        </div>
                        <input name="nama" type="text" placeholder="Nama Template Jurnal" class="input input-bordered w-full max-w-xs rounded-md" />
                      </label>
                </div>
                <h3 class="font-semibold">Akun Debit</h3>
                <h3 class="font-semibold">Akun Kredit</h3>
                <h3 class="font-semibold">Keterangan</h3>
                <hr class="col-span-4">
                <select name="coa_debit_id" class="select select-bordered w-full max-w-xs" id="akun_debet">
                    @foreach ($coa as $item)
                    <option disabled selected></option>
                    <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                    @endforeach
                </select>
                <select name="coa_kredit_id" class="select select-bordered w-full max-w-xs" id="akun_kredit">
                    @foreach ($coa as $item)
                    <option disabled selected></option>
                    <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                    @endforeach
                </select>
                <input type="text" placeholder="" class="input input-bordered w-full max-w-xs" name="keterangan" id="keterangan" />
                <button type="submit" id="tambah" class="btn bg-green-500 font-semibold text-white">Simpan</button>
            </form>
        </div>

    </x-jurnal.card-jurnal>

    <x-slot:script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script>
                $(document).ready(function () {
                    $('#akun_debet').select2();
                    $('#akun_kredit').select2();
                });
            </script>
        </x-slot:script>
</x-Layout.layout>