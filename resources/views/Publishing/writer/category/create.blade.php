{{-- @extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <!-- <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Tambah Kategori Penulis</h4>
                    </div>
                </div> -->

                <div class="card-body">
                    <form action="{{ route('writercategory.store') }}" method="POST">
                    @csrf
                        <!-- begin: Input Data -->
                        <div class=" row align-items-center">
                            <div class="form-group col-md-12">
                                <label for="nama">Nama Kategori<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"  required>
                                @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- end: Input Data -->
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Simpan</button>
                            <a class="btn bg-danger" href="{{ route('writercategory.index') }}">Batalkan</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>


@include('components.preview-img-form')
@endsection --}}

<!-- Modal for Writer Category -->
<div class="modal fade" id="writerCategoryModal" tabindex="-1" role="dialog" aria-labelledby="writerCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        {{-- <div class="modal-header">
            <h5 class="modal-title" id="writerCategoryModalLabel">Tambah Kategori Penulis</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div> --}}
        <form id="writerCategoryForm" action="{{ route('writercategory.store') }}" method="POST">
            @csrf
            <div class="modal-body">
            <div class="form-group">
                <label for="writercategory_nama">Tambah Kategori Penulis</label>
                <input type="text" class="form-control" id="writercategory_nama" name="nama" placeholder="Nama Kategori" required>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
        </div>
    </div>
</div>
