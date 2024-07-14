<x-Layout.layout>
  <div id="modal_user"></div>

    <x-master.card-master>
        <x-slot:button>
          <dialog id="my_modal_6" class="modal">
            <div class="modal-box  w-11/12 max-w-2xl pl-10 py-9 ">
            <form method="dialog">
                  <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
              </form>
              <h3 class="text-lg font-bold">Tambah User</h3>
              <form action="{{route('user.store')}}" method="post">
                @csrf
                <label class="input border flex items-center gap-2 mt-3">
                  Role
                  <select name="role_id" class="select" required>
                    <option value="">Pilih Role</option>
                    @foreach ($roles as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                  </select>
                </label>
                <label class="input border flex items-center gap-2 mt-4">
                  Nama User :
                  <input type="text" name="nama_user" class="border-none" />
                </label>
                <label class="input border flex items-center gap-2 mt-4">
                  Email :
                  <input type="text" name="email" class="border-none" />
                </label>
                <label class="input border flex items-center gap-2 mt-4">
                  Telp :
                  <input type="text" name="telp" class="border-none" />
                </label>
                <label class="input border flex items-center gap-2 mt-4">
                  Password :
                  <input type="password" name="password" class="border-none" />
                </label>
                <label class="input border flex items-center gap-2 mt-4">
                  Alamat :
                  <input type="alamat" name="alamat" class="border-none" />
                </label>
                <button type="submit" class="btn bg-green-400 text-white font-semibold w-72 mt-4">Simpan</button>
              </form>
            </div>
          </dialog>
          <button class="btn btn-success p-3 font-semibold w-40 text-white" onclick="my_modal_6.showModal();">Tambah User +</button>
        </x-slot:button>
        <x-slot:tittle>Data User and Role</x-slot:tittle>
        <div class="overflow-x-auto">
            <table class="table" id="table-user">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Role</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Telp</th>
                  <th>Alamat</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
    </x-master.card-master>

    <x-slot:script>
        <script>
            let table = $('#table-user').DataTable({
                ajax: {
                url: "{{route('master.user.data')}}",
                method: 'get',
                data:{
                    _token: "{{csrf_token()}}"
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'number'},
                { data: 'name_role', name: 'Nama Role' },
                { data: 'name_user', name: 'Nama User' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'address', name: 'adress' },
                { data: 'aksi', name: 'aksi' },
                { data: 'id_user', name: 'id', visible:false},
                
            ]
          })

          $('#addUser').on('click', function() {
            $('#modal_user').html(`<dialog id="my_modal_6" class="modal">
              <div class="modal-box  w-11/12 max-w-2xl pl-10 py-9 ">
              <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <h3 class="text-lg font-bold">Tambah User</h3>
                <form action="{{route('user.store')}}" method="post">
                  @csrf
                  <label class="input border flex items-center gap-2 mt-3">
                    Role
                    <select name="role_id" class="select">
                    
                    </select>
                  </label>
                  <label class="input border flex items-center gap-2 mt-4">
                    Nama User :
                    <input type="text" name="nama_user" class="border-none" />
                  </label>
                  <label class="input border flex items-center gap-2 mt-4">
                    Email :
                    <input type="text" name="email" class="border-none" />
                  </label>
                  <label class="input border flex items-center gap-2 mt-4">
                    Telp :
                    <input type="text" name="telp" class="border-none" />
                  </label>
                  <label class="input border flex items-center gap-2 mt-4">
                    Password :
                    <input type="password" name="password" class="border-none" />
                  </label>
                  <label class="input border flex items-center gap-2 mt-4">
                    Alamat :
                    <input type="alamat" name="alamat" class="border-none" />
                  </label>
                  <button type="submit" class="btn bg-green-400 text-white font-semibold w-72 mt-4">Simpan</button>
                </form>
              </div>
            </dialog>`);
            my_modal_6.showModal();
          });

          function getData(id, address) {
            console.log(id);
          }
        </script>
    </x-slot:script>
</x-Layout.layout>