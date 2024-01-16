@extends("dashboard.pdf.layouts.app")

@section("container")
    <div class="container mx-auto grid px-6">
        <h2 class="judul-laporan my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ $judul }}
        </h2>
    </div>

    <section class="mt-3">
        <div class="table-pdf mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="relative mb-7 overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                <div class="d mb-5 flex items-center justify-between p-4">
                    <div class="flex space-x-3">
                        <div class="flex items-center space-x-3">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Penilaian Alternatif</h2>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto p-3">
                    <table id="tabel_data_hasil" class="nowrap w-full text-sm text-left text-gray-500 dark:text-gray-400 stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3">Alternatif</th>
                                <th scope="col" class="px-4 py-3">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasil as $item)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">
                                        {{ $item->nama_alternatif }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">
                                        {{ round($item->nilai, 3) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    <h2>Simpulan</h2>
                    <p>Berdasarkan tabel dari penilaian perhitungan AHP yang dapat dijadikan rekomendasi alternatif, maka didapatkan alternatif dengan nilai tertinggi yaitu: <span style="font-weight: bold;">{{ $hasil->first()->nama_alternatif }}</span> dengan nilai <span style="font-weight: bold;">{{ round($hasil->first()->nilai, 3) }}</span></p>
                </div>
            </div>
        </div>
    </section>
@endsection
