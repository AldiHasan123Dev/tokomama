<x-Layout.layout>
    <x-jurnal.card-jurnal>
        <x-slot:tittle>Parameter</x-slot:tittle>
        <div class="grid grid-cols-3 ">
            <p class="bg-gray-500 text-white p-1 text-center">[1] Customer</p>
            <p class="bg-gray-500 text-white p-1 text-center">[2] Supplier</p>
            <p class="bg-gray-500 text-white p-1 text-center">[3] Barang</p>
        </div>
    </x-jurnal.card-jurnal>
    <x-jurnal.card-jurnal>
        <x-slot:tittle>Edit Jurnal</x-slot:tittle>
        <div class="overflow-x-auto">
            <form action="">
                <input type="date" class="mb-8 rounded-md" value="Cari">
                <button type="submit" class="btn bg-green-500 font-semibold text-white">Simpan Tanggal</button>
            </form>
            

            <table id="table-editJurnal" class="cell-border hover display nowrap" >
              <thead>
                <tr>
                  <th>#</th>
                  <th>ID</th>
                  <th>Nomor Jurnal</th>
                  <th>Tanggal</th>
                  <th>Debit</th>
                  <th>Kredit</th>
                  <th>Keterangan</th>
                  <th>Invoice</th>
                  <th>Invoice External</th>
                  <th>Nopol</th>
                  <th>Tipe</th>
                  <th>Akun</th>
                  <th>Nomor Akun</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
    </x-jurnal.card-jurnal>

    <x-slot:script>
        <script src="https://cdn.datatables.net/2.1.0/js/dataTables.tailwindcss.js"></script>
        <script>
            let table = $(`#table-editJurnal`).DataTable({
                ajax: {
                    url: "",
                    dataSrc: "data"
                },
                search: {
                    search: 2024 
                }
                
            });

        </script>
    </x-slot:script>
</x-Layout.layout>