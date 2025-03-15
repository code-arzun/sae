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
                    <a href="{{ route('writer.index') }}" class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat Ulang Halaman"><i class="fa fa-refresh mb-1 mt-1"></i></a>
                </div>
                <div class="row d-flex flex-wrap align-items-center justify-content-between">
                    <div class="mr-3">
                        <h5>Data Penulis</h5>
                    </div>
                    <div class="">
                        <a href="{{ route('writer.create') }}" class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Customer"><i class="fa fa-plus mb-1 mt-1"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row & Pencarian -->
        <div class="col-lg-12 mb-3">
            <form action="{{ route('writer.index') }}" method="get">
                <div class="row align-items-start">
                    <div class="form-group col-sm-3">
                        <select name="writerjob_id" id="writerjob_id" class="form-control"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Sales" onchange="this.form.submit()">
                            {{-- <option selected disabled>-- Profesi --</option> --}}
                            <option value="" @if(request('writerjob_id') == 'null') selected="selected" @endif>Semua</option>
                            @foreach($writerjobs as $writerjob)
                                <option value="{{ $writerjob->writerjob_id }}" {{ request('writerjob_id') == ($writerjob->writerjob_id ?? null) ? 'selected' : '' }}>
                                    {{ $writerjob->writerjob->nama ?? '-- Profesi --' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <select name="writercategory_id" id="writercategory_id" class="form-control"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Sales" onchange="this.form.submit()">
                            <option value="" @if(request('writercategory_id') == 'null') selected="selected" @endif>Semua</option>
                            @foreach($writercategories as $writercategory)
                                <option value="{{ $writercategory->writercategory_id }}" {{ request('writercategory_id') == ($writercategory->writercategory_id ?? null) ? 'selected' : '' }}>
                                    {{ $writercategory->writercategory->nama ?? '-- Kategori --' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm">
                        <input type="text" id="search" class="form-control" name="search" 
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Ketik untuk melakukan pencarian!"
                            onblur="this.form.submit()" placeholder="Ketik disini untuk melakukan pencarian!" value="{{ request('search') }}">
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-12">
            <div class="dt-responsive table-responsive mb-3">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>@sortablelink('NamaPenulis', 'Nama Penulis')</th>
                            <th>@sortablelink('writerjob', 'Profesi Penulis')</th>
                            <th>@sortablelink('writercategory_id', 'Kategori Penulis')</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($writers as $writer)
                        <tr>
                            <td>{{ (($writers->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>
                                <img class="avatar-60 rounded me-3" src="{{ $writer->photo ? asset('storage/writers/'.$writer->photo) : asset('assets/images/user/1.png') }}">
                                <b>{{ $writer->NamaPenulis }}</b>
                            </td>
                            {{-- <td><b>{{ $writer->writerjob->nama }}</b></td> --}}
                            <td><b>{{ optional($writer->writerjob)->nama ?? '-' }}</b></td>
                            <td><b>{{ $writer->writercategory->nama ?? '-'  }}</b></td>
                            {{-- @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Publishing', 'Admin'])) --}}
                            {{-- <td>{{ $writer->employee->name }}</td> --}}
                            {{-- @endif --}}
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    <a class="badge badge-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="View"
                                        href="{{ route('writer.show', $writer->id) }}" method="get"><i class="ri-eye-line"></i>
                                    </a>
                                    @if (auth()->user()->hasAnyRole('Super Admin', 'Manajer Publishing', 'Admin'))
                                    <a class="badge badge-success me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Edit"
                                        href="{{ route('writer.edit', $writer->id) }}" method="get"><i class="ri-pencil-line"></i>
                                    </a>
                                    <form action="{{ route('writer.destroy', $writer->id) }}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <a type="submit" class="badge badge-warning border-none" onclick="return confirm('Are you sure you want to delete this record?')" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Delete"><i class="ri-delete-bin-line me-0"></i></a>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $writers->links() }}
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection
