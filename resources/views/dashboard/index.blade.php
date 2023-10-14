@extends('dashboard.layouts.app')

@section('container')
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Dashboard
        </h2>

        {{-- Card 1 --}}
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                    <i class="ri-table-fill text-xl"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Kriteria
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $kriteria }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                    <i class="ri-layout-3-fill text-xl"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Kategori
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $kategori }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                    <i class="ri-collage-fill text-xl"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Sub Kriteria
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $subKriteria }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                    <i class="ri-braces-fill text-xl"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Alternatif
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        4
                    </p>
                </div>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                    Sistem Pendukung Keputusan
                </h4>
                <p class="mb-3 text-gray-600 dark:text-gray-400 text-justify">
                    AHP merupakan suatu model pendukung keputusan yang dikembangkan oleh Thomas L. Saaty. Model pendukung
                    keputusan ini akan menguraikan masalah multi faktor atau multi kriteria yang kompleks menjadi suatu
                    hirarki yang didefinisikan sebagai suatu representasi dari sebuah permasalahan yang kompleks dalam suatu
                    struktur multi-level dimana level pertama adalah tujuan, yang diikuti level faktor, kriteria, sub
                    kriteria, dan seterusnya ke bawah hingga level terakhir dari alternatif.
                </p>
                <a class="font-semibold leading-normal text-sm group text-gray-600 dark:text-gray-300" href="#">
                    Mulai
                    <i
                        class="ri-arrow-right-line ease-bounce text-sm group-hover:translate-x-1.25 ml-1 leading-normal transition-all duration-200"></i>
                </a>
            </div>
            <div class="min-w-0 p-4 text-white bg-purple-600 rounded-lg shadow-xs">
                <h4 class="mb-4 font-semibold">
                    Kegunaan AHP (Analytical Hierarchy Process):
                </h4>
                <ul style="list-style-type: square;" class="mx-5 mb-3">
                    <li>Struktur yang berhirarki, sebagai konsekuesi dari kriteria yang dipilih, sampai pada sub kriteria
                        yang paling dalam.</li>
                    <li>Memperhitungkan validitas sampai dengan batas toleransi inkonsistensi berbagai kriteria dan
                        alternatif yang dipilih oleh pengambil keputusan.</li>
                    <li>Memperhitungkan daya tahan output analisis sensitivitas pengambilan keputusan.</li>
                </ul>
                <a class="font-semibold leading-normal text-sm group" href="#">
                    Mulai
                    <i
                        class="ri-arrow-right-line ease-bounce text-sm group-hover:translate-x-1.25 ml-1 leading-normal transition-all duration-200"></i>
                </a>
            </div>
        </div>

        {{-- Chart --}}
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Kriteria
                </h4>
                <canvas id="bars"></canvas>
                <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                    <!-- Chart legend -->
                    <div class="flex items-center">
                        <span class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"></span>
                        <span>Shoes</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"></span>
                        <span>Bags</span>
                    </div>
                </div>
            </div>
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Hasil Perhitungan AHP
                </h4>
                <canvas id="line"></canvas>
                <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                    <!-- Chart legend -->
                    <div class="flex items-center">
                        <span class="inline-block w-3 h-3 mr-1 bg-teal-600 rounded-full"></span>
                        <span>Organic</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"></span>
                        <span>Paid</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/charts-lines.js') }}"></script>
    <script src="{{ asset('js/charts-bars.js') }}"></script>
@endsection
