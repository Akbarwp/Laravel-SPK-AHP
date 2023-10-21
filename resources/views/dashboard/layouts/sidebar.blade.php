<!-- Desktop sidebar -->
<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200 font-lato" href="{{ route('dashboard') }}">
            Admin Panel
        </a>
        <ul class="mt-6">
            <li class="relative px-6 py-3">
                @if (Request::is('dashboard'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('dashboard') }}">
                    <i class="ri-home-4-line text-lg"></i>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>
        </ul>
        <ul>
            {{-- Data Master --}}
            <li class="w-full mt-6">
                <h6 class="pl-6 font-bold leading-tight uppercase text-xs opacity-60">Master</h6>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/kriteria'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/kriteria') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('kriteria') }}">
                    <i class="ri-table-line text-lg"></i>
                    <span class="ml-4">Kriteria</span>
                </a>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/kriteria/perhitungan_utama*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/kriteria/perhitungan_utama*') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('perhitungan_utama') }}">
                    <i class="ri-table-line text-lg"></i>
                    <span class="ml-4">Perhitungan AHP Kriteria Utama</span>
                </a>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/kategori*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/kategori*') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('kategori') }}">
                    <i class="ri-layout-3-line text-lg"></i>
                    <span class="ml-4">Kategori</span>
                </a>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/sub_kriteria*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/sub_kriteria*') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('sub_kriteria') }}">
                    <i class="ri-collage-line text-lg"></i>
                    <span class="ml-4">Sub Kriteria</span>
                </a>
            </li>

            {{-- Data AHP --}}
            <li class="w-full mt-6">
                <h6 class="pl-6 font-bold leading-tight uppercase text-xs opacity-60">AHP</h6>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/alternatif*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/alternatif*') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('alternatif') }}">
                    <i class="ri-braces-line text-lg"></i>
                    <span class="ml-4">Alternatif</span>
                </a>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/penilaian*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/penilaian*') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('penilaian') }}">
                    <i class="ri-survey-line text-lg"></i>
                    <span class="ml-4">Penilaian Alternatif</span>
                </a>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/hasil_akhir*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/hasil_akhir*') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('penilaian.hasil_akhir') }}">
                    <i class="ri-bar-chart-2-line text-lg"></i>
                    <span class="ml-4">Hasil Akhir</span>
                </a>
            </li>
        </ul>
        {{-- <div class="px-6 my-6">
            <button class="flex items-center justify-start w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                <i class="ri-arrow-left-line mr-2"></i>
                Kembali
            </button>
        </div> --}}
    </div>
</aside>

<!-- Mobile sidebar -->
<div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
</div>
<aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden" x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu" @keydown.escape="closeSideMenu">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200 font-lato" href="{{ route('dashboard') }}">
            Admin Panel
        </a>
        <ul class="mt-6">
            <li class="relative px-6 py-3">
                @if (Request::is('dashboard'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('dashboard') }}">
                    <i class="ri-home-4-line text-lg"></i>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>
        </ul>
        <ul>
            {{-- Data Master --}}
            <li class="w-full mt-6">
                <h6 class="pl-6 font-bold leading-tight uppercase text-xs opacity-60">Master</h6>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/kriteria'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/kriteria') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('kriteria') }}">
                    <i class="ri-table-line text-lg"></i>
                    <span class="ml-4">Kriteria</span>
                </a>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/kriteria/perhitungan_utama*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/kriteria/perhitungan_utama*') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('perhitungan_utama') }}">
                    <i class="ri-table-line text-lg"></i>
                    <span class="ml-4">Perhitungan AHP Kriteria Utama</span>
                </a>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/kategori*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/kategori*') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('kategori') }}">
                    <i class="ri-layout-3-line text-lg"></i>
                    <span class="ml-4">Kategori</span>
                </a>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/sub_kriteria*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/sub_kriteria*') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('sub_kriteria') }}">
                    <i class="ri-collage-line text-lg"></i>
                    <span class="ml-4">Sub Kriteria</span>
                </a>
            </li>

            {{-- Data AHP --}}
            <li class="w-full mt-6">
                <h6 class="pl-6 font-bold leading-tight uppercase text-xs opacity-60">AHP</h6>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/alternatif*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/alternatif*') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('alternatif') }}">
                    <i class="ri-braces-line text-lg"></i>
                    <span class="ml-4">Alternatif</span>
                </a>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/penilaian*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/penilaian*') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('penilaian') }}">
                    <i class="ri-survey-line text-lg"></i>
                    <span class="ml-4">Penilaian Alternatif</span>
                </a>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/hasil_akhir*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/hasil_akhir*') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('penilaian.hasil_akhir') }}">
                    <i class="ri-bar-chart-2-line text-lg"></i>
                    <span class="ml-4">Hasil Akhir</span>
                </a>
            </li>
        </ul>
        {{-- <div class="px-6 my-6">
            <button class="flex items-center justify-start w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                <i class="ri-arrow-left-line mr-2"></i>
                Kembali
            </button>
        </div> --}}
    </div>
</aside>
