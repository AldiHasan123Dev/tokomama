<x-Layout.layout>
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
                <input type="text" class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white" id="kepada" name="kepada" list="coa_list" autocomplete="off" required />
                <datalist id="coa_list">
                    <option data-id="1" data-alamat="surabaya" data-kota="surabaya" value="galeh">galeh</option>
                    <option data-id="2" data-alamat="jugja" data-kota="surabaya" value="2"></option>
                    <option data-id="3" data-alamat="data" data-kota="surabaya" value="3"></option>
                    <option data-id="4" data-alamat="malang" data-kota="surabaya" value="4"></option>
                </datalist>
                <input type="text" class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white" id="kepada" name="kepada" list="coa_list" autocomplete="off" required />
                <datalist id="coa_list">
                    <option data-id="1" data-alamat="surabaya" data-kota="surabaya" value="galeh">galeh</option>
                    <option data-id="2" data-alamat="jugja" data-kota="surabaya" value="2"></option>
                    <option data-id="3" data-alamat="data" data-kota="surabaya" value="3"></option>
                    <option data-id="4" data-alamat="malang" data-kota="surabaya" value="4"></option>
                </datalist>
                <input type="text" class="input input-bordered w-full max-w-xs rounded-lg bg-transparent dark:text-white" id="kepada" name="kepada" list="coa_list" autocomplete="off" required />
                <datalist id="coa_list">
                    <option data-id="1" data-alamat="surabaya" data-kota="surabaya" value="galeh">galeh</option>
                    <option data-id="2" data-alamat="jugja" data-kota="surabaya" value="2"></option>
                    <option data-id="3" data-alamat="data" data-kota="surabaya" value="3"></option>
                    <option data-id="4" data-alamat="malang" data-kota="surabaya" value="4"></option>
                </datalist>
                <button id="tambah" class="btn btn-success font-semibold text-white">Tambah Baris</button>


            </form>
        </div>

        <x-slot:script>
            <script>
                
            </script>
        </x-slot:script>
    </x-jurnal.card-jurnal>
</x-Layout.layout>