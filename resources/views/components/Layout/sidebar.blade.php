<div class="fixed bottom-0 z-10 h-screen ltr:border-r rtl:border-l vertical-menu rtl:right-0 ltr:left-0 top-[70px] bg-slate-50 border-gray-50 print:hidden dark:bg-zinc-800 dark:border-neutral-700">
        
            <div data-simplebar class="h-full">
                <!--- Sidemenu -->
                <div class="metismenu pb-10 pt-2.5" id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul id="side-menu">
                        <li class="px-5 py-3 text-xs font-medium text-gray-500 cursor-default leading-[18px] group-data-[sidebar-size=sm]:hidden block" data-key="t-menu">Menu</li>
        
                        <li>
                            <a href="{{ route('dashboard') }}" class="block py-2.5 px-6 text-sm font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">
                                <i class="fa-solid fa-house"></i>
                                <span data-key="t-dashboard"> &nbsp; Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" aria-expanded="false" class="block py-2.5 px-6 text-sm font-medium text-gray-950 transition-all duration-150 ease-linear nav-menu hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">
                                <i class="fa-solid fa-database"></i><span data-key="t-pages"> &nbsp; Masters</span>
                            </a>
                            <ul>
                                <li>
                                    <a href="{{route('master.customer')}}" class="pl-[52.8px] pr-6 py-[6.4px] block text-[13.5px] font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Customer</a>
                                </li>
                                <li>
                                    <a href="{{route('master.barang')}}" class="pl-[52.8px] pr-6 py-[6.4px] block text-[13.5px] font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Barang</a>
                                </li>
                                <li>
                                    <a href="{{ route('master.nopol') }}" class="pl-[52.8px] pr-6 py-[6.4px] block text-[13.5px] font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Nopol</a>
                                </li>
                            </ul>
                        </li>
        
                        <li>
                            <a href="javascript: void(0);" aria-expanded="false" class="block :rtl:pr-10 py-2.5 px-6 text-sm font-medium text-gray-950 transition-all duration-150 ease-linear nav-menu hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">
                                <i class="fa-solid fa-money-check-dollar"></i>
                                <span data-key="t-auth">&nbsp; Surat Jalan</span>
                            </a>
                            <ul>
                                <li>
                                    <a href="{{ route('surat-jalan.create') }}" class="pl-[52.8px] pr-6 py-[6.4px] block text-[13.5px] font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Buat Surat Jalan (SJ)</a>
                                </li>
                                <li>
                                    <a href="{{ route('surat-jalan.index') }}" class="pl-[52.8px] pr-6 py-[6.4px] block text-[13.5px] font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">List Surat Jalan (SJ)</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" aria-expanded="false" class="block :rtl:pr-10 py-2.5 px-6 text-sm font-medium text-gray-950 transition-all duration-150 ease-linear nav-menu hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">
                                <i class="fa-solid fa-money-check-dollar"></i>
                                <span data-key="t-auth">&nbsp; Keuangan</span>
                            </a>
                            <ul>
                                <li>
                                    <a href="{{ route('keuangan.pre-invoice') }}" class="pl-[52.8px] pr-6 py-[6.4px] block text-[13.5px] font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Pre Invoice</a>
                                </li>
                                <li>
                                    <a href="{{ route('keuangan.invoice') }}" class="pl-[52.8px] pr-6 py-[6.4px] block text-[13.5px] font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Invoice</a>
                                </li>
                            </ul>
                        </li>
        
                        <li>
                            <a href="javascript: void(0);" aria-expanded="false" class="block py-2.5 px-6 text-sm font-medium text-gray-950 transition-all duration-150 ease-linear nav-menu hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">
                                <i class="fa-solid fa-circle-dollar-to-slot"></i><span data-key="t-pages"> &nbsp; Pajak</span>
                            </a>
                            <ul>
                                <li>
                                    <a href="{{route('pajak.nsfp')}}" class="pl-[52.8px] pr-6 py-[6.4px] block text-[13.5px] font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Nomor Seri NSFP</a>
                                </li>
                                <li>
                                    <a href="{{route('pajak.laporan-ppn')}}" class="pl-[52.8px] pr-6 py-[6.4px] block text-[13.5px] font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Laporan PPN</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" aria-expanded="false" class="block py-2.5 px-6 text-sm font-medium text-gray-950 transition-all duration-150 ease-linear nav-menu hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">
                                <i class="fa-solid fa-book"></i><span data-key="t-pages"> &nbsp; Jurnal Keuangan</span>
                            </a>
                            <ul>
                                <li>
                                    <a href="starter.html" class="pl-[52.8px] pr-6 py-[6.4px] block text-[13.5px] font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Starter Page</a>
                                </li>
                                <li>
                                    <a href="maintenance.html" class="pl-[52.8px] pr-6 py-[6.4px] block text-[13.5px] font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Maintenance</a>
                                </li>
                                <li>
                                    <a href="coming-soon.html" class="pl-[52.8px] pr-6 py-[6.4px] block text-[13.5px] font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Coming Soon</a>
                                </li>
                                <li>
                                    <a href="timeline.html" class="pl-[52.8px] pr-6 py-[6.4px] block text-[13.5px] font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Timeline</a>
                                </li>
                                <li>
                                    <a href="faqs.html" class="pl-[52.8px] pr-6 py-[6.4px] block text-[13.5px] font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">FAQs</a>
                                </li>
                                <li>
                                    <a href="pricing.html" class="pl-[52.8px] pr-6 py-[6.4px] block text-[13.5px] font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Pricing</a>
                                </li>
                                <li>
                                    <a href="404.html" class="pl-[52.8px] pr-6 py-[6.4px] block text-[13.5px] font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Error 404</a>
                                </li>
                                <li>
                                    <a href="500.html" class="pl-[52.8px] pr-6 py-[6.4px] block text-[13.5px] font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Error 500</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>