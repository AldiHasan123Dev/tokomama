<x-Layout.layout>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <x-jurnal.card-jurnal>
        <x-slot:tittle>Template Jurnal</x-slot:tittle>

        <div class="p-5">
            <h4>PARAM</h4>
            <div class="grid grid-cols-6 gap-2">
                <p class="bg-slate-200 p-1 text-center w-28 rounded-sm">[1] ID JOB</p>
                <p class="bg-slate-200 p-1 text-center w-28 rounded-sm">[2] Cont (XPDC)</p>
                <p class="bg-slate-200 p-1 text-center w-28 rounded-sm">[3] Seal (XPDC)</p>
                <p class="bg-slate-200 p-1 text-center w-28 rounded-sm">[4] Kapal (XPDC)</p>
                <p class="bg-slate-200 p-1 text-center w-28 rounded-sm">[4] Kapal (XPDC)</p>
                <p class="bg-slate-200 p-1 text-center w-28 rounded-sm">[5] Voyage (XPDC)</p>
                <p class="bg-slate-200 p-1 text-center w-28 rounded-sm">[6] Shipment (XPDC)</p>
                <p class="bg-slate-200 p-1 text-center w-28 rounded-sm">[7] Pembayar (XPDC)</p>
                <p class="bg-slate-200 p-1 text-center w-28 rounded-sm">[8] Customer (TRUCKING)</p>
                <p class="bg-slate-200 p-1 text-center w-28 rounded-sm">[9] Shipment (TRUCKING)</p>
                <p class="bg-slate-200 p-1 text-center w-28 rounded-sm">[10] Tujuan (TRUCKING)</p>
            </div>
        </div>

        <hr>

        <div class="container mt-8">
            <form action="" method="POST" class="grid grid-cols-4 gap-3">
                @csrf
                <div class="col-span-4">
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                          <span class="label-text">Nama Template</span>
                        </div>
                        <input type="text" placeholder="Nama Template Jurnal" class="input input-bordered w-full max-w-xs rounded-md" />
                      </label>
                </div>
                <h3 class="font-semibold">Akun Debit</h3>
                <h3 class="font-semibold">Akun Kredit</h3>
                <h3 class="font-semibold">Keterangan</h3>
                <hr class="col-span-4">
                <select class="select select-bordered w-full max-w-xs" name="akun_debet" id="akun_debet">
                    @foreach ($coa as $item)
                    <option disabled selected></option>
                    <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                    @endforeach
                </select>
                <select class="select select-bordered w-full max-w-xs" name="akun_kredit" id="akun_kredit">
                    @foreach ($coa as $item)
                    <option disabled selected></option>
                    <option value="{{ $item->id }}">{{ $item->no_akun }} - {{ $item->nama_akun }}</option>
                    @endforeach
                </select>
                <input type="text" placeholder="" class="input input-bordered w-full max-w-xs" name="keterangan" id="keterangan" />
                <button id="tambah" class="btn btn-success font-semibold text-white">Tambah Baris</button>


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