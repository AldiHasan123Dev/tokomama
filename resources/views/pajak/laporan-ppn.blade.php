<x-Layout.layout>
    <link rel="stylesheet" href="{{ asset('assets/css/table.css')}}">
    <x-pajak.card>
        <x-slot:tittle>Laporan PPN</x-slot:tittle>
        <div class="overflow-x-auto mt-3">
            
            <table id="jqGrid"></table>
            <div id="jqGridPager"></div>
        </div>
    </x-pajak.card>

    
    <script type="text/ecmascript" src="{{ asset('/assets/js/grid.locale-en.js') }}"></script>
    <script type="text/ecmascript" src="{{ asset('/assets/js/jquery.jqGrid.min.js') }}"></script>
    
    <script>
        $('#jqGrid').jqGrid({
            colModel: [{ name: "email" }, { name: "name" }],

            datatype: "local",
            data: [
                { id: 1, email: "punten", name: "Lapo" },
                { id: 2, email: "김", name: "지혜" },
                { id: 3, email: "고", name: "길동" },
                { id: 4, email: "홍", name: "길동" },
                { id: 5, email: "곽", name: "두식" },
                { id: 6, email: "곽", name: "두식" },
                { id: 7, email: "곽", name: "두식" },
                { id: 8, email: "곽", name: "두식" },
                { id: 9, email: "곽", name: "두식" },
                { id: 10, email: "곽", name: "두식" },
                { id: 11, email: "곽", name: "두식" },
                { id: 12, email: "곽", name: "두식" },
            ],
            colModel: [
                {search:true, name: 'email', label : 'Email'},
                {search:true, name: 'name', label : 'Name'},

            ],
            autowidth: true,
            shrinkToFit: false,
            height: 250,
            oadonce: true,
            rowNum: 25,
            rowList:[10,25,50,100],
			viewrecords: true,

        });
    </script>
</x-Layout.layout>