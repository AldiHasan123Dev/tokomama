<x-Layout.layout>

    <x-pajak.card>
        <x-slot:tittle>Buat Nomor Faktur</x-slot:tittle>
        <form action="" class="grid grid-cols-3 gap-4" method="post">
            <label class="form-control w-96 max-w-xs">
                <div class="label">
                    <span class="label-text">Nomor awal faktur</span>
                </div>
                <input type="text" name="nofaktur" class="input input-bordered w-full max-w-xs rounded-md" />
            </label>
            <label class="form-control w-96 max-w-xs ">
                <div class="label">
                    <span class="label-text">Jumlah</span>
                </div>
                <input type="text" name="jumalh" class="input input-bordered w-full max-w-xs rounded-md" />
                
            </label> 
            <div class="w-64 max-w xs">
                <div class="label">
                    <span class="label-text text-white">_</span>
                </div>
                <button class="btn btn-success text-white font-semibold">Success</button>
            </div>
        </form>
    </x-pajak.card>

    <x-pajak.card>
        <x-slot:tittle>Nomor Faktur Tersedia</x-slot:tittle>
        <button class="btn btn-error w-56 self-end text-white font-semibold mb-3">Hapus Semua NSFP</button>
        <div class="action w-full">
            <form action="" class="grid grid-cols-2 justify-between">
                <select class="select select-bordered max-w-20">
                    <option disabled selected>10</option>
                    <option>30</option>
                    <option>60</option>
                </select>
                <label class="input input-bordered flex items-center ml-40">
                    <input type="text" class="grow border-none" placeholder="Search" />
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70"><path fill-rule="evenodd" d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z" clip-rule="evenodd" /></svg>
                  </label>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="table">
              <!-- head -->
              <thead>
                <tr>
                  <th>No.</th>
                  <th>NSFP</th>
                  <th>Keterangan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <!-- row 1 -->
                <tr>
                  <th>1</th>
                  <td>Cy Ganderton</td>
                  <td>Quality Control Specialist</td>
                  <td><i class="fa-solid fa-trash text-red-600"></i> &nbsp; | &nbsp; <i class="fa-solid fa-pencil text-yellow-400"></i></td>
                </tr>
                <!-- row 2 -->
                <tr class="hover">
                  <th>2</th>
                  <td>Hart Hagerty</td>
                  <td>Desktop Support Technician</td>
                  <td><i class="fa-solid fa-trash text-red-600"></i> &nbsp; | &nbsp; <i class="fa-solid fa-pencil text-yellow-400"></i></td>
                </tr>
                <!-- row 3 -->
                <tr>
                  <th>3</th>
                  <td>Brice Swyre</td>
                  <td>Tax Accountant</td>
                  <td><i class="fa-solid fa-trash text-red-600"></i> &nbsp; | &nbsp; <i class="fa-solid fa-pencil text-yellow-400"></i></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="join self-end">
            <button class="join-item btn">«</button>
            <button class="join-item btn">Page 22</button>
            <button class="join-item btn">»</button>
          </div>
    </x-pajak.card>

    <x-pajak.card>
        <x-slot:tittle>Faktur Pajak Invoice</x-slot:tittle>
        <div class="action w-full">
            <form action="" class="grid grid-cols-2 justify-between">
                <select class="select select-bordered max-w-20">
                    <option disabled selected>10</option>
                    <option>30</option>
                    <option>60</option>
                </select>
                <label class="input input-bordered flex items-center ml-40">
                    <input type="text" class="grow border-none" placeholder="Search" />
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70"><path fill-rule="evenodd" d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z" clip-rule="evenodd" /></svg>
                  </label>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="table">
              <!-- head -->
              <thead>
                <tr>
                  <th>No.</th>
                  <th>NSFP</th>
                  <th>Inovice</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <!-- row 1 -->
                <tr>
                  <th>1</th>
                  <td>Cy Ganderton</td>
                  <td>Quality Control Specialist</td>
                  <td></td>
                </tr>
                <!-- row 2 -->
                <tr class="hover">
                  <th>2</th>
                  <td>Hart Hagerty</td>
                  <td>Desktop Support Technician</td>
                  <td></td>
                </tr>
                <!-- row 3 -->
                <tr>
                  <th>3</th>
                  <td>Brice Swyre</td>
                  <td>Tax Accountant</td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="join self-end">
            <button class="join-item btn">«</button>
            <button class="join-item btn">Page 22</button>
            <button class="join-item btn">»</button>
          </div>
    </x-pajak.card>

</x-Layout.layout>