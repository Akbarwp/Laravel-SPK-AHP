@extends('dashboard.layouts.app')

@section('container')
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ $judul }} <span class="text-purple-600 dark:text-purple-300">{{ $data->alternatif->nama }}</span>
        </h2>
    </div>

    <div>
        <section class="mt-3">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden py-5 pl-10">
                    <form action="{{ route('penilaian.perbarui', ['alternatif_id' => $data->alternatif_id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="number" name="alternatif_id" value="{{ $data->alternatif_id }}" hidden>
                        @foreach ($subKriteria->unique('kriteria_id') as $item)
                            <div class="form-control w-full max-w-md">
                                <div class="form-control w-full max-w-xs mb-3">
                                    <label class="label">
                                        <span class="label-text font-bold text-purple-700 dark:text-purple-300">{{ $item->kriteria->nama }}</span>
                                    </label>
                                    <select name="{{ $item->kriteria_id }}" class="select select-bordered" required>
                                        <option disabled selected>Pilih Sub Kriteria!</option>
                                        @foreach ($subKriteria->where('kriteria_id', $item->kriteria_id) as $value)
                                            @if ($data->where('alternatif_id', $data->alternatif_id)->where('kriteria_id', $item->kriteria_id)->first()->sub_kriteria_id == $value->id)
                                                <option value="{{ $value->id }}" selected>{{ $value->nama }}</option>
                                            @else
                                                <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <label class="label">
                                    @error('nilai_{{ $item->nama_kriteria_banding }}')
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    @enderror
                                </label> --}}
                            </div>
                        @endforeach
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="{{ route('penilaian') }}" class="btn normal-case bg-gray-300 hover:bg-gray-400 hover:border-gray-400 hover:text-white">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
