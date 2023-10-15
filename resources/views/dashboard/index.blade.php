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
                        {{ $kriteria->count() }}
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
                <a class="font-semibold leading-normal text-sm group text-gray-600 dark:text-gray-300" href="{{ route('kriteria') }}">
                    Mulai
                    <i class="ri-arrow-right-line ease-bounce text-sm group-hover:translate-x-1.25 ml-1 leading-normal transition-all duration-200"></i>
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
                <a class="font-semibold leading-normal text-sm group" href="{{ route('kriteria') }}">
                    Mulai
                    <i class="ri-arrow-right-line ease-bounce text-sm group-hover:translate-x-1.25 ml-1 leading-normal transition-all duration-200"></i>
                </a>
            </div>
        </div>

        {{-- Chart --}}
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Hasil Perhitungan AHP Kriteria Utama
                </h4>
                <div class="flex flex-col justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                    <!-- Chart legend -->
                    @php
                        foreach ($kriteria as $item) {
                            $jumlah = $matriksPenjumlahan->where('kriteria_id', $item->id)->sum('nilai');
                            $prioritas = $matriksNilai->where('kriteria_id', $item->id)->sum('nilai') / $matriksNilai->unique('kriteria_id')->count();
                            $hasil = round($jumlah + $prioritas, 3);
                        }
                        $hasilRasio = 0;
                        $jmlKriteria = $kriteria->count();
                    @endphp
                    {{-- Cara Cek CR 1 --}}
                    <div class="overflow-x-auto p-3 mt-3">
                        <table id="tabel_data_matriks_penjumlahan" class="nowrap w-full text-sm text-left text-gray-500 dark:text-gray-400 stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                            <caption class="mb-3 text-base">Consistency Ratio: Cara 1</caption>
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Keterangan</th>
                                    <th scope="col" class="px-4 py-3">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $lamdaMaks1 = $hasilRasio / $jmlKriteria;
                                    $CI1 = ($lamdaMaks1 - $jmlKriteria) / $jmlKriteria;
                                @endphp
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">Jumlah Kriteria <span class="font-normal">(n)</span></td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">
                                        {{ $jmlKriteria }}
                                    </td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">IR</td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">
                                        {{ $IR }}
                                    </td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">λ maks</td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">
                                        {{ round($lamdaMaks1, 3) }}
                                    </td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">CI</td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">
                                        {{ round($CI1, 3) }}
                                    </td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">CR</td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">
                                        @if ($CI1/$IR <= 0.1)
                                            <span class="text-success">
                                                {{ round($CI1/$IR, 3) }}
                                            </span>
                                            <i class="ri-checkbox-circle-fill ml-1 text-lg text-success"></i>
                                        @else
                                            <span class="text-error">
                                                {{ round($CI1/$IR, 3) }}
                                            </span>
                                            <i class="ri-close-circle-fill ml-1 text-lg text-error"></i>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col" class="px-4 py-3 dark:text-purple-300">Syarat Nilai CR</th>
                                    <th scope="col" class="px-4 py-3 dark:text-purple-300">CR ≤ 0.1</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    {{-- Cara Cek CR 2 --}}
                    <div class="overflow-x-auto p-3 mt-3">
                        <table id="tabel_data_matriks_penjumlahan" class="nowrap w-full text-sm text-left text-gray-500 dark:text-gray-400 stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                            <caption class="mb-3 text-base">Consistency Ratio: Cara 2</caption>
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Keterangan</th>
                                    <th scope="col" class="px-4 py-3">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $lamdaMaks2 = $matriksPenjumlahanPrioritas->sum('prioritas') / $jmlKriteria;
                                    $CI2 = ($lamdaMaks2 - $jmlKriteria) / ($jmlKriteria-1);
                                @endphp
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">Jumlah Kriteria <span class="font-normal">(n)</span></td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">
                                        {{ $jmlKriteria }}
                                    </td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">IR</td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">
                                        {{ $IR }}
                                    </td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">λ maks</td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">
                                        {{ round($lamdaMaks2, 3) }}
                                    </td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">CI</td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">
                                        {{ round($CI2, 3) }}
                                    </td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">CR</td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">
                                        @if ($CI2/$IR > 0 && $CI2/$IR < 0.1)
                                            <span class="text-success">
                                                {{ round($CI2/$IR, 3) }}
                                            </span>
                                            <i class="ri-checkbox-circle-fill ml-1 text-lg text-success"></i>
                                        @else
                                            <span class="text-error">
                                                {{ round($CI2/$IR, 3) }}
                                            </span>
                                            <i class="ri-close-circle-fill ml-1 text-lg text-error"></i>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col" class="px-4 py-3 dark:text-purple-300">Syarat Nilai CR</th>
                                    <th scope="col" class="px-4 py-3 dark:text-purple-300">0 > CR < 0.1</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Hasil Perhitungan AHP Alternatif
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
@endsection
