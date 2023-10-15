@extends('dashboard.layouts.app')

@section('container')
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ $judul }} <span class="text-purple-600 dark:text-purple-300">{{ $kriteria->nama }}</span>
        </h2>
    </div>

    <div>
        <section class="mt-3">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <div class="flex justify-start items-center mb-5">
                    <div class="flex space-x-3">
                        <div class="flex space-x-3 items-center">
                            <form action="{{ route('matriks_kriteria.hitung', ['kriteria_id' => $kriteria->id]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <button type="submit" class="btn btn-primary text-white dark:text-gray-800 normal-case bg-purple-600 hover:bg-opacity-70 hover:border-opacity-70 dark:bg-purple-300 dark:hover:bg-opacity-90">
                                    <i class="ri-add-fill"></i>
                                    Hitung AHP Sub Kriteria
                                </button>
                            </form>
                            <a href="{{ route('sub_kriteria') }}" class="btn normal-case bg-gray-300 hover:bg-gray-400 hover:border-gray-400 hover:text-white">Kembali</a>
                        </div>
                    </div>
                </div>

                {{-- Tabel Matriks Perbandingan --}}
                <div class="mb-7 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="flex justify-between items-center d p-4 mb-5">
                        <div class="flex space-x-3">
                            <div class="flex space-x-3 items-center">
                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Matriks Perbandingan</h2>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto p-3">
                        <table id="tabel_data_matriks_perbandingan" class="nowrap w-full text-sm text-left text-gray-500 dark:text-gray-400 stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Sub Kriteria</th>
                                    @foreach ($kategori as $item)
                                        <th scope="col" class="px-4 py-3">{{ $item->nama }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($matriksPerbandingan->unique('kategori_id') as $item)
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">
                                            {{ $item->nama_kategori }}
                                            <a href="{{ route('matriks_perbandingan_kriteria.ubah', ['kriteria_id' => $item->kriteria_id, 'kategori_id' => $item->kategori_id]) }}" class="ml-1"><i class="ri-pencil-fill text-yellow-500"></i></a>
                                        </td>
                                        @foreach ($matriksPerbandingan->where('kategori_id', $item->kategori_id) as $value)
                                            @if ($value->nilai != null)
                                                <td class="px-4 py-3 text-lg">{{ $value->nilai }}</td>
                                            @else
                                                <td class="px-4 py-3 text-lg">0</td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col" class="px-4 py-3">Jumlah</th>
                                    @foreach ($kategori as $item)
                                        <th scope="col" class="px-4 py-3">{{ $matriksPerbandingan->where('kategori_id_banding', $item->id)->sum('nilai') }}</th>
                                    @endforeach
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                @if ($matriksNilai->where('kriteria_id', $kriteria->id)->first() != null && $matriksNilai->where('kategori_id', $kategori->last()->id)->first() != null)
                    {{-- Tabel Matriks Nilai --}}
                    <div class="mb-7 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div class="flex justify-between items-center d p-4 mb-5">
                            <div class="flex space-x-3">
                                <div class="flex space-x-3 items-center">
                                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Matriks Nilai</h2>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto p-3">
                            <table id="tabel_data_matriks_nilai" class="nowrap w-full text-sm text-left text-gray-500 dark:text-gray-400 stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">Sub Kriteria</th>
                                        @foreach ($kategori as $item)
                                            <th scope="col" class="px-4 py-3">{{ $item->nama }}</th>
                                        @endforeach
                                        <th scope="col" class="px-4 py-3">Jumlah</th>
                                        <th scope="col" class="px-4 py-3">Prioritas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($matriksNilai->unique('kategori_id') as $item)
                                        <tr class="border-b dark:border-gray-700">
                                            <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">
                                                {{ $item->nama_kategori }}
                                            </td>
                                            @foreach ($matriksNilai->where('kategori_id', $item->kategori_id) as $value)
                                                <td class="px-4 py-3 text-lg">{{ round($value->nilai, 3) }}</td>
                                            @endforeach
                                            <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">
                                                {{ round($matriksNilai->where('kategori_id', $item->kategori_id)->sum('nilai'), 3) }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">
                                                {{ round($matriksNilai->where('kategori_id', $item->kategori_id)->sum('nilai') / $matriksNilai->unique('kategori_id')->count(), 3) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Tabel Matriks Penjumlahan --}}
                    <div class="mb-7 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div class="flex justify-between items-center d p-4 mb-5">
                            <div class="flex space-x-3">
                                <div class="flex space-x-3 items-center">
                                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Matriks Penjumlahan</h2>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto p-3">
                            <table id="tabel_data_matriks_penjumlahan" class="nowrap w-full text-sm text-left text-gray-500 dark:text-gray-400 stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">Sub Kriteria</th>
                                        @foreach ($kategori as $item)
                                            <th scope="col" class="px-4 py-3">{{ $item->nama }}</th>
                                        @endforeach
                                        <th scope="col" class="px-4 py-3">Jumlah</th>
                                        <th scope="col" class="px-4 py-3">Prioritas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($matriksPenjumlahan->unique('kategori_id') as $item)
                                        <tr class="border-b dark:border-gray-700">
                                            <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">
                                                {{ $item->nama_kategori }}
                                            </td>
                                            @foreach ($matriksPenjumlahan->where('kategori_id', $item->kategori_id) as $value)
                                                <td class="px-4 py-3 text-lg">{{ round($value->nilai, 3) }}</td>
                                            @endforeach
                                            <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">
                                                {{ round($matriksPenjumlahan->where('kategori_id', $item->kategori_id)->sum('nilai'), 3) }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">
                                                {{ round($matriksPenjumlahanPrioritas->where('kategori_id', $item->kategori_id)->first()->prioritas, 3) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Tabel Rasio Konsistensi --}}
                    <div class="mb-7 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div class="flex justify-between items-center d p-4 mb-5">
                            <div class="flex space-x-3">
                                <div class="flex space-x-3 items-center">
                                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Rasio Konsistensi</h2>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto p-3">
                            <table id="tabel_data_rasio_konsistensi" class="nowrap w-full text-sm text-left text-gray-500 dark:text-gray-400 stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">Kriteria</th>
                                        <th scope="col" class="px-4 py-3">Matriks Penjumlahan <br> (Jumlah)</th>
                                        <th scope="col" class="px-4 py-3">Matriks Nilai <br> (Prioritas)</th>
                                        <th scope="col" class="px-4 py-3">Hasil</th>
                                        <th scope="col" class="px-4 py-3">Matriks Penjumlahan <br> (Prioritas)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kategori as $item)
                                        <tr class="border-b dark:border-gray-700">
                                            <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">
                                                {{ $item->nama }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">
                                                {{ round($matriksPenjumlahan->where('kategori_id', $item->id)->sum('nilai'), 3) }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">
                                                {{ round($matriksNilai->where('kategori_id', $item->id)->sum('nilai') / $matriksNilai->unique('kategori_id')->count(), 3) }}
                                            </td>
                                            @php
                                                $jumlah = $matriksPenjumlahan->where('kategori_id', $item->id)->sum('nilai');
                                                $prioritas = $matriksNilai->where('kategori_id', $item->id)->sum('nilai') / $matriksNilai->unique('kategori_id')->count();

                                                $hasil = round($jumlah + $prioritas, 3);
                                            @endphp
                                            <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">
                                                {{ round($hasil, 3) }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 dark:text-gray-400 uppercase font-semibold">
                                                {{ round($matriksPenjumlahanPrioritas->where('kategori_id', $item->id)->first()->prioritas, 3) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        @php
                                            $hasilRasio = 0;
                                            foreach ($kategori as $item) {
                                                $jumlah = $matriksPenjumlahan->where('kategori_id', $item->id)->sum('nilai');
                                                $prioritas = $matriksNilai->where('kategori_id', $item->id)->sum('nilai') / $matriksNilai->unique('kategori_id')->count();
                                                $hasilRasio += round($jumlah + $prioritas, 3);
                                            }
                                        @endphp
                                        <th scope="col" colspan="3" class="px-4 py-3 text-center">Jumlah</th>
                                        <th scope="col" colspan="2" class="px-4 py-3">{{ round($hasilRasio, 3) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="divider"></div>

                        @php
                            $jmlKategori = $kategori->count();
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
                                        $lamdaMaks1 = $hasilRasio / $jmlKategori;
                                        $CI1 = ($lamdaMaks1 - $jmlKategori) / $jmlKategori;
                                    @endphp
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">Jumlah Kriteria <span class="font-normal">(n)</span></td>
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">
                                            {{ $jmlKategori }}
                                        </td>
                                    </tr>
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">Indeks Random Consistency (IR)</td>
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">
                                            {{ $IR }}
                                        </td>
                                    </tr>
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">λ maks <span class="font-normal">(Jumlah / n)</span></td>
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">
                                            {{ round($lamdaMaks1, 3) }}
                                        </td>
                                    </tr>
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">Nilai Consistency Index (CI) <span class="font-normal">((λ maks - n)/n)</span></td>
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">
                                            {{ round($CI1, 3) }}
                                        </td>
                                    </tr>
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">Nilai Cocsistency Ratio (CR) <span class="font-normal">(CI / IR)</span></td>
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
                                        $lamdaMaks2 = $matriksPenjumlahanPrioritas->sum('prioritas') / $jmlKategori;
                                        $CI2 = ($lamdaMaks2 - $jmlKategori) / ($jmlKategori-1);
                                    @endphp
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">Jumlah Kriteria <span class="font-normal">(n)</span></td>
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">
                                            {{ $jmlKategori }}
                                        </td>
                                    </tr>
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">Indeks Random Consistency (IR)</td>
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">
                                            {{ $IR }}
                                        </td>
                                    </tr>
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">λ maks <span class="font-normal">(Jumlah / n)</span></td>
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">
                                            {{ round($lamdaMaks2, 3) }}
                                        </td>
                                    </tr>
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">Nilai Consistency Index (CI) <span class="font-normal">((λ maks - n)/(n-1))</span></td>
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">
                                            {{ round($CI2, 3) }}
                                        </td>
                                    </tr>
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-400 font-semibold">Nilai Cocsistency Ratio (CR) <span class="font-normal">(CI / IR)</span></td>
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
                @endif
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#tabel_data_matriks_perbandingan').DataTable({
                // responsive: true,
                scrollX: true,
                order: [],
            })
            .columns.adjust()
            .responsive.recalc();

            $('#tabel_data_matriks_nilai').DataTable({
                // responsive: true,
                scrollX: true,
                order: [],
            })
            .columns.adjust()
            .responsive.recalc();

            $('#tabel_data_matriks_penjumlahan').DataTable({
                // responsive: true,
                scrollX: true,
                order: [],
            })
            .columns.adjust()
            .responsive.recalc();

            $('#tabel_data_rasio_konsistensi').DataTable({
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
                        "<b>Sub Kriteria: {{ session('berhasil')[1] }} </b>",
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
