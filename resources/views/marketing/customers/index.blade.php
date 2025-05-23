@extends('layout.main')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('customers.index') }}">Data Customer</a></li>
@endsection

@section('action-button')
    <a href="{{ route('customers.create') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahCustomer">Tambah Customer Baru</a>
    @include('marketing.customers.create')
@endsection


@section('container')

<!-- Filter -->
<form action="{{ route('customers.index') }}" method="get">
    <div class="row align-items-start">
        @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
        <div class="form-group col-sm-2">
            <select name="employee_id" id="employee_id" class="form-control"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Sales" onchange="this.form.submit()">
                <option selected disabled>-- Pilih Sales --</option>
                <option value="" @if(request('employee_id') == 'null') selected="selected" @endif>Semua</option>
                @foreach($sales as $employee)
                <option value="{{ $employee->employee_id }}" {{ request('employee_id') == $employee->employee_id ? 'selected' : '' }}>
                    {{ $employee->employee->name }} <!-- Adjust this to display employee's name or other details -->
                </option>
            @endforeach
            </select>
        </div>
        @endif
        <div class="form-group col-sm-1">
            <select name="jenjang" id="jenjang" class="form-control"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Jenjang" onchange="this.form.submit()">
                <option selected disabled>-- Jenjang --</option>
                <option value="" @if(request('jenjang') == 'null') selected="selected" @endif>Semua</option>
                <option value="SD" @if(request('jenjang') == 'SD') selected="selected" @endif>SD</option>
                <option value="SMP" @if(request('jenjang') == 'SMP') selected="selected" @endif>SMP</option>
                <option value="SMA" @if(request('jenjang') == 'SMA') selected="selected" @endif>SMA</option>
            </select>
        </div>
        <div class="form-group col-sm-2">
            <select name="Potensi" id="Potensi" class="form-control"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Filter berdasarkan Potensi" onchange="this.form.submit()">
                <option selected disabled>-- Potensi --</option>
                <option value="" @if(request('Potensi') == 'null') selected="selected" @endif>Semua</option>
                <option value="Prioritas" @if(request('Potensi') == 'Prioritas') selected="selected" @endif>Prioritas</option>
                <option value="Tinggi" @if(request('Potensi') == 'Tinggi') selected="selected" @endif>Tinggi</option>
                <option value="Sedang" @if(request('Potensi') == 'Sedang') selected="selected" @endif>Sedang</option>
                <option value="Rendah" @if(request('Potensi') == 'Rendah') selected="selected" @endif>Rendah</option>
            </select>
        </div>
        <div class="form-group col-sm">
            <input type="text" id="search" class="form-control" name="search" 
                data-bs-toggle="tooltip" data-bs-placement="top" title="Ketik untuk melakukan pencarian!"
                onblur="this.form.submit()" placeholder="Ketik disini untuk melakukan pencarian!" value="{{ request('search') }}">
        </div>
    </div>
</form>

<!-- Data -->
<div class="dt-responsive">
    <table class="table table-responsive nowrap">
        <thead>
            {{-- <th width="3px">No.</th> --}}
            <th>Nama Lembaga</th>
            <th colspan="2">Nama Customer</th>
            <th width="150px">Jabatan</th>
            <th width="100px">Potensi</th>
            @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
            <th width="250px">Sales</th>
            @endif
            <th width="50px">#</th>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
            <tr>
                {{-- <td>{{ (($customers->currentPage() * 10) - 10) + $loop->iteration  }}</td> --}}
                <td><b data-bs-toggle="popover" title="{{ $customer->NamaLembaga }}" data-content="{{ $customer->AlamatLembaga }}">{{ $customer->NamaLembaga }}</b></td>
                <td width="100px"><img src="{{ $customer->FotoCustomer ? asset($customer->FotoCustomer) : asset(Storage::url('customers/default.jpg')) }}" alt="{{ $customer->NamaCustomer }}" class="img-fluid"></td>
                <td>
                    <div class="d-flex align-items-center">
                        
                        <b class="ml-3">{{ $customer->NamaCustomer }}</b>
                    </div>
                </td>
                <td>{{ $customer->Jabatan }}</td>
                <td class="text-center">
                    <span class="badge {{ strpos($customer->Potensi, 'Tinggi') !== false ? 'bg-success' : (strpos($customer->Potensi, 'Sedang') !== false ? 'bg-warning' : 
                        (strpos($customer->Potensi, 'Rendah') !== false ? 'bg-danger' : '-')) }}">
                        {{ $customer->Potensi }}
                    </span>
                </td>
                @if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin']))
                <td>{{ $customer->employee->name }}</td>
                @endif
                <td width="200px">
                    <div class="d-flex align-items-center justify-content-center">
                        <a class="badge bg-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail"
                                href="{{ route('customers.show', $customer->id) }}"><i class="ti ti-eye"></i>
                        </a>
                        <!-- Edit -->
                        <a href="#" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#editCustomer{{ $customer->id }}"><i class="ti ti-edit"></i></a>
                        @include('marketing.customers.edit')
                        @if (auth()->user()->hasAnyRole('Super Admin', 'Manajer Marketing', 'Admin'))
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="confirmation-form">
                            @method('delete')
                            @csrf
                            <button type="button" class="badge bg-danger delete-button" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="ti ti-trash"></i></button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection