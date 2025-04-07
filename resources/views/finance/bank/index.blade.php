<div class="row">
    <div class="col-md-6">
        <h4>Tambah Bank</h4>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('bank.store') }}" method="POST">
                @csrf
                    <div class=" row align-items-center">
                        <div class="form-group col-md-12">
                            <label for="name">Nama Bank<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama Bank" required>
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <h4>Data Bank</h4>
        <div class="dt-responsive table-responsive mb-3">
            <table class="table bg-white mb-0">
                <thead>
                    <tr>
                        <th>Nama Bank</th>
                        <th width="5%">#</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($banks as $bank)
                    <tr>
                        <th>{{ $bank->name }}</th>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a class="badge bg-warning me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                    href="{{ route('bank.edit', $bank->id) }}"><i class="ti ti-edit me-0"></i>
                                </a>
                                <form action="{{ route('bank.destroy', $bank->id) }}" method="POST" style="margin-bottom: 5px">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="badge bg-danger me-2 border-none" onclick="return confirm('Are you sure you want to delete this record?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="ti ti-trash me-0"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
        
                    @empty
                        @include('layout.partials.session')
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>