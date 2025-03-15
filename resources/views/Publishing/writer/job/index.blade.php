<div class="modal fade" id="writerJobModal" tabindex="-1" role="dialog" aria-labelledby="writerJobModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Profesi Penulis</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    {{-- <div class="col-lg-12">
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
                                <div> 
                                    <h4>Profesi Penulis</h4>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    
                    <!-- Daftar Profesi Penulis -->
                        <div class="form-group col-lg-12">
                            <form id="addWriterJobForm" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        placeholder="Masukkan Nama Profesi" id="nama" name="nama" required>
                                    <div class="invalid-feedback" id="error-nama"></div>
                                    <div class="input-group-append">
                                        <button type="button" id="btnSaveWriterJob" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="dt-responsive table-responsive mb-3">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th width="3%">No.</th>
                                        <th width="87%">@sortablelink('nama', 'Profesi')</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($writerjobs as $writerjob)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration  }}</td>
                                        <td>
                                            <b> {{ $writerjob->nama }}</b>
                                        </td>
                                        <td>
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
            </div>
        </div>
    </div>
</div>

<script>
    
</script>