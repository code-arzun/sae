@extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ url()->previous() }}" class="badge bg-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i class="fa fa-arrow-left"></i></a>
        {{-- <a class="badge bg-success me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                        href="{{ route('writer.edit', $writer->id) }}" method="get"><i class="ri-pencil-line"></i> Edit
        </a> --}}
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Data Penulis</h4>
                    </div>
                    <a class="btn bg-success me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                        href="{{ route('writer.edit', $writer->id) }}" method="get"><i class="ri-pencil-line"></i> Edit
                    </a>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md">
                            <div class="profile-img position-relative">
                                <img src="{{ $writer->photo ? asset('storage/penuliss/' . $writer->photo) : asset('assets/images/user/1.png') }}" class="img-fluid rounded avatar-110" alt="profile-image">
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="profile-img position-relative">
                                <img src="{{ $writer->photo ? asset('storage/penuliss/' . $writer->photo) : asset('assets/images/user/1.png') }}" class="img-fluid rounded avatar-110" alt="profile-image">
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="form-group col-md-6">
                            <label>Nama Penulis</label>
                            <input type="text" class="form-control bg-white text-strong" value="{{ $writer->NamaPenulis }}" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Profesi</label>
                            <input type="text" class="form-control bg-white text-strong" value="{{ $writer->writerjob->nama ?? '-'}}" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Kategori</label>
                            <input type="text" class="form-control bg-white text-strong"  value="{{ $writer->writercategory->nama ?? '-'}}" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label>NIK</label>
                            <input type="text" class="form-control bg-white text-strong" value="{{ $writer->NIK }}" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label>NPWP</label>
                            <input type="text" class="form-control bg-white text-strong"  value="{{ $writer->NPWP }}" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Telp.</label>
                            <input type="text" class="form-control bg-white text-strong" value="{{ $writer->TelpPenulis }}" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label>E-Mail</label>
                            <input type="text" class="form-control bg-white text-strong"  value="{{ $writer->EmailPenulis }}" readonly>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Alamat</label>
                            <textarea rows="3" class="form-control bg-white text-strong" readonly>{{ $writer->AlamatPenulis }}</textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Catatan</label>
                            <textarea rows="3" class="form-control bg-white text-strong" readonly>{{ $writer->CatatanPenulis }}</textarea>
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
