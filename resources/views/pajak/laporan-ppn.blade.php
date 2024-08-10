<x-Layout.layout>
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/table.css')}}"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.2/css/dataTables.dateTime.min.css">
    <style>
      
    </style>
    <x-pajak.card>
        <x-slot:tittle>Laporan PPN</x-slot:tittle>
        <div class="grid grid-cols-7">
            <a href=""><button class="btn w-28 font-semibold btn-primary">Tambah Faktur</button></a>
            <a href=""><button class="btn w-28 font-semibold text-white btn-warning">Bukpot</button></a>

            <form action="{{route('pajak.export.ppnexc')}}" method="post">
              @csrf
              <input type="hidden" name="start" id="startex" >
              <input type="hidden" name="end" id="endex" >
              <button type="submit" class="btn w-28 font-semibold text-white bg-green-500 hover:bg-green-400" id="excel">Export Excel</button>
            </form>
            
            <form action="{{route('pajak.export.ppncsv')}}" method="post">
              @csrf
              <input type="hidden" name="start" id="startcs" >
              <input type="hidden" name="end" id="endcs" >
              <button class="btn w-28 font-semibold text-white bg-green-500" id="csv">Excel CSV</button>
            </form>
        </div>
        <hr>
        <div class="overflow-x-auto">
            <table border="0" cellspacing="5" cellpadding="5">
              <tbody>
                <tr>
                  <td>Tanggal Mulai:</td>
                  <td><input type="text" id="min" name="min" class="rounded-md"></td>
                </tr>
                <tr>
                    <td>Tanggal Selesai:</td>
                    <td><input type="text" id="max" name="max" class="rounded-md"></td>
                </tr>
              </tbody>
            </table>
            <table class="cell-border hover nowrap" id="table-ppn">
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
    
    <x-slot:script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
      <script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.min.js"></script>
      <!-- <script src="https://cdn.datatables.net/2.1.0/js/dataTables.tailwindcss.js"></script> -->
        <script>
          
            

          let minDate, maxDate;
          DataTable.ext.search.push(function (settings, data, dataIndex) {
              let min = minDate.val();
              let max = maxDate.val();
              let date = new Date(data[7]);
          
              if (
                  (min === null && max === null) ||
                  (min === null && date <= max) ||
                  (min <= date && max === null) ||
                  (min <= date && date <= max)
              ) {
                  return true;
              }
              return false;
          });

          // Create date inputs
          minDate = new DateTime('#min', {
              format: 'YYYY-M-D'
          });

          maxDate = new DateTime('#max', {
              format: 'YYYY-M-D'
          });
          
        
          let table = $('#table-ppn').DataTable({

              ajax:{
                  url: "{{ route('pajak.laporan-ppn.data') }}",
                  dataSrc: "data",
                   // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              },
              autoWidth: false,
              columns: [
                { data: 'DT_RowIndex', name: 'number'},
                { data: 'invoice', name: 'invoice' },
                { data: 'npwp', name: 'npwp' },
                { data: 'nik', name: 'nik' },
                { data: 'nama_customer', name: 'nama_customer' },
                { data: 'nama_npwp', name: 'nama_npwp' },
                { data: 'alamat_npwp', name: 'alamat_npwp', className: "truncate max-w-xs", width: '30px'},
                { data: 'tgl_invoice', name: 'tgl_faktur' },
                { data: 'tujuan', name: 'tujuan' },
                { data: 'keterangan', name: 'uraian', className: "truncate max-w-xs"},
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

           // Refilter the table
           document.querySelectorAll('#min, #max').forEach((el) => {
              el.addEventListener('change', () => table.draw());
          });

          $("#min").on({
            change: function () {
              var inputValue = $(this).val();
              $('#startex').val(inputValue);
              $('#startcs').val(inputValue);
              console.log(inputValue); 
            }
          });

          $('#max').on({
            change: function () {
              var inputValue = $(this).val();
              $('#endex').val(inputValue);
              $('#endcs').val(inputValue);
            }
          });

          // $('#excel').on('click', function() {
          //   if (confirm('Apakah anda ingin melakukan export data?')) 
          //   {
          //       $.ajax
          //       ({
          //           method: 'post',
          //           url: "{{ route('pajak.export.ppnexc') }}",
          //           data: {
          //             start: $('#min').val(),
          //             end: $('#max').val()
          //           },
          //           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          //           success: function(response) 
          //           {
          //               table.ajax.reload();
          //           },
          //           error: function(xhr, status, error) 
          //           {
          //               console.log('Error:', error);
          //               console.log('Status:', status);
          //               console.dir(xhr);
          //           }
          //       })
          //   }
          // })
        </script>
    </x-slot:script>
</x-Layout.layout>