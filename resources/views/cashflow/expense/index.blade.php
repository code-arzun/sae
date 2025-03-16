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
                    <h4 class="mb-3">Daftar Arus Kas <badge class="badge badge-danger ml-1">Keluar</badge></h4>
                    
                </div>
                <div>
                {{-- <a href="{{ route('expense.importView') }}" class="btn btn-success add-list">Import</a>
                <a href="{{ route('expense.exportData') }}" class="btn btn-warning add-list">Export</a> --}}
                <a href="{{ route('expense.create') }}" class="btn btn-primary add-list">Input Pengeluaran</a>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <form action="{{ route('expense.index') }}" method="get">
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
                            <input type="text" id="search" class="form-control" name="search" placeholder="Cari Pengeluaran" value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text bg-primary"><i class="fa-solid fa-magnifying-glass font-size-20"></i></button>
                                <a href="{{ route('expense.index') }}" class="input-group-text bg-danger"><i class="fa-solid fa-trash"></i></a>
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
                            {{-- <th>@sortablelink('expense_code', 'Kode')</th> --}}
                            <th>@sortablelink('date', 'Tanggal')</th>
                            <th>@sortablelink('department_id', 'Divisi')</th>
                            <th>@sortablelink('cashflowcategory_id', 'Kategori')</th>
                            <th>@sortablelink('cashflowdewati_id', 'Keterangan')</th>
                            <th>@sortablelink('nominal', 'Nominal')</th>
                            {{-- <th>@sortablelink('notes', 'Catatan')</th> --}}
                            {{-- <th>Bukti Transaksi</th> --}}
                            <th>@sortablelink('user_id', 'Diinput oleh')</th>
                            <th>@sortablelink('user_id', 'Diinput pada')</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cashflowexpenses as $cashflowexpense)
                        <tr class="text-center">
                            <td>{{ (($cashflowexpenses->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            {{-- <td><badge class="badge badge-danger">{{ $cashflowexpense->expense_code }}</badge></td> --}}
                            <td>{{ Carbon\Carbon::parse($cashflowexpense->date)->translatedformat('l, d F Y') }}</td>
                            <td>
                                {{ $cashflowexpense->department->name }}
                                {{-- {{ $cashflowexpense->user->employee->department->name }} --}}
                            </td>
                            <td>{{ $cashflowexpense->cashflowdetail->cashflowcategory->name }}</td>
                            <td>{{ $cashflowexpense->cashflowdetail->name }}</td>
                            <td class="text-end">Rp {{ number_format($cashflowexpense->nominal) }}</td>
                            {{-- <td>{{ $cashflowexpense->notes }}</td> --}}
                            <td>{{ $cashflowexpense->user->employee->name }}</td>
                            {{-- <td>
                                <img class="avatar-60 rounded" src="{{ $cashflowexpense->receipt ? asset('storage/expense/'.$cashflowexpense->receipt) : asset('assets/images/expense/default.webp') }}">
                            </td> --}}
                            <td>{{ Carbon\Carbon::parse($cashflowexpense->created_at)->translatedformat('H:i - d M Y') }}</td>
                            <td>
                                <form action="{{ route('expense.destroy', $cashflowexpense->id) }}" method="POST" style="margin-bottom: 5px">
                                    @method('delete')
                                    @csrf
                                    <div class="d-flex align-items-center list-action">
                                        <a class="btn btn-info me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="View"
                                            href="{{ route('expense.show', $cashflowexpense->id) }}"><i class="ri-eye-line me-0"></i>
                                        </a>
                                        <a class="btn btn-success me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Edit"
                                            href="{{ route('expense.edit', $cashflowexpense->id) }}"><i class="ri-pencil-line me-0"></i>
                                        </a>
                                            <button type="submit" class="btn btn-warning me-2 border-none" onclick="return confirm('Are you sure you want to delete this record?')" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Delete"><i class="ri-delete-bin-line me-0"></i></button>
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
            {{-- {{ $cashflowexpenses->links() }} --}}
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection
