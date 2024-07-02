<x-Layout.layout>

    <dialog id="my_modal_1" class="modal">
      <div class="modal-box">
        <h3 class="text-lg font-bold">Hello!</h3>
        <p class="py-4">Press ESC key or click the button below to close</p>
        <div class="modal-action">
          <form method="dialog">
            <!-- if there is a button in form, it will close the modal -->
            <button class="btn">Close</button>
          </form>
        </div>
      </div>
    </dialog>

    <x-pajak.card>
        <x-slot:tittle>Buat Nomor Faktur</x-slot:tittle>
        <div class="grid grid-cols-3 gap-4">
            <label class="form-control w-96 max-w-xs">
                <div class="label">
                    <span class="label-text">Nomor awal faktur</span>
                </div>
                <input type="text" name="nomor" id="nomor-i" class="input input-bordered w-full max-w-xs rounded-md" />
            </label>
            <label class="form-control w-96 max-w-xs ">
                <div class="label">
                    <span class="label-text">Jumlah</span>
                </div>
                <input type="text" name="jumlah" id="jumlah-i" class="input input-bordered w-full max-w-xs rounded-md" />
                
            </label> 
            <div class="w-64 max-w xs">
                <div class="label">
                    <span class="label-text text-white">_</span>
                </div>
                <button class="btn btn-success text-white font-semibold" id="generate">Generate</button>
            </div>
        </div>
    </x-pajak.card>

    <x-pajak.card>
        <x-slot:tittle>Nomor Faktur Tersedia</x-slot:tittle>
          <button id="delete-nsfp-all" class="btn btn-error w-56 text-white font-semibold mb-3 self-end">Hapus Semua NSFP</button>
        <div class="overflow-x-auto">
            <table class="table" id="table-available">
              <!-- head -->
              <thead>
                <tr>
                    <th>ID</th>
                    <th>No.</th>
                    <th>NSFP</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          
    </x-pajak.card>

    <x-pajak.card>
        <x-slot:tittle>Faktur Pajak Invoice</x-slot:tittle>
        <div class="overflow-x-auto">
            <table class="table" id="table-done">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>NSFP</th>
                  <th>Inovice</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
    </x-pajak.card>


    <!-- Open the modal using ID.showModal() method -->
    <button class="btn" onclick="my_modal_1.showModal()">open modal</button>
    <x-slot name="script">
      <script>
        // table available invoice
          let table = $('#table-available').DataTable({
              ajax:{
                  url: "{{ route('nsfp.data') }}",
                  dataSrc: "data",
                  // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              },
              columns: [
                  { data: 'id', name: 'id', visible:false},
                  { data: 'DT_RowIndex', name: 'number'},
                  { data: 'nomor', name: 'nomor' },
                  { data: 'keterangan', name: 'keterangan' },
                  { data: 'aksi', name: 'aksi' }
              ]
          });

          //delete all nsfp
          $('#delete-nsfp-all').click(function(e) {
            if(confirm('Apakah anda yakin?')) {
              $.ajax({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: "{{ route('nsfp.delete-all') }}",
                success: function(response) {
                  alert('Data berhasil di hapus semua');
                  table.ajax.reload();
                }
              })
            }
          })

          // Generate nomor faktur
        $('#generate').click(function(e) {
          // var data = $('#jumlah-i').val();
          // console.log(data);
          if(confirm('are you sure?')) {
            $.ajax({
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: "POST",
              url: "{{ route('api.nsfp.generate') }}",
              data: {
                nomor:$('#nomor-i').val(),
                jumlah:$('#jumlah-i').val()
              },
              success: function(response) {
                table.ajax.reload();
              }
            })
          }
        })


        // table invoice with nomor faktur
        let tableDone = $(`#table-done`).DataTable({
          ajax: {
            url: "{{ route('nsfp.done') }}",
            dataSrc: "data",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          },
          columns: [
            
            { data: 'DT_RowIndex', name: 'number'},
            { data: 'id', name: 'id', visible:false},
            { data: 'nomor', name: 'nomor'},
            { data: 'invoice', name: 'invoice'},
            { data: 'keterangan', name: 'keterangan'}
          ]
        });

        function getDataNSFP(id, nomor){
          alert(nomor);
          my_modal_1.showModal();
        }
      </script>
    </x-slot>
</x-Layout.layout>