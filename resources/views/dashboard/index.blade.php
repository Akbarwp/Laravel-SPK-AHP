@extends("dashboard.layouts.app")

@section("container")
    <div class="container mx-auto grid px-6">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Dashboard
        </h2>

        {{-- Card 1 --}}
        <div class="mb-8 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            <!-- Card -->
            <div class="shadow-xs flex items-center rounded-lg bg-white p-4 dark:bg-gray-800">
                <div class="mr-4 rounded-full bg-orange-100 p-3 text-orange-500 dark:bg-orange-500 dark:text-orange-100">
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
            <div class="shadow-xs flex items-center rounded-lg bg-white p-4 dark:bg-gray-800">
                <div class="mr-4 rounded-full bg-blue-100 p-3 text-blue-500 dark:bg-blue-500 dark:text-blue-100">
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
            <div class="shadow-xs flex items-center rounded-lg bg-white p-4 dark:bg-gray-800">
                <div class="mr-4 rounded-full bg-green-100 p-3 text-green-500 dark:bg-green-500 dark:text-green-100">
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
            <div class="shadow-xs flex items-center rounded-lg bg-white p-4 dark:bg-gray-800">
                <div class="mr-4 rounded-full bg-teal-100 p-3 text-teal-500 dark:bg-teal-500 dark:text-teal-100">
                    <i class="ri-braces-fill text-xl"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Alternatif
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $alternatif->count() }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="mb-8 grid gap-6 md:grid-cols-2">
            <div class="shadow-xs min-w-0 rounded-lg bg-white p-4 dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                    Sistem Pendukung Keputusan
                </h4>
                <p class="mb-3 text-justify text-gray-600 dark:text-gray-400">
                    AHP merupakan suatu model pendukung keputusan yang dikembangkan oleh Thomas L. Saaty. Model pendukung
                    keputusan ini akan menguraikan masalah multi faktor atau multi kriteria yang kompleks menjadi suatu
                    hirarki yang didefinisikan sebagai suatu representasi dari sebuah permasalahan yang kompleks dalam suatu
                    struktur multi-level dimana level pertama adalah tujuan, yang diikuti level faktor, kriteria, sub
                    kriteria, dan seterusnya ke bawah hingga level terakhir dari alternatif.
                </p>
                <a class="group text-sm font-semibold leading-normal text-gray-600 dark:text-gray-300" href="{{ route("kriteria") }}">
                    Mulai
                    <i class="ri-arrow-right-line ease-bounce group-hover:translate-x-1.25 ml-1 text-sm leading-normal transition-all duration-200"></i>
                </a>
            </div>
            <div class="shadow-xs min-w-0 rounded-lg bg-purple-600 p-4 text-white">
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
                <a class="group text-sm font-semibold leading-normal" href="{{ route("kriteria") }}">
                    Mulai
                    <i class="ri-arrow-right-line ease-bounce group-hover:translate-x-1.25 ml-1 text-sm leading-normal transition-all duration-200"></i>
                </a>
            </div>
        </div>

        {{-- Chart --}}
        <div class="mb-8 grid gap-6">
            <div class="shadow-xs min-w-0 rounded-lg bg-white p-4 dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Hasil Perhitungan AHP Alternatif
                </h4>
                <canvas id="line"></canvas>
                <div class="mt-4 flex justify-center space-x-3 text-sm text-gray-600 dark:text-gray-400">
                    <!-- Chart legend -->
                    <div class="flex items-center">
                        <span class="mr-1 inline-block h-3 w-3 rounded-full bg-[#0694a2]"></span>
                        <span>Alternatif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("js")
    <script>
        let hasilSolusiData = [];
        @foreach ($hasilSolusi as $item)
            hasilSolusiData.push(' {{ $item->nama_alternatif }} ');
        @endforeach

        const lineConfig = {
            type: 'line',
            data: {
                labels: hasilSolusiData,
                datasets: [{
                    label: 'Nilai',
                    backgroundColor: '#0694a2',
                    borderColor: '#0694a2',
                    data: [{{ $hasilNilaiData }}],
                    fill: false,
                }, ],
            },
            options: {
                responsive: true,
                legend: {
                    display: false,
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true,
                },
                scales: {
                    x: {
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Alternatif',
                        },
                    },
                    y: {
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value',
                        },
                    },
                },
            },
        }

        // change this to the id of your chart element in HMTL
        const lineCtx = document.getElementById('line')
        window.myLine = new Chart(lineCtx, lineConfig)
    </script>
@endsection
