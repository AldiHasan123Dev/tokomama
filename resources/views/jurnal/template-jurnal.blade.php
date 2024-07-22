<x-Layout.layout>
    <x-jurnal.card-jurnal>
        <x-slot:tittle>Data Template Jurnal</x-slot:tittle>

        <div class="grid grid-cols-6 gap-4">
            <a href="{{ route('jurnal.template-jurnal.create') }}"><button class="col-span-1 col-end-4 btn btn-success w-40 self-end font-semibold text-white">Buat Template</button></a>
        </div>
        <hr>
        <div class="overflow-x-auto">
            <table class="table"    id="table-templateJurnal">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        <x-slot:script>
            <script>

            </script>
        </x-slot:script>
    </x-jurnal.card-jurnal>
</x-Layout.layout>