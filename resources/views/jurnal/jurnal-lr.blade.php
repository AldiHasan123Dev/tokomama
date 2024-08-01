<x-Layout.layout>
    <x-keuangan.card-keuangan>
        <x-slot:tittle>Laporan Laba/Rugi</x-slot:tittle>
        <div class="overflow-x-auto">
            <form action="{{ route('jurnal.coa') }}" method="post">
                @csrf
            <div>
            <div>
            <a href="#" target="_blank"
                class="btn bg-green-400 text-white my-5 py-4 font-bold" id="print">
                <i class="fas fa-print"></i> Print Laporan</button>
            </a>
            <div class="flex justify-between">
                <div>
                    <label for="bulan" class="mr-2 margin-top:40px">Bulan:</label>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Jan</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Feb</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Mar</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Apr</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Mei</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Jun</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Jul</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Aug</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Sep</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Okt</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Nov</button>
                    <button class="btn bg-green-10 text-black hover:text-white my-5 py-4 font-bold border-black" id="aktif" type="submit">Des</button>
                </div>
                    <!-- <div class="flex items-center">
                        <label for="tahun" class="mr-2">Tahun:</label>
                        <input type="text" id="tahun" name="tahun" class="input input-bordered rounded-lg dark:text-black my-3 py-3">
                    </div> -->
                    <div class="flex items-center">
                        <b class="mr-2">Tahun:  </b>
                        <select class="form-control-bordered rounded-lg dark:text-black my-3 py-3" wire:model="year" style="width: 70px">
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="flex justify-between">
                <div class="w-7/12">
                            <table class="table-auto w-full text-xs">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="px-4 py-2 text-left">A. PENJUALAN USAHA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- masukkan logic -->
                                    @foreach($coa1 as $item)
                                        @php
                                        
                                        $total = $totals[$item->id] ?? ['selisih' => 0];
                                    @endphp
                                    <tr>
                                        <td class="border px-4 py-2">{{ $item->no_akun }}</td>
                                        <td class="border px-4 py-2">{{ $item->nama_akun }}</td>
                                        <td class="border px-4 py-2 text-right">{{ $total['selisih'] }}</td>
                                    </tr>
                                    @endforeach
                                    <!-- masukkan logic -->
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="border px-4 py-2 font-bold">TOTAL</td>
                                            <td class="border px-4 py-2 text-right font-bold">{{$totalA}}</td>
                                        </tr>
                                    </tfoot>
                                </tbody>
                            </table>
                            <table class="table-auto w-full text-xs">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="px-4 py-2 text-left">B. HARGA POKOK PENJUALAN</th>
                                    </tr>
                                    </thead>
                                <tbody>
                                    <!-- masukkan logic -->
                                    @foreach($coa2 as $item)
                                        @php                                        
                                        $total = $totals[$item->id] ?? ['selisih' => 0];
                                    @endphp
                                    <tr>
                                        <td class="border px-4 py-2">{{ $item->no_akun }}</td>
                                        <td class="border px-4 py-2">{{ $item->nama_akun }}</td>
                                        <td class="border px-4 py-2 text-right">{{ $total['selisih'] }}</td>
                                    </tr>
                                    @endforeach
                                    <!-- masukkan logic -->
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="border px-4 py-2 font-bold">TOTAL</td>
                                            <td class="border px-4 py-2 text-right font-bold">{{$totalB}}</td>
                                        </tr>
                                    </tfoot>
                                </tbody>
                            </table>
                            <table class="table-auto w-full text-xs">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="px-4 py-2 text-left">C. BIAYA USAHA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- masukkan logic -->
                                    @foreach($coa3 as $item)
                                        @php                                        
                                        $total = $totals[$item->id] ?? ['selisih' => 0];
                                    @endphp
                                    <tr>
                                        <td class="border px-4 py-2">{{ $item->no_akun }}</td>
                                        <td class="border px-4 py-2">{{ $item->nama_akun }}</td>
                                        <td class="border px-4 py-2 text-right">{{ $total['selisih'] }}</td>
                                    </tr>
                                    @endforeach
                                    <!-- masukkan logic -->
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="border px-4 py-2 font-bold">TOTAL</td>
                                            <td class="border px-4 py-2 text-right font-bold">{{$totalC}}</td>
                                        </tr>
                                    </tfoot>
                                </tbody>
                            </table>
                            <table class="table-auto w-full text-xs">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="px-4 py-2 text-left">D. BIAYA DEPRESIASI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- masukkan logic -->
                                    @foreach($coa4 as $item)
                                        @php                                        
                                        $total = $totals[$item->id] ?? ['selisih' => 0];
                                    @endphp
                                    <tr>
                                        <td class="border px-4 py-2">{{ $item->no_akun }}</td>
                                        <td class="border px-4 py-2">{{ $item->nama_akun }}</td>
                                        <td class="border px-4 py-2 text-right">{{ $total['selisih'] }}</td>
                                    </tr>
                                    @endforeach
                                    <!-- masukkan logic -->
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="border px-4 py-2 font-bold">TOTAL</td>
                                            <td class="border px-4 py-2 text-right font-bold">{{$totalD}}</td>
                                        </tr>
                                    </tfoot>
                                </tbody>
                            </table>
                            <table class="table-auto w-full text-xs">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="px-4 py-2 text-left">E. PENDAPATAN DAN BIAYA LAIN-LAIN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- masukkan logic -->
                                    @foreach($coa5 as $item)
                                        @php                                        
                                        $total = $totals[$item->id] ?? ['selisih' => 0];
                                    @endphp
                                    <tr>
                                        <td class="border px-4 py-2">{{ $item->no_akun }}</td>
                                        <td class="border px-4 py-2">{{ $item->nama_akun }}</td>
                                        <td class="border px-4 py-2 text-right">{{ $total['selisih'] }}</td>
                                    </tr>
                                    @endforeach
                                    <!-- masukkan logic -->
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="border px-4 py-2 font-bold">TOTAL</td>
                                            <td class="border px-4 py-2 text-right font-bold">{{$totalE}}</td>
                                        </tr>
                                    </tfoot>
                                </tbody>
                            </table>
                            <table class="table-auto w-full text-xs">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="px-4 py-2 text-left">F. BIAYA KEUANGAN I</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- masukkan logic -->
                                    @foreach($coa6 as $item)
                                        @php                                        
                                        $total = $totals[$item->id] ?? ['selisih' => 0];
                                    @endphp
                                    <tr>
                                        <td class="border px-4 py-2">{{ $item->no_akun }}</td>
                                        <td class="border px-4 py-2">{{ $item->nama_akun }}</td>
                                        <td class="border px-4 py-2 text-right">{{ $total['selisih'] }}</td>
                                    </tr>
                                    @endforeach
                                    <!-- masukkan logic -->
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="border px-4 py-2 font-bold">TOTAL</td>
                                            <td class="border px-4 py-2 text-right font-bold">{{$totalF}}</td>
                                        </tr>
                                    </tfoot>
                                </tbody>
                            </table>
                            <table class="table-auto w-full mt-3 text-xs">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="px-4 py-2 text-left">G. BIAYA KEUANGAN II</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- masukkan logic -->
                                    @foreach($coa7 as $item)
                                        @php                                        
                                        $total = $totals[$item->id] ?? ['selisih' => 0];
                                    @endphp
                                    <tr>
                                        <td class="border px-4 py-2">{{ $item->no_akun }}</td>
                                        <td class="border px-4 py-2">{{ $item->nama_akun }}</td>
                                        <td class="border px-4 py-2 text-right">{{ $total['selisih'] }}</td>
                                    </tr>
                                    @endforeach
                                    <!-- masukkan logic -->
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="border px-4 py-2 font-bold">TOTAL</td>
                                            <td class="border px-4 py-2 text-right font-bold">{{$totalG}}</td>
                                        </tr>
                                    </tfoot>
                                </tbody>
                            </table>
                        </div>
    
                    



                        <table class="w-auto h-3/4 text-xs border-collapse border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="text-black font-bold px-2 py-1 text-left">Summarry</th>
                                    <th class="text-black font-bold px-2 py-1">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-t">
                                    <td class="px-2 py-1">TOTAL PENJUALAN USAHA</td>
                                    <td class="px-2 py-1">{{$totalA}}</td>
                                </tr>
                                <tr class="border-t ">
                                    <td class="px-2 py-1">TOTAL HARGA POKOK PENJUALAN</td>
                                    <td class="px-2 py-1">{{$totalB}}</td>
                                </tr>
                                <tr class="border-t bg-gray-50">
                                    <td class="px-2 py-1">LABA/RUGI KOTOR</td>
                                    <td class="px-2 py-1">{{$kotor = $totalA - $totalB}}</td>
                                </tr>
                                <tr class="border-t">
                                    <td class="px-2 py-1">TOTAL BIAYA USAHA</td>
                                    <td class="px-2 py-1">{{$totalC}}</td>
                                </tr>
                                <tr class="border-t">
                                    <td class="px-2 py-1">TOTAL BIAYA PENYUSUTAN</td>
                                    <td class="px-2 py-1">{{$totalD}}</td>
                                </tr>
                                <tr class="border-t bg-gray-50">
                                    <td class="px-2 py-1">LABA/RUGI USAHA</td>
                                    <td class="px-2 py-1">{{$usaha = $kotor - $totalC - $totalD}}</td>
                                </tr>
                                <tr class="border-t">
                                    <td class="px-2 py-1">TOTAL PENDAPATAN DAN BIAYA LAIN-LAIN</td>
                                    <td class="px-2 py-1">{{$totalE}}</td>
                                </tr>
                                <tr class="border-t">
                                    <td class="px-2 py-1">TOTAL BIAYA KEUANGAN I</td>
                                    <td class="px-2 py-1">{{$totalF}}</td>
                                </tr>
                                <tr class="border-t bg-gray-50">
                                    <td class="px-2 py-1">LABA/RUGI BERSIH SEBELUM PAJAK</td>
                                    <td class="px-2 py-1">{{$bersih = $usaha - $totalE - $totalF}}</td>
                                </tr>
                                <tr class="border-t">
                                    <td class="px-2 py-1">TOTAL BIAYA KEUANGAN I</td>
                                    <td class="px-2 py-1">{{$totalF}}</td>
                                </tr>
                                <tr class="border-t bg-gray-50">
                                    <td class="px-2 py-1">LABA/RUGI BERSIH SESUDAH PAJAK</td>
                                    <td class="px-2 py-1">{{$pajak = $bersih - $totalG}}</td>
                                </tr>
                            </tbody>
                        </table>

            </form>
        </div>
    </x-keuangan.card-keuangan>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.3/js/dataTables.select.js"></script>
</x-Layout.layout>