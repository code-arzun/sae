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
                    <a href="{{ route('writerjob.index') }}" class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
                </div>
                <div class="row d-flex flex-wrap align-items-center justify-content-between">
                    <div> {{-- <div class="mr-3"> --}}
                        <h4>Profesi Penulis</h4>
                    </div>
                    {{-- <div>
                        <a href="{{ route('writerjob.create') }}" class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Profesi Penulis"><i class="fa fa-plus mb-1 mt-1"></i></a>
                    </div> --}}
                </div>
            </div>
        </div>

        <!-- Daftar Profesi Penulis -->
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
                        @forelse ($writerjobs as $writerjob)
                        <tr>
                            <td class="text-center">{{ $loop->iteration  }}</td>
                            {{-- <td>{{ $writerjob->type }}</td> --}}
                            <td>
                                <b> {{ $writerjob->nama }}</b>
                            </td>
                            <td>
                                {{-- <div class="d-flex align-items-center list-action">
                                    <button class="btn bg-success me-2 btn-edit" data-id="{{ $writerjob->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                        <i class="ri-pencil-line me-0"></i>
                                    </button>
                                    <button class="btn bg-warning me-2 btn-delete" data-id="{{ $writerjob->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                        <i class="ri-delete-bin-line me-0"></i>
                                    </button>
                                </div> --}}
                                <div class="d-flex align-items-center">
                                    <a class="badge bg-success me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Edit"
                                        href="{{ route('writerjob.edit', $writerjob->id) }}"><i class="ri-pencil-line me-0"></i>
                                    </a>
                                    <form action="{{ route('writerjob.destroy', $writerjob->id) }}" method="POST" class="confirmation-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" id="btnDeleteWriterJob" class="badge bg-warning me-2 border-none delete-button" 
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="ri-delete-bin-line me-0"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        @empty
                        <div class="alert text-white bg-danger" role="alert">
                            <div class="iq-alert-text">Data not Found.</div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="ri-close-line"></i>
                            </button>
                        </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- {{ $writerjobs->links() }} --}}
        </div>
        <!-- Buat Baru -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Tambah Profesi</h5>
                    {{-- <form id="addWriterJobForm" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-10">
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" required>
                                <div class="invalid-feedback" id="error-nama"></div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="btnSaveWriterJob" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form> --}}
                    <form id="addWriterJobForm" method="POST" action="{{ route('writerjob.store') }}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-10">
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" required>
                                <div class="invalid-feedback" id="error-nama"></div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="btnSaveWriterJob" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#btnSaveWriterJob').on('click', function () {
            // Ambil data dari form
            let nama = $('#nama').val();
            let _token = $('input[name="_token"]').val();

            // Clear error message
            $('#error-nama').text('').hide();

            // Kirim data menggunakan AJAX
            $.ajax({
                url: '{{ route('writerjob.store') }}',
                type: 'POST',
                data: {
                    nama: nama,
                    _token: _token
                },
                success: function (response) {
                    if (response.success) {
                        // Hitung jumlah baris saat ini di tabel
                        let rowNumber = $('tbody.light-body tr').length + 1;

                        // Tambahkan data ke tabel tanpa reload
                        $('tbody.light-body').append(`
                            <tr>
                                <td class="text-center">${rowNumber}</td>
                                <td><b>${response.data.nama}</b></td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge bg-success me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                            href="/writerjob/${response.data.id}/edit"><i class="ri-pencil-line me-0"></i></a>
                                        <form action="/writerjob/${response.data.id}" method="POST" class="confirmation-form">
                                            @method('delete')
                                            @csrf
                                            <button type="button" class="badge bg-warning me-2 border-none delete-button" 
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="ri-delete-bin-line me-0"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        `);

                        // Reset form
                        $('#addWriterJobForm')[0].reset();
                        showSuccessAlert('Data berhasil ditambahkan!');
                    }
                },
                error: function (xhr) {
                    if (xhr.responseJSON.errors.nama) {
                        $('#error-nama').text(xhr.responseJSON.errors.nama[0]).show();
                    }
                }
            });
        });
        
        // Edit writerjob
        $('.btn-edit').on('click', function () {
            let writerJobId = $(this).data('id');  // Ambil ID writerjob

            // Ambil data writerjob menggunakan AJAX
            $.ajax({
                url: '/writerjob/' + writerJobId + '/edit',  // Ganti dengan URL yang tepat
                type: 'GET',
                success: function (response) {
                    // Isi form dengan data writerjob yang diambil
                    $('#nama').val(response.data.nama);  // Misal, menampilkan 'nama' di form
                    $('#btnSaveWriterJob').text('Update'); // Ganti tombol menjadi "Update"
                    $('#addWriterJobForm').attr('action', '/writerjob/' + writerJobId);  // Ubah action form menjadi route update
                    $('#addWriterJobForm').attr('method', 'PUT'); // Ubah method ke PUT
                }
            });
        });

        // Hapus writerjob
        $('.btn-delete').on('click', function () {
            let writerJobId = $(this).data('id');  // Ambil ID writerjob

            // Gunakan SweetAlert untuk konfirmasi
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Hapus data menggunakan AJAX
                    $.ajax({
                        url: '/writerjob/' + writerJobId,
                        type: 'DELETE',
                        success: function (response) {
                            if (response.success) {
                                // Hapus row dari tabel tanpa reload
                                $('tr[data-id="' + writerJobId + '"]').remove();
                                Swal.fire('Dihapus!', 'Data berhasil dihapus.', 'success');
                            }
                        }
                    });
                }
            });
        });
    });
</script>

{{-- <script>
    $(document).ready(function () {
        // Simpan
        $('#btnSaveWriterJob').on('click', function () {
            // Ambil data dari form
            let nama = $('#nama').val();
            let _token = $('input[name="_token"]').val();

            // Clear error message
            $('#error-nama').text('').hide();

            // Kirim data menggunakan AJAX
            $.ajax({
                url: '{{ route('writerjob.store') }}',
                type: 'POST',
                data: {
                    nama: nama,
                    _token: _token
                },
                success: function (response) {
                    if (response.success) {
                        // Hitung jumlah baris saat ini di tabel
                        let rowNumber = $('tbody.light-body tr').length + 1;

                        // Tambahkan data ke tabel tanpa reload
                        $('tbody.light-body').append(`
                            <tr>
                                <td class="text-center">${rowNumber}</td>
                                <td><b>${response.data.nama}</b></td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge bg-success me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                            href="/writerjob/${response.data.id}/edit"><i class="ri-pencil-line me-0"></i></a>
                                        <form action="/writerjob/${response.data.id}" method="POST" class="d-inline confirmation-form">
                                            @method('delete')
                                            @csrf
                                            <button type="button" class="badge bg-warning me-2 border-none delete-button" 
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="ri-delete-bin-line me-0"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        `);

                        // Reset form
                        $('#addWriterJobForm')[0].reset();
                        showSuccessAlert('Data berhasil ditambahkan!');
                    }
                },
                error: function (xhr) {
                    if (xhr.responseJSON.errors.nama) {
                        $('#error-nama').text(xhr.responseJSON.errors.nama[0]).show();
                    }
                }
            });
        });
        // Edit writerjob
        $('.btn-edit').on('click', function () {
            let writerJobId = $(this).data('id');  // Ambil ID writerjob

            // Ambil data writerjob menggunakan AJAX
            $.ajax({
                url: '/writerjob/' + writerJobId + '/edit',  // Ganti dengan URL yang tepat
                type: 'GET',
                success: function (response) {
                    // Isi form dengan data writerjob yang diambil
                    $('#nama').val(response.data.nama);  // Misal, menampilkan 'nama' di form
                    $('#btnSaveWriterJob').text('Update'); // Ganti tombol menjadi "Update"
                    $('#addWriterJobForm').attr('action', '/writerjob/' + writerJobId);  // Ubah action form menjadi route update
                    $('#addWriterJobForm').attr('method', 'PUT'); // Ubah method ke PUT
                }
            });
        });

        // Hapus writerjob
        $('.btn-delete').on('click', function () {
            let writerJobId = $(this).data('id');  // Ambil ID writerjob

            // Gunakan SweetAlert untuk konfirmasi
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Hapus data menggunakan AJAX
                    $.ajax({
                        url: '/writerjob/' + writerJobId,
                        type: 'DELETE',
                        success: function (response) {
                            if (response.success) {
                                // Hapus row dari tabel tanpa reload
                                $('tr[data-id="' + writerJobId + '"]').remove();
                                Swal.fire('Dihapus!', 'Data berhasil dihapus.', 'success');
                            }
                        }
                    });
                }
            });
        });
    });

</script> --}}