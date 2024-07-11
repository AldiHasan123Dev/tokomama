<x-Layout.layout>
    <style>
        tr.selected{
            background-color: lightskyblue !important;
        }
    </style>
    <x-keuangan.card-keuangan>
        <x-slot:tittle>Pengambilan Nomor Faktur Untuk Invoice</x-slot:tittle>
        <form action="{{ route('invoice-transaksi.store') }}" method="post">
            @csrf
            <label for="invoice_count">Masukan Jumlah Invoice</label>
            <input type="number" onchange="invoice_counts()" onkeyup="invoice_counts()" name="invoice_count" id="invoice_count" min="1" value="1" class="form-control w-full text-center rounded-sm">
            @foreach ($transaksi as $item)
            <div class="overflow-x-auto mt-5 shadow-lg">
                <table class="table" id="table-getfaktur">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th colspan="5">{{ $item->barang->nama ?? '-' }}</th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>Invoice</th>
                            <th>Jumlah Barang ({{ $item->jumlah_jual }})</th>
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-{{ $item->id }}">
                        <tr>
                            <td>1</td>
                            <td class="invoice-{{ $item->id }}">-</td>

                            <!-- inputan quantity invoice -->
                            <td><input id="qty-{{ $item->id }}-1" type="number" class="rounded-sm" onkeyup="inputBarang({{ $item->id }}, this.value,{{ $item->harga_jual }}, {{ $item->jumlah_jual }})" onchange="inputBarang({{ $item->id }}, this.value,{{ $item->harga_jual }}, {{ $item->jumlah_jual }})" name="jumlah[{{ $item->id }}][]" id="jumlah" value="{{ $item->jumlah_jual }}"></td>

                            <!-- harga satuan -->
                            <td>{{ number_format($item->harga_jual) }}</td>

                            <!-- total -->
                            <td id="total-{{ $item->id }}-1">{{ number_format($item->harga_jual * $item->jumlah_jual) }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <button onclick="addRow({{ $item->id }}, {{ $item->harga_jual }}, {{$item->jumlah_jual}})" type="button" class="btn bg-yellow-400 btn-sm w-full">Tambah Kolom</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endforeach

        <button class="btn bg-green-500 font-semibold text-white w-full mt-3" type="submit" onclick="return confirm('Submit Invoice?')">Submit Invoice</button>
        </form>
    </x-keuangan.card-keuangan>

    <x-slot:script>
    <script>
        let idx = 1;
        let ids = @json($ids);
        function inputBarang(id, value, price, max) {
            // console.log(value);
            if (value > max) {
                alert('Jumlah melebihi batas');
                $('#qty-' + id + '-'+idx).val(max);
                return
            }
            let total = parseFloat(value) * parseInt(price);
  
            $('#total-' + id + '-'+idx ).html(total);
        }

        function addRow(id, price, max){
            idx++;
            let html = `<tr>
                        <td>${idx}</td>
                        <td class="invoice-${id}"></td>

                        <td>
                            <input id="qty-${id}-${idx}" type="number" onkeyup="inputBarang(${id}, this.value,${price}, ${max})" onchange="inputBarang(${id}, this.value,${price}, ${max})" name="jumlah[${id}][]" id="jumlah" value="0">
                        </td>

                        <td>${price}</td>
                        <td id="total-${id}-${idx}"></td>
                    </tr>`;
            $('#tbody-' + id).append(html);

            let valueNow = $(`#qty-${id}-${idx}`).val();

            let data = [];
            for(var i = idx; i > 0; i--) {
                let valueAbove = $(`#qty-${id}-${i}`).val();
                data.push(valueAbove);
            }

            let sum = data.slice(1).reduce((accumulator, currentValue) => parseInt(accumulator) + parseInt(currentValue), 0);
            
            if(sum == max || sum > max) {
                alert("Kuantitas melebihi batas");
                return
            }

            $(`#qty-${id}-${idx}`).on({
                change: function () {
                    let valueAbove = $(`#qty-${id}-${idx - 1}`).val();
                    var inputValue = $(this).val();
                    if(parseInt(inputValue) + parseInt(sum) > max) {
                        alert('Total quantity tidak sama dengan jumlah yang di jual');
                        var inputValue = $(this).val(0);
                        return // inputan tetap muncul
                    }
                }
            });
            invoice_counts();
        }

        function invoice_counts(){
            let val = $('#invoice_count').val();
            $.each(ids, function (indexInArray, item) { 
                let options = '<option selected>Pilih Invoice</option>';
                for(let i = 1; i <= val; i++){
                    options += `<option value="${i}">Invoice Ke - ${i}</option>`;
                }
                let html = `<select name="invoice[${item}][]" class="px-2 form-control">${options}</select>`;
                $('.invoice-' + item).html(html);
            });
        }
    </script>
    </x-slot:script>
</x-Layout.layout>