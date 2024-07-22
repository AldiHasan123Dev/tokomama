<x-Layout.layout>

    <div id="dialog"></div>

    <x-keuangan.card-keuangan>
        <x-slot:tittle>List Surat Jalan</x-slot:tittle>
        <div class="overflow-x-auto">
            <table class="table" id="table-getfaktur">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>Invoice</th>
                        <th>No. Surat</th>
                        <th>Kepada</th>
                        <th>Nama Kapal</th>
                        <th>No. Count</th>
                        <th>No. Seal</th>
                        <th>No. Pol</th>
                        <th>No. Job</th>
                        <th>Profit</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </x-keuangan.card-keuangan>

    {{-- <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script> --}}
    <x-slot:script>
        <script>
            let table = $(`#table-getfaktur`).DataTable({
                ajax: {
                    method:"POST",
                    url: "{{route('surat-jalan.data')}}",
                    data:{
                        _token: "{{csrf_token()}}"
                    }
                },
                // scrollX:true,
                columns: [
                    { data: 'aksi', name: 'aksi' },
                    { data: 'invoice', name: 'No. Invoice' },
                    { data: 'nomor_surat', name: 'No. Surat' },
                    { data: 'kepada', name: 'kepada' },
                    { data: 'nama_kapal', name: 'nama_kapal' },
                    { data: 'no_cont', name: 'no_cont' },
                    { data: 'no_seal', name: 'no_seal' },
                    { data: 'no_pol', name: 'no_pol' },
                    { data: 'id', name: 'id', visible:false},
                    { data: 'profit', name: 'profit'},

                ]
            });

            function getData(id, invoice, nomor_surat, kepada, jumlah, satuan, nama_kapal, no_cont, no_seal, no_pol, no_job) {
                $('#dialog').html(`<dialog id="my_modal_5" class="modal">
                <div class="modal-box w-11/12 max-w-2xl pl-10">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                    <h3 class="text-lg font-bold">Edit Data</h3>
                    <form action="{{route('surat-jalan.data.edit')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="${id}" class="border-none" />
                    <label class="input border flex items-center gap-2 mt-3">
                        Invoice :
                        <input type="text" name="invoice" value="${invoice}" class="border-none" />
                    </label>
                    <label class="input border flex items-center gap-2 mt-3">
                        Nomor Surat :
                        <input type="text" name="nomor_surat" value="${nomor_surat}" class="border-none" readonly />
                    </label>
                    <label class="input border flex items-center gap-2 mt-3">
                        Kepada :
                        <input type="text" name="kepada" value="${kepada}" class="border-none" />
                    </label>
                    <label class="input border flex items-center gap-2 mt-3">
                        Nama Kapal:
                        <input type="text" name="nama_kapal" value="${nama_kapal}" class="border-none" />
                    </label>
                    <label class="input border flex items-center gap-2 mt-3">
                        Nomor Cont:
                        <input type="text" name="no_cont" value="${no_cont}" class="border-none" />
                    </label>
                    <label class="input border flex items-center gap-2 mt-3">
                        Nomor Seal:
                        <input type="text" name="no_seal" value="${no_seal}" class="border-none" />
                    </label>
                    <label class="input border flex items-center gap-2 mt-3">
                        Nomor Pol:
                        <input type="text" name="no_pol" value="${no_pol}" class="border-none" />
                    </label>
                    <label class="input border flex items-center gap-2 mt-3">
                        Nomor Seal:
                        <input type="text" name="no_job" value="${no_job}" class="border-none" />
                    </label>
                    <button type="submit" class="btn bg-green-400 text-white font-semibold w-72 mt-2">Edit</button>
                    </form>
                </div>
                </dialog>`);
                my_modal_5.showModal();
            }

            function deleteData(id) {
                if (confirm('Are you sure you want to delete this data?'))
            {
              $.ajax
              ({
                method: 'post',
                url: "{{ route('surat-jalan.data.delete') }}",
                data: {id: id},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response)
                {
                    alert("Data Surat Jalan berhasil dihapus!");
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
