@extends('dashboard.layouts.app')

@section('container')
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ $judul }}
        </h2>
    </div>

    <div>
        <section class="mt-3">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <div class="flex justify-start items-center mb-5">
                    <div class="flex space-x-3">
                        <div class="flex space-x-3 items-center">
                            <form action="{{ route('penilaian.hitung') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <button type="submit" class="btn btn-primary text-white dark:text-gray-800 normal-case bg-purple-600 hover:bg-opacity-70 hover:border-opacity-70 dark:bg-purple-300 dark:hover:bg-opacity-90">
                                    <i class="ri-add-fill"></i>
                                    Hitung AHP Alternatif
                                </button>
                            </form>
                            <form action="{{ route('penilaian.pdf_ahp') }}" method="post" enctype="multipart/form-data" target="_blank">
                                @csrf
                                <button type="submit" class="btn text-white dark:text-gray-800 normal-case bg-rose-600 hover:bg-rose-600 hover:bg-opacity-70 hover:border-opacity-70 dark:bg-rose-300 dark:hover:bg-rose-300 dark:hover:bg-opacity-90 dark:border-rose-300">
                                    <i class="ri-file-pdf-line"></i>
                                    Export PDF
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Tabel Penilaian Alternatif --}}
                <div class="mb-7 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="flex justify-between items-center d p-4 mb-5">
                        <div class="flex space-x-3">
                            <div class="flex space-x-3 items-center">
                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Penilaian Alternatif</h2>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto p-3">
                        <table id="tabel_data_alternatif" class="nowrap w-full text-sm text-left text-gray-500 dark:text-gray-400 stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Alternatif</th>
                                    @foreach ($kriteria as $item)
                                        <th scope="col" class="px-4 py-3">{{ $item->nama }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->unique('alternatif_id') as $item)
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">
                                            {{ $item->alternatif->nama }}
                                            <a href="{{ route('penilaian.ubah', ['alternatif_id' => $item->alternatif_id]) }}" class="ml-1"><i class="ri-pencil-fill text-yellow-500"></i></a>
                                        </td>
                                        @foreach ($data->where('alternatif_id', $item->alternatif_id) as $value)
                                            @if ($value->sub_kriteria_id != null)
                                                <td class="px-4 py-3 text-lg">{{ $value->subKriteria->kategori->nama }}</td>
                                            @else
                                                <td class="px-4 py-3 text-lg">-</td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Tabel Prioritas Kriteria --}}
                <div class="mb-7 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="flex justify-between items-center d p-4 mb-5">
                        <div class="flex space-x-3">
                            <div class="flex space-x-3 items-center">
                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Prioritas Kriteria</h2>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto p-3">
                        <table id="tabel_data_kriteria" class="nowrap w-full text-sm text-left text-gray-500 dark:text-gray-400 stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Kriteria</th>
                                    <th scope="col" class="px-4 py-3">Prioritas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($matriksNilaiKriteria as $item)
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">
                                            {{ $item->nama_kriteria }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">
                                            {{ round($item->prioritas, 3) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Tabel Prioritas Sub Kriteria --}}
                <div class="mb-7 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="flex justify-between items-center d p-4 mb-5">
                        <div class="flex space-x-3">
                            <div class="flex space-x-3 items-center">
                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Prioritas Sub Kriteria</h2>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto p-3">
                        <table id="tabel_data_sub_kriteria" class="nowrap w-full text-sm text-left text-gray-500 dark:text-gray-400 stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Kriteria</th>
                                    @foreach ($kategori as $item)
                                        <th scope="col" class="px-4 py-3">{{ $item->nama }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kriteria as $item)
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">{{ $item->nama }}</td>
                                        @foreach ($kategori as $value)
                                            <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">
                                                {{ round($matriksNilaiSubKriteria->where('kriteria_id', $item->id)->where('kategori_id', $value->id)->first()->prioritas, 3) }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Tabel Hasil AHP --}}
                <div class="mb-7 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="flex justify-between items-center d p-4 mb-5">
                        <div class="flex space-x-3">
                            <div class="flex space-x-3 items-center">
                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Hasil Perhitungan</h2>
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
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#tabel_data_alternatif').DataTable({
                // responsive: true,
                scrollX: true,
                order: [],
            })
            .columns.adjust()
            .responsive.recalc();

            $('#tabel_data_kriteria').DataTable({
                // responsive: true,
                scrollX: true,
                order: [],
            })
            .columns.adjust()
            .responsive.recalc();

            $('#tabel_data_sub_kriteria').DataTable({
                // responsive: true,
                scrollX: true,
                order: [],
            })
            .columns.adjust()
            .responsive.recalc();

            $('#tabel_data_hasil').DataTable({
                // responsive: true,
                scrollX: true,
                order: [],
            })
            .columns.adjust()
            .responsive.recalc();
        });

        @if (session()->has('berhasil'))
            Swal.fire({
                title: 'Berhasil',
                @if (session('berhasil')[1] == 0)
                    html:
                        "<p>{{ session('berhasil')[0] }}</p>",
                @else
                    html:
                        "<p>{{ session('berhasil')[0] }}</p>" +
                        "<div class='divider'></div>" +
                        "<b>Alternatif: {{ session('berhasil')[1] }} </b>",
                @endif
                icon: 'success',
                confirmButtonColor: '#6419E6',
                confirmButtonText: 'OK',
            })
        @endif

        @if (session()->has('gagal'))
            Swal.fire({
                title: 'Gagal',
                text: '{{ session('gagal') }}',
                icon: 'error',
                confirmButtonColor: '#6419E6',
                confirmButtonText: 'OK',
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                title: 'Gagal',
                text: @foreach ($errors->all() as $error) '{{ $error }}' @endforeach,
                icon: 'error',
                confirmButtonColor: '#6419E6',
                confirmButtonText: 'OK',
            })
        @endif
    </script>
@endsection
