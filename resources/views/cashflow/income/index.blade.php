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
            @if (session()->has('error'))
                <div class="alert text-white bg-danger" role="alert">
                    <div class="iq-alert-text">{{ session('success') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Daftar Arus Kas <badge class="badge badge-success ml-1">Masuk</badge></h4>
                    
                </div>
                <div>
                {{-- <a href="{{ route('income.importView') }}" class="btn btn-success add-list">Import</a>
                <a href="{{ route('income.exportData') }}" class="btn btn-warning add-list">Export</a> --}}
                <a href="{{ route('income.create') }}" class="btn btn-primary add-list">Input Pemasukan</a>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <form action="{{ route('income.index') }}" method="get">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="form-group row">
                        <label for="row" class="col-sm-3 align-self-center">Row:</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="row">
                                <option value="10" @if(request('row') == '10')selected="selected"@endif>10</option>
                                <option value="25" @if(request('row') == '25')selected="selected"@endif>25</option>
                                <option value="50" @if(request('row') == '50')selected="selected"@endif>50</option>
                                <option value="100" @if(request('row') == '100')selected="selected"@endif>100</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-3 align-self-center" for="search">Search:</label>
                        <div class="input-group col-sm-8">
                            <input type="text" id="search" class="form-control" name="search" placeholder="Cari Pemasukan" value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text bg-primary"><i class="fa-solid fa-magnifying-glass font-size-20"></i></button>
                                <a href="{{ route('income.index') }}" class="input-group-text bg-danger"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </div>
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
                            <th>@sortablelink('date', 'Tanggal')</th>
                            <th>@sortablelink('department_id', 'Divisi')</th>
                            <th>@sortablelink('cashflowcategory_id', 'Kategori')</th>
                            <th>@sortablelink('cashflowdewati_id', 'Keterangan')</th>
                            <th>@sortablelink('nominal', 'Nominal')</th>
                            <th>@sortablelink('user_id', 'Diinput oleh')</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cashflowincomes as $cashflowincome)
                        <tr class="text-center">
                            <td>{{ (($cashflowincomes->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>{{ Carbon\Carbon::parse($cashflowincome->date)->translatedformat('l, d F Y') }}</td>
                            <td>{{ $cashflowincome->department->name }}</td>
                            <td>{{ $cashflowincome->cashflowdetail->cashflowcategory->name }}</td>
                            <td>{{ $cashflowincome->cashflowdetail->name }}</td>
                            <td class="text-end">Rp {{ number_format($cashflowincome->nominal) }}</td>
                            <td>{{ $cashflowincome->user->employee->name }}</td>
                            <td>
                                <form action="{{ route('income.destroy', $cashflowincome->id) }}" method="POST" style="margin-bottom: 5px">
                                    @method('delete')
                                    @csrf
                                    <div class="d-flex align-items-center list-action">
                                        <a class="btn btn-primary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="View"
                                            href="{{ route('income.show', $cashflowincome->id) }}"><i class="ri-eye-line me-0"></i>
                                        </a>
                                        <a class="btn btn-success me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                            href="{{ route('income.edit', $cashflowincome->id) }}"><i class="ri-pencil-line me-0"></i>
                                        </a>
                                            <button type="submit" class="btn btn-warning me-2 border-none" onclick="return confirm('Are you sure you want to delete this record?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="ri-delete-bin-line me-0"></i></button>
                                    </div>
                                </form>
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
            {{ $cashflowincomes->links() }}
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection
