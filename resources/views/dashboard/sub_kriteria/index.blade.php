@extends('dashboard.layouts.app')

@section('container')
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ $judul }}
        </h2>
    </div>

    <div>
        <section class="mt-10">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                    @if ($data != null)
                        @foreach ($data as $item)
                            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden mb-10">
                                <div class="flex justify-between items-center d p-4">
                                    <div class="flex space-x-3">
                                        <div class="flex space-x-3 items-center">
                                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Sub Kriteria: <span class="text-purple-600 dark:text-purple-300">{{ $item['kriteria'] }}</span></h2>
                                        </div>
                                    </div>
                                    <div class="flex space-x-3">
                                        <div class="flex space-x-3 items-center">
                                            <label for="add_button" id="label_{{ $item['kriteria_id'] }}" class="btn btn-primary btn-sm text-white dark:text-gray-800 normal-case bg-purple-600 hover:bg-opacity-70 hover:border-opacity-70 dark:bg-purple-300 dark:hover:bg-opacity-90">
                                                <i class="ri-add-fill"></i>
                                                Tambah {{ $judul }}
                                            </label>
                                            @if ($subKriteria->where('kriteria_id', $item['kriteria_id'])->count() != $kategori->count())
                                                <button class="btn btn-sm btn-warning text-white normal-case" onclick="buttonMatriksDisable()">
                                                    <i class="ri-pencil-fill"></i>
                                                    Matriks
                                                </button>
                                            @else
                                                <a href="{{ route("perhitungan_kriteria.ubah", ["kriteria_id" => $item['kriteria_id']]) }}" class="btn btn-sm btn-warning text-white normal-case">
                                                    <i class="ri-pencil-fill"></i>
                                                    Matriks
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="overflow-x-auto p-3">
                                    <table id="{{ 'tabel_data_' . $item['kriteria_id'] }}" class="w-full text-sm text-left text-gray-500 dark:text-gray-400 stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-4 py-3">Nama</th>
                                                <th scope="col" class="px-4 py-3">Kategori</th>
                                                <th scope="col" class="px-4 py-3">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($item['sub_kriteria'] as $subKriteria)
                                                <tr class="border-b dark:border-gray-700">
                                                    <td class="px-4 py-3">{{ $subKriteria['nama'] }}</td>
                                                    <td class="px-4 py-3">{{ $subKriteria->kategori->nama }}</td>
                                                    <td class="px-4 py-3">
                                                        <label for="edit_button" class="btn btn-sm btn-warning text-white" onclick="return edit_button('{{ $subKriteria['id'] }}', '{{ $item['kriteria'] }}')">
                                                            <i class="ri-pencil-line"></i>
                                                        </label>
                                                        <button class="btn btn-sm btn-error text-white" onclick="return delete_button('{{ $subKriteria['id'] }}', '{{ $item['kriteria'] }}', '{{ $subKriteria['nama'] }}');">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                            <div class="flex justify-start items-center d p-4 gap-y-3">
                                <div class="flex space-x-3">
                                    <div class="flex space-x-3 items-center">
                                        <h2 class="text-xl font-bold text-purple-600 dark:text-purple-300">Sub Kriteria</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="overflow-x-auto p-3">
                                <table id="tabel_data" class="w-full text-sm text-left text-gray-500 dark:text-gray-400 stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-3">Nama</th>
                                            <th scope="col" class="px-4 py-3">Kategori</th>
                                            <th scope="col" class="px-4 py-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
            </div>

            {{-- Form Tambah Data --}}
            <input type="checkbox" id="add_button" class="modal-toggle" />
            <div class="modal">
                <div class="modal-box">
                    <form action="{{ route('sub_kriteria.simpan') }}" method="post" enctype="multipart/form-data">
                        <h3 class="font-bold text-lg">Tambah {{ $judul }} <span class="text-purple-600" id="title_add_button"></span></h3>
                            @csrf
                            <input type="number" name="kriteria_id" id="kriteria_id_add_button" hidden>
                            <div class="form-control w-full max-w-xs">
                                <label class="label">
                                    <span class="label-text">Nama</span>
                                </label>
                                <input type="text" name="nama" placeholder="Type here" class="input input-bordered w-full max-w-xs text-gray-800" value="{{ old('nama') }}" required />
                                <label class="label">
                                    @error('nama')
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    @enderror
                                </label>
                            </div>
                            <div class="form-control w-full max-w-xs">
                                <label class="label">
                                    <span class="label-text">Kategori</span>
                                </label>
                                <select name="kategori_id" class="select select-bordered w-full max-w-xs text-gray-800" required>
                                    <option disabled selected>Pilih Kategori!</option>
                                    @foreach ($kategori as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                <label class="label">
                                    @error('kategori_id')
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    @enderror
                                </label>
                            </div>
                        <div class="modal-action">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <label for="add_button" class="btn">Batal</label>
                        </div>
                    </form>
                </div>
                <label class="modal-backdrop" for="add_button">Close</label>
            </div>

            {{-- Form Ubah Data --}}
            <input type="checkbox" id="edit_button" class="modal-toggle" />
            <div class="modal">
                <div class="modal-box" id="edit_form">
                    <form action="{{ route('sub_kriteria.perbarui') }}" method="post" enctype="multipart/form-data">
                        <h3 class="font-bold text-lg">Ubah {{ $judul }}: <span class="text-purple-600 dark:text-purple-300" id="title_form"><span class="loading loading-dots loading-md"></span></span></h3>
                            @csrf
                            <input type="number" name="id" id="id" hidden />
                            <div class="form-control w-full max-w-xs">
                                <label class="label">
                                    <span class="label-text">Nama</span>
                                    <span class="label-text-alt" id="loading_edit1"></span>
                                </label>
                                <input type="text" name="nama" placeholder="Type here" class="input input-bordered w-full text-gray-800" required />
                                <label class="label">
                                    @error('nama')
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    @enderror
                                </label>
                            </div>
                            <div class="form-control w-full max-w-xs">
                                <label class="label">
                                    <span class="label-text">Kategori</span>
                                    <span class="label-text-alt" id="loading_edit2"></span>
                                </label>
                                <select name="kategori_id" class="select select-bordered w-full max-w-xs text-gray-800" required>
                                    <option disabled>Pilih Kategori!</option>
                                    @foreach ($kategori as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                <label class="label">
                                    @error('kategori_id')
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    @enderror
                                </label>
                            </div>
                        <div class="modal-action">
                            <button type="submit" class="btn btn-success">Perbarui</button>
                            <label for="edit_button" class="btn">Batal</label>
                        </div>
                    </form>
                </div>
                <label class="modal-backdrop" for="edit_button">Close</label>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            @if ($data != null)
                @foreach ($data as $item)
                    $("#tabel_data_{{ $item['kriteria_id'] }}").DataTable({
                        responsive: true,
                        order: [],
                    })
                    .columns.adjust()
                    .responsive.recalc();

                    $("#label_{{ $item['kriteria_id'] }}").click(function () {
                        $("#title_add_button").html("{{ $item['kriteria'] }}");
                        $("#kriteria_id_add_button").val("{{ $item['kriteria_id'] }}");
                    });
                @endforeach
            @else
                $("#tabel_data").DataTable({
                        responsive: true,
                        order: [],
                    })
                    .columns.adjust()
                    .responsive.recalc();
            @endif
        });

        @if (session()->has('berhasil'))
            Swal.fire({
                title: 'Berhasil',
                text: '{{ session('berhasil') }}',
                icon: 'success',
                confirmButtonColor: '#6419E6',
                confirmButtonText: 'OK',
            });
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

        function edit_button(id, kriteria) {
            // Loading effect start
            let loading = `<span class="loading loading-dots loading-md text-purple-600"></span>`;
            $("#title_form").html(loading);
            $("#loading_edit1").html(loading);
            $("#loading_edit2").html(loading);

            $.ajax({
                type: "get",
                url: "{{ route('sub_kriteria.ubah') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                success: function (data) {
                    // console.log(data);
                    let items = [];
                    $.each(data, function(key, val) {
                        items.push(val);
                    });

                    console.log(items);

                    $("#title_form").html(kriteria);
                    $("input[name='id']").val(items[0]);
                    $("input[name='nama']").val(items[1]);
                    $("select[name='kategori_id']").val(items[3]);

                    // Loading effect end
                    loading = "";
                    $("#loading_edit1").html(loading);
                    $("#loading_edit2").html(loading);
                }
            });
        }

        function delete_button(id, kriteria, nama) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html:
                    "<p>Data tidak dapat dipulihkan kembali!</p>" +
                    "<div class='divider'></div>" +
                    "<b>Data: Kriteria " + kriteria + " (" + nama + ")</b>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6419E6',
                cancelButtonColor: '#F87272',
                confirmButtonText: 'Hapus Data!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('sub_kriteria.hapus') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id
                        },
                        success: function (response) {
                            Swal.fire({
                                title: 'Data berhasil dihapus!',
                                icon: 'success',
                                confirmButtonColor: '#6419E6',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        },
                        error: function (response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Data gagal dihapus!',
                            })
                        }
                    });
                }
            })
        }

        function buttonMatriksDisable() {
            Swal.fire({
                title: 'Gagal',
                text: 'Sub Kriteria belum terisi dengan semua Kategori',
                icon: 'error',
                confirmButtonColor: '#6419E6',
                confirmButtonText: 'OK',
            });
        }
    </script>
@endsection
