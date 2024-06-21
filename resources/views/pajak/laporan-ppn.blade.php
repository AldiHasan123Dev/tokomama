<x-Layout.layout>
    <link rel="stylesheet" href="{{ asset('assets/css/table.css')}}">
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
        <div class="overflow-x-auto mt-3">
            <table id="jqGrid"></table>
            <div id="jqGridPager"></div>
        </div>
        <div class="count grid grid-cols-4 gap-8">
            <div class="subtotal flex space-x-4 border-solid border-2 border-black p-2 rounded-md">
                <div>Sub Total: </div>
                <div>10.000.000</div>
            </div>
            <div class="ppn flex space-x-4 border-solid border-2 border-black p-2 rounded-md">
                <div>PPN: </div>
                <div>10.000.000</div>
            </div>
            <div class="total flex space-x-4 border-solid border-2 border-black p-2 rounded-md">
                <div>Total: </div>
                <div>10.000.000</div>
            </div>
            <div class="pph flex space-x-4 border-solid border-2 border-black p-2 rounded-md">
                <div>PPH: </div>
                <div>10.000.000</div>
            </div>
        </div>
        
        
    </x-pajak.card>

    
    <script type="text/ecmascript" src="{{ asset('/assets/js/grid.locale-en.js') }}"></script>
    <script type="text/ecmascript" src="{{ asset('/assets/js/jquery.jqGrid.min.js') }}"></script>
    
    <script>
        $('#jqGrid').jqGrid({
            colModel: [
                { name: "Invoice" },
                { name: "NPWP" },
                { name: "NIK" },
                { name: "Nama" },
                { name: "Nama_NPWP" },
                { name: "Alamat NPWP" },
                { name: "Tanggal Faktur" },
                { name: "Tujuan" },
                { name: "Uraian" },
                { name: "Faktur" },
                { name: "Sub Total" },
                { name: "PPN" },
                { name: "Total" },
                { name: "Job" },
                { name: "No Bupot" },
                { name: "Masa Pajak" },
                { name: "Bupot" },
                { name: "Tanggal Bupot" },
                { name: "Jurnal Bupot" }],
            datatype: "local",
            data: [
                {
                    id: 1, invoice: "AAAAA", npwp: "NPWP", nik: "252525252", nama: "Galeh", nama_npwp: "6789",  alamat_npwp: "JL KuntiLanak", tanggal_faktur: "2021", tujuan: "somthing", uraian: "prx esport", faktur: "hyperex", sub_total: "20 jt", ppn: "11%", total:"wakeh", job: "duelist", no_bupot: "123", masa_pajak:"besok", bupot: "pot bunga mawar", tanggal_bupot: "besok besoknya lagi", jurnal_bupot: "jurnal scopus bupot"
                },
                {
                    id: 2, invoice: "AAAAA", npwp: "NPWP", nik: "252525252", nama: "Galeh", nama_npwp: "6789",  alamat_npwp: "JL KuntiLanak", tanggal_faktur: "2021", tujuan: "somthing", uraian: "prx esport", faktur: "hyperex", sub_total: "20 jt", ppn: "11%", total:"wakeh", job: "duelist", no_bupot: "123", masa_pajak:"besok", bupot: "pot bunga mawar", tanggal_bupot: "besok besoknya lagi", jurnal_bupot: "jurnal scopus bupot"
                },
                {
                    id: 3, invoice: "AAAAA", npwp: "NPWP", nik: "252525252", nama: "Galeh", nama_npwp: "6789",  alamat_npwp: "JL KuntiLanak", tanggal_faktur: "2021", tujuan: "somthing", uraian: "prx esport", faktur: "hyperex", sub_total: "20 jt", ppn: "11%", total:"wakeh", job: "duelist", no_bupot: "123", masa_pajak:"besok", bupot: "pot bunga mawar", tanggal_bupot: "besok besoknya lagi", jurnal_bupot: "jurnal scopus bupot"
                },
                {
                    id: 4, invoice: "AAAAA", npwp: "NPWP", nik: "252525252", nama: "Galeh", nama_npwp: "6789",  alamat_npwp: "JL KuntiLanak", tanggal_faktur: "2021", tujuan: "somthing", uraian: "prx esport", faktur: "hyperex", sub_total: "20 jt", ppn: "11%", total:"wakeh", job: "duelist", no_bupot: "123", masa_pajak:"besok", bupot: "pot bunga mawar", tanggal_bupot: "besok besoknya lagi", jurnal_bupot: "jurnal scopus bupot"
                },
                {
                    id: 5, invoice: "AAAAA", npwp: "NPWP", nik: "252525252", nama: "Galeh", nama_npwp: "6789",  alamat_npwp: "JL KuntiLanak", tanggal_faktur: "2021", tujuan: "somthing", uraian: "prx esport", faktur: "hyperex", sub_total: "20 jt", ppn: "11%", total:"wakeh", job: "duelist", no_bupot: "123", masa_pajak:"besok", bupot: "pot bunga mawar", tanggal_bupot: "besok besoknya lagi", jurnal_bupot: "jurnal scopus bupot"
                },
                {
                    id: 6, invoice: "AAAAA", npwp: "NPWP", nik: "252525252", nama: "Galeh", nama_npwp: "6789",  alamat_npwp: "JL KuntiLanak", tanggal_faktur: "2021", tujuan: "somthing", uraian: "prx esport", faktur: "hyperex", sub_total: "20 jt", ppn: "11%", total:"wakeh", job: "duelist", no_bupot: "123", masa_pajak:"besok", bupot: "pot bunga mawar", tanggal_bupot: "besok besoknya lagi", jurnal_bupot: "jurnal scopus bupot"
                },
                {
                    id: 7, invoice: "AAAAA", npwp: "NPWP", nik: "252525252", nama: "Galeh", nama_npwp: "6789",  alamat_npwp: "JL KuntiLanak", tanggal_faktur: "2021", tujuan: "somthing", uraian: "prx esport", faktur: "hyperex", sub_total: "20 jt", ppn: "11%", total:"wakeh", job: "duelist", no_bupot: "123", masa_pajak:"besok", bupot: "pot bunga mawar", tanggal_bupot: "besok besoknya lagi", jurnal_bupot: "jurnal scopus bupot"
                },
                {
                    id: 8, invoice: "AAAAA", npwp: "NPWP", nik: "252525252", nama: "Galeh", nama_npwp: "6789",  alamat_npwp: "JL KuntiLanak", tanggal_faktur: "2021", tujuan: "somthing", uraian: "prx esport", faktur: "hyperex", sub_total: "20 jt", ppn: "11%", total:"wakeh", job: "duelist", no_bupot: "123", masa_pajak:"besok", bupot: "pot bunga mawar", tanggal_bupot: "besok besoknya lagi", jurnal_bupot: "jurnal scopus bupot"
                },
                {
                    id: 9, invoice: "AAAAA", npwp: "NPWP", nik: "252525252", nama: "Galeh", nama_npwp: "6789",  alamat_npwp: "JL KuntiLanak", tanggal_faktur: "2021", tujuan: "somthing", uraian: "prx esport", faktur: "hyperex", sub_total: "20 jt", ppn: "11%", total:"wakeh", job: "duelist", no_bupot: "123", masa_pajak:"besok", bupot: "pot bunga mawar", tanggal_bupot: "besok besoknya lagi", jurnal_bupot: "jurnal scopus bupot"
                },
                {
                    id: 10, invoice: "AAAAA", npwp: "NPWP", nik: "252525252", nama: "Galeh", nama_npwp: "6789",  alamat_npwp: "JL KuntiLanak", tanggal_faktur: "2021", tujuan: "somthing", uraian: "prx esport", faktur: "hyperex", sub_total: "20 jt", ppn: "11%", total:"wakeh", job: "duelist", no_bupot: "123", masa_pajak:"besok", bupot: "pot bunga mawar", tanggal_bupot: "besok besoknya lagi", jurnal_bupot: "jurnal scopus bupot"
                },
                {
                    id: 11, invoice: "AAAAA", npwp: "NPWP", nik: "252525252", nama: "Galeh", nama_npwp: "6789",  alamat_npwp: "JL KuntiLanak", tanggal_faktur: "2021", tujuan: "somthing", uraian: "prx esport", faktur: "hyperex", sub_total: "20 jt", ppn: "11%", total:"wakeh", job: "duelist", no_bupot: "123", masa_pajak:"besok", bupot: "pot bunga mawar", tanggal_bupot: "besok besoknya lagi", jurnal_bupot: "jurnal scopus bupot"
                },
                {
                    id: 12, invoice: "AAAAA", npwp: "NPWP", nik: "252525252", nama: "Galeh", nama_npwp: "6789",  alamat_npwp: "JL KuntiLanak", tanggal_faktur: "2021", tujuan: "somthing", uraian: "prx esport", faktur: "hyperex", sub_total: "20 jt", ppn: "11%", total:"wakeh", job: "duelist", no_bupot: "123", masa_pajak:"besok", bupot: "pot bunga mawar", tanggal_bupot: "besok besoknya lagi", jurnal_bupot: "jurnal scopus bupot"
                },
                
            ],
            colModel: [
                {search:true, name: 'invoice', label : 'Invoice'},
                {search:true, name: 'npwp', label : 'NPWP'},
                {search:true, name: 'nik', label : 'NPWP'},
                {search:true, name: 'nama', label : 'Nama'},
                {search:true, name: 'nama_npwp', label : 'Nama NPWP'},
                {search:true, name: 'alamat_npwp', label : 'Alamat NPWP'},
                {search:true, name: 'tanggal_faktur', label : 'Tangal Faktur'},
                {search:true, name: 'tujuan', label : 'Tujuan'},
                {search:true, name: 'uraian', label : 'Uraian'},
                {search:true, name: 'faktur', label : 'Faktur'},
                {search:true, name: 'sub_total', label : 'Sub Total'},
                {search:true, name: 'ppn', label : 'ppn'},
                {search:true, name: 'total', label : 'Total'},
                {search:true, name: 'job', label : 'Job'},
                {search:true, name: 'no_bupot', label : 'No Bupot'},
                {search:true, name: 'masa_pajak', label : 'Masa Pajak'},
                {search:true, name: 'bupot', label : 'Bupot'},
                {search:true, name: 'tanggal_bupot', label : 'Tanggal Bupot'},
                {search:true, name: 'jurnal_bupot', label : 'Jurnal Bupot'},

            ],
            autowidth: true,
            shrinkToFit: false,
            height: 250,
            oadonce: true,
            rowNum: 25,
            rowList:[10,25,50,100],
			viewrecords: true,
            pager: "#jqGridPager"

        });
    </script>
</x-Layout.layout>