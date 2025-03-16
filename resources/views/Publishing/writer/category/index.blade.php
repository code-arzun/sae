@extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            @if (session()->has('success'))
                <div class="alert text-white bg-success" role="alert">
                    <div class="iq-alert-text">{{ session('success') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
            <div class="col d-flex flex-wrap align-items-top justify-content-between mb-3">
                <div class="row">
                    <a href="{{ url()->previous() }}" class="badge bg-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i class="fa fa-arrow-left mb-1 mt-1"></i></a>
                    <a href="{{ route('writercategory.index') }}" class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
                </div>
                <div class="row d-flex flex-wrap align-items-center justify-content-between">
                    <div>
                        <h4>Kategori Penulis</h4>
                    </div>
                    {{-- <div class="">
                        <a href="{{ route('writercategory.create') }}" class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Kategori Penulis"><i class="fa fa-plus mb-1 mt-1"></i></a>
                    </div> --}}
                </div>
            </div>
        </div>

        <!-- Daftar Kategori -->
        <div class="col-lg-5">
            <div class="dt-responsive table-responsive mb-3">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th width="3%">No.</th>
                            <th width="87%">@sortablelink('nama', 'Nama')</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($writercategories as $writercategory)
                        <tr>
                            <td class="text-center">{{ $loop->iteration  }}</td>
                            {{-- <td>{{ $writercategory->type }}</td> --}}
                            <td >
                                <b>{{ $writercategory->nama }}</b>    
                            </td>
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    <a class="badge bg-success me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" title="Edit"
                                        href="{{ route('writercategory.edit', $writercategory->id) }}"><i class="ri-pencil-line me-0"></i>
                                    </a>
                                    <form action="{{ route('writercategory.destroy', $writercategory->id) }}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="badge bg-warning me-2 border-none" onclick="return confirm('Are you sure you want to delete this record?')" data-bs-toggle="tooltip" data-bs-placement="top" title="" title="Delete"><i class="ri-delete-bin-line me-0"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        @empty
                        <div class="alert text-white bg-danger" role="alert">
                            <div class="iq-alert-text">Data tidak ditemukan.</div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="ri-close-line"></i>
                            </button>
                        </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- {{ $writercategories->links() }} --}}
        </div>
        <!-- Buat Baru -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Tambah Kategori</h5>
                    <form action="{{ route('writercategory.store') }}" method="POST">
                    @csrf
                        <!-- begin: Input Data -->
                        <div class="row">
                            <div class="col-md-10 mb-3">
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"  required>
                                @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                        <!-- end: Input Data -->
                        {{-- <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection
