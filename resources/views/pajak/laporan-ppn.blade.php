<x-Layout.layout>
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/table.css')}}"> -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/ui.jqgrid-bootstrap5.css') }}" />
    <x-pajak.card>
        <x-slot:tittle>Laporan PPN</x-slot:tittle>
        <div class="grid grid-cols-7">
            <a href=""><button class="btn w-28 font-semibold btn-primary">Tambah Faktur</button></a>
            <a href=""><button class="btn w-28 font-semibold text-white btn-warning">Bukpot</button></a>
            <a href=""><button class="btn w-28 font-semibold text-white btn-accent">Export Excel</button></a>
            <a href=""><button class="btn w-28 font-semibold text-white btn-accent">Excel CSV</button></a>
            
            <form action="" class="flex col-start-6 gap-2 w-56">
                <input type="date" class="input border w-full max-w-xs rounded-lg" />
                <i class="fa-solid fa-arrow-right mx-3 mt-5"></i>
                <input type="date" class="input input-bordered w-full max-w-xs rounded-lg" />
            </form> 
        </div>
        <hr>
        <div class="overflow-x-auto">
            <table class="table" id="table-ppn">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Invoice</th>   <!-- surat jalan / nsfp -->
                  <th>NPWP</th> <!-- master, surat jalan -->
                  <th>NIK</th> <!-- cusromer master apabila tidak ada npwp -->
                  <th>Nama</th>     <!-- nama customer -->
                  <th>Nama NPWP</th> <!--nama asli npwp -->
                  <th>Alamat NPWP</th> <!-- nambah di master customer -->
                  <th>Tanggal Faktur</th>  <!-- diambil dari tanggal invoice pada table surat jalan -->
                  <th>Tujuan</th> <!-- surat jalan  -->
                  <th>Uraian</th> <!-- keterangan -->
                  <th>Faktur</th> <!-- nomor di table nsfp -->
                  <th>Sub Total</th> <!-- invoice -->
                  <th>PPN</th>  <!-- pasti 11% -->
                  <th>Total</th> <!-- sub total + ppn -->
                  <th>PPH</th> 
                  <th>Job</th> <!-- surat jalan  -->
                  <th>No Bupot</th>
                  <th>Masa Pajak</th>
                  <th>Bupot</th>
                  <th>Tanggal Bupot</th>
                  <th>Selisih Bupot</th>
                  <th>Jurnal Bupot</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          
    </x-pajak.card>

    {{-- <form action="{{route('pajak.laporan-ppn.data')}}">
        <button type="submit" id="cekData">cek data</button>
    </form> --}}
    
    <x-slot:script>
        <script>
            let table = $('#table-ppn').DataTable({
              ajax:{
                  url: "{{ route('pajak.laporan-ppn.data') }}",
                  dataSrc: "data",
                   // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              },
              columns: [
                { data: 'DT_RowIndex', name: 'number'},
                { data: 'invoice', name: 'invoice' },
                { data: 'npwp', name: 'npwp' },
                { data: 'nik', name: 'nik' },
                { data: 'nama_customer', name: 'nama_customer' },
                { data: 'nama_npwp', name: 'nama_npwp' },
                { data: 'alamat_npwp', name: 'alamat_npwp' },
                { data: 'tgl_invoice', name: 'tgl_faktur' },
                { data: 'tujuan', name: 'tujuan' },
                { data: 'keterangan', name: 'uraian' },
                { data: 'nomor_nsfp', name: 'faktur' },
                { data: 'total', name: 'total' },
                { data: 'ppn', name: 'ppn' },
                { data: 'total_all', name: 'total_all' },
                { data: 'pph', name: 'pph' },
                { data: 'job', name: 'job' },
                { data: 'no_bupot', name: 'no_bupot' },
                { data: 'masa_pajak', name: 'masa_pajak' },
                { data: 'bupot', name: 'bupot' },
                { data: 'tanggal_bupot', name: 'tanggal_bupot' },
                { data: 'selisih_bupot', name: 'selisih_bupot' },
                { data: 'jurnal_bupot', name: 'jurnal_bupot' },
                { data: 'id', name: 'id', visible:false},  
            ]
          });
        </script>
    </x-slot:script>
</x-Layout.layout>