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
                <div class="mb-7 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="flex justify-between items-center d p-4 mb-5">
                        <div class="flex space-x-3">
                            <div class="flex space-x-3 items-center">
                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Hasil Perhitungan</h2>
                                <form action="{{ route('penilaian.pdf_hasil') }}" method="post" enctype="multipart/form-data" target="_blank">
                                    @csrf
                                    <button type="submit" class="btn btn-sm text-white dark:text-gray-800 normal-case bg-rose-600 hover:bg-rose-600 hover:bg-opacity-70 hover:border-opacity-70 dark:bg-rose-300 dark:hover:bg-rose-300 dark:hover:bg-opacity-90 dark:border-rose-300">
                                        <i class="ri-file-pdf-line"></i>
                                        Export PDF
                                    </button>
                                </form>
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
            $('#tabel_data_hasil').DataTable({
                scrollX: true,
                ordering: false,
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
