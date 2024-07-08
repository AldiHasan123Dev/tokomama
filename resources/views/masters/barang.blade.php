<x-Layout.layout>

    <div id="dialog"></div>

    <x-master.card-master>
        <x-slot:tittle>Data Barang</x-slot:tittle>
        <div class="overflow-x-auto">
            <table class="table" id="table-barang">
              <thead>
                <tr>
                    <th>#</th>
                    <th>Kode Objek</th>
                    <th>Nama</th>
                    <th>Value</th>
                    <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
    </x-master.card-master>

    <x-master.card-master>
        <x-slot:tittle>Menambah Data Barang</x-slot:tittle>
        <form action="{{route('master.barang.add')}}" method="post" class="grid grid-cols-3 gap-5">
          @csrf
          <label class="form-control w-full max-w-xs col-start-1">
            <div class="label">
              <span class="label-text">Kode Objek</span>
            </div>
            <input type="text" placeholder="Kode Barang" name="kode_objek" class="input input-bordered w-full max-w-xs rounded-md" />
          </label>
          <label class="form-control w-full max-w-xs col-start-2">
            <div class="label">
              <span class="label-text">Nama</span>
            </div>
            <input type="text" placeholder="Nama Barang" name="nama" class="input input-bordered w-full max-w-xs rounded-md" />
          </label>
          <label class="form-control w-full max-w-xs col-start-2">
            <div class="label">
              <span class="label-text">Value</span>
            </div>
            <input type="number" placeholder="10" name="value" class="input input-bordered w-full max-w-xs rounded-md" />
          </label>
          <div class="col-start-3 mt-9">
            <button type="submit" class="btn text-semibold text-white bg-green-500">Simpan Data Customer</button>
          </div>
          
        </form>
    </x-master.card-master>

    <x-slot:script>
        <script>
            let table = $('#table-barang').DataTable({
            ajax: {
              url: "{{route('master.barang.list')}}",
              
              data:{
                _token: "{{csrf_token()}}"
              }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'number'},
                { data: 'kode_objek', name: 'kode objek' },
                { data: 'nama', name: 'nama' },
                { data: 'value', name: 'value' },
                { data: 'aksi', name: 'aksi' },
                { data: 'id', name: 'id', visible:false},
            ]
          })

          function getData(id, kode_objek, nama, value) {
            $('#dialog').html(`<dialog id="my_modal_6" class="modal">
              <div class="modal-box  w-11/12 max-w-2xl pl-10 py-9 ">
              <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <h3 class="text-lg font-bold">Edit Data</h3>
                <form action="{{route('master.barang.edit')}}" method="post">
                  @csrf
                  <input type="hidden" name="id" value="${id}" class="border-none" />
                  <label class="input border flex items-center gap-2 mt-3">
                    Kode Objek :
                    <input type="text" name="kode_objek" value="${kode_objek}" class="border-none" />
                  </label>
                  <label class="input border flex items-center gap-2 mt-4">
                    Nama :
                    <input type="text" name="nama" value="${nama}" class="border-none" />
                  </label>
                  <label class="input border flex items-center gap-2 mt-4">
                    Value :
                    <input type="number" name="value" value="${value}" class="border-none" />
                  </label>
                  <button type="submit" class="btn bg-green-400 text-white font-semibold w-72 mt-4">Edit</button>
                </form>
              </div>
            </dialog>`);
            my_modal_6.showModal();
          }

          function deleteData(id) {
            if (confirm('Apakah anda ingin menghapus data ini?')) 
            {
                $.ajax
                ({
                    method: 'post',
                    url: "{{ route('master.barang.delete') }}",
                    data: {id: id},
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(response) 
                    {
                        table.ajax.reload();
                    },
                    error: function(xhr, status, error) 
                    {
                        console.log('Error:', error);
                        console.log('Status:', status);
                        console.dir(xhr);
                    }
                })
            }
          }
        </script>
    </x-slot:script>
</x-Layout.layout>