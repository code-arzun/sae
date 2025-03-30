@extends('layout.main')

@section('container')

<div class="d-flex justify-content-between mb-3">
    <div>
        <h2>{{ $title }}</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-default-icon">
                @include('finance.cashflow.category.partials.breadcrumb')
            </ol>
        </nav>
    </div>
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahTransaksi">Buat Transaksi Baru</button>
        <!-- Create -->
        @include('finance.cashflow.create')
    </div>
</div>

<div class="dt-responsive table-responsive mb-3">
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Divisi</th>
                <th>Jenis Transaksi</th>
                <th colspan="2">Kategori</th>
                <th>Keterangan</th>
                <th>Kode</th>
                <th>Nominal</th>
                <th>Diinput oleh</th>
                <th>Diinput pada</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cashflows as $cashflow)
            <tr class="text-center">
                <td>{{ Carbon\Carbon::parse($cashflow->date)->translatedformat('l, d F Y') }}</td>
                <td>
                    {{ $cashflow->department->name }}
                </td>
                <td>
                    <span class="badge {{ $cashflow->cashflowcategory->type === 'Pemasukan' ? 'bg-success' : 'bg-danger' }}">
                        {{ $cashflow->cashflowcategory->type }}
                    </span>
                </td>
                <td>{{ $cashflow->cashflowcategory->category }}</td>
                <td>{{ $cashflow->cashflowcategory->detail }}</td>
                <td>{{ $cashflow->notes }}</td>
                <td>{{ $cashflow->cashflow_code }}</td>
                <td class="text-end">Rp {{ number_format($cashflow->nominal) }}</td>
                <td>{{ $cashflow->user->employee->name }}</td>
                <td>{{ Carbon\Carbon::parse($cashflow->created_at)->translatedformat('H:i - d M Y') }}</td>
                <td>
                    <form action="{{ route('cashflow.destroy', $cashflow->id) }}" method="POST" style="margin-bottom: 5px">
                        @method('delete')
                        @csrf
                        <div class="d-flex align-items-center list-action">
                            <a class="btn btn-info me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="View"
                                href="{{ route('cashflow.show', $cashflow->id) }}"><i class="ri-eye-line me-0"></i>
                            </a>
                            <a class="btn btn-success me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                href="{{ route('cashflow.edit', $cashflow->id) }}"><i class="ri-pencil-line me-0"></i>
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

@endsection
