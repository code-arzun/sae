@extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="d-flex justify-content-between align-items-center list-action">
                                <a href="{{ url()->previous() }}"
                                   class="badge bg-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali">
                                   <i class="fa fa-arrow-left"></i>
                                </a>
                                @if ($collection->payment_status == 'Belum dibayar' && auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']))
                                <div class="d-flex ml-auto">
                                    {{-- <form action="{{ route('col.sentStatus') }}" method="POST" class="mr-2">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $collection->id }}">
                                        <button type="submit" class="btn bg-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Kirim"><b>Kirim</b></button>
                                    </form> --}}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Informasi Detail Pembayaran</h4>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row align-items-top">
                        <div class="form-group col-md-3">
                            <label>Tanggal DO</label> <br>
                                <span class="badge bg-primary">{{Carbon\Carbon::parse($collection->collection_date)->translatedformat('l, d F Y') }}</span>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Nomor</label> <br>
                                <span class="badge 
                                    {{ strpos($collection->invoice_no, 'DOR') !== false ? 'badge-primary' : 
                                    (strpos($collection->invoice_no, 'DOH') !== false ? 'badge-danger' : 
                                    (strpos($collection->invoice_no, 'DORS') !== false ? 'badge-success' : 
                                    (strpos($collection->invoice_no, 'DOHS') !== false ? 'badge-warning' : 'badge-secondary'))) }}">
                                    {{ $collection->invoice_no }}
                                </span>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Status </label> <br>
                                <span class="badge 
                                    {{ strpos($collection->payment_status, 'Siap dikirim') !== false ? 'badge-warning' : 
                                       (strpos($collection->payment_status, 'Dikirim') !== false ? 'badge-primary' : 
                                       (strpos($collection->payment_status, 'Terkirim') !== false ? 'badge-success' : 'badge-secondary')) }}">
                                    {{ $collection->payment_status }}
                                </span>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Nomor SO</label> <br>
                            <a class="badge 
                                    {{ strpos($collection->salesorder->invoice_no, 'SOR') !== false ? 'badge-primary' : 
                                    (strpos($collection->salesorder->invoice_no, 'SOH') !== false ? 'badge-danger' : 
                                    (strpos($collection->salesorder->invoice_no, 'SORS') !== false ? 'badge-success' : 
                                    (strpos($collection->salesorder->invoice_no, 'SOHS') !== false ? 'badge-warning' : 'badge-secondary'))) }}" 
                                    href="{{ route('so.orderDetails', $collection->salesorder->id) }}" 
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                    {{ $collection->salesorder->invoice_no }}
                            </a>
                        </div>
                        
                        <div class="form-group col-md-3">
                            <label>Sales</label> <br>
                                <span class="badge bg-primary">
                                {{ $collection->salesorder->customer->employee->name }}
                                </span>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Nama Customer</label>
                            <input type="text" class="form-control bg-white" value="{{ $collection->salesorder->customer->NamaCustomer }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Jabatan</label>
                            <input type="text" class="form-control bg-white" value="{{ $collection->salesorder->customer->Jabatan }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Telp.</label>
                            <input type="text" class="form-control bg-white" value="{{ $collection->salesorder->customer->TelpCustomer }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Alamat</label>
                            <input type="text" class="form-control bg-white" value="{{ $collection->salesorder->customer->AlamatCustomer }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Nama Lembaga</label>
                            <input type="text" class="form-control bg-white" value="{{ $collection->salesorder->customer->NamaLembaga }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Telp.</label>
                            <input type="text" class="form-control bg-white" value="{{ $collection->salesorder->customer->TelpLembaga }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>E-Mail</label>
                            <input type="text" class="form-control bg-white" value="{{ $collection->salesorder->customer->EmailLembaga }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Alamat</label>
                            <input type="text" class="form-control bg-white" value="{{ $collection->salesorder->customer->AlamatLembaga }}" readonly>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>


        
    </div>
    <!-- Page end  -->
</div>

@include('components.preview-img-form')
@endsection
