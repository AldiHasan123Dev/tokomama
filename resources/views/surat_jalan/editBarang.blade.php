<x-Layout.layout>

    <div id="dialog"></div>

    <x-keuangan.card-keuangan>
        <x-slot:tittle>Edit By Barang</x-slot:tittle>
        <a href="{{ route('surat-jalan.index') }}" class="my-3 px-3 py-3 bg-blue-500 text-white w-fit rounded-lg">Kembali ke List Surat Jalan</a>
        <div class="overflow-x-auto">
            <table class="table" id="editBarang">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>Nomor Surat Jalan</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Jual</th>
                        <th>Jumlah Beli</th>
                        <th>Harga Jual</th>
                        <th>Harga Beli</th>
                        <th>Satuan Jual</th>
                        <th>Satuan Beli</th>
                        <th>Margin</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $trans)
                        <tr>
                            <td>
                                @if ($trans->sisa > 0)
                                    <button onclick="getData({{ $trans->id }}, {{ $trans->jumlah_jual }})" class="text-yellow-300"><i class="fa-solid fa-pencil"></i></button>
                                @endif
                            </td>
                            <td>{{ $trans->suratJalan->nomor_surat }}</td>
                            <td>{{ $trans->barang->nama }}</td>
                            <td>{{ $trans->jumlah_jual }}</td>
                            <td>{{ $trans->jumlah_beli }}</td>
                            <td>{{ $trans->harga_jual }}</td>
                            <td>{{ $trans->harga_beli }}</td>
                            <td>{{ $trans->satuan_jual }}</td>
                            <td>{{ $trans->satuan_beli }}</td>
                            <td>{{ number_format($trans->margin) }}</td>
                            <td>{{ $trans->keterangan ? $trans->keterangan : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-keuangan.card-keuangan>

    {{-- <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script> --}}
    <x-slot:script>
        <script>
            let table = new DataTable('#editBarang', {
                order: [[1, 'desc']]
            });

            function getData(id, kuantitas) {
                $('#dialog').html(`<dialog id="my_modal_5" class="modal">
                <div class="modal-box w-11/12 max-w-2xl pl-10">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                    <h3 class="text-lg font-bold">Edit by Barang</h3>
                    <form action="{{route('surat-jalan.editBarang')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="${id}" class="border-none" />
                    <label class="input border flex items-center gap-2 mt-3">
                        Jumlah Jual & Jumlah Beli :
                        <input type="text" name="jumlah_jual" value="${kuantitas}" class="border-none" />
                    </label>
                    <button type="submit" class="btn bg-green-400 text-white font-semibold w-72 mt-2">Edit</button>
                    </form>
                </div>
                </dialog>`);
                my_modal_5.showModal();
            }
        </script>
    </x-slot:script>
</x-Layout.layout>
