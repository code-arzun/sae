@extends('dashboard.body.main')

@section('specificpagestyles')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Detail Pengeluaran 
                            {{-- <span class="badge badge-danger"><b>{{ $cashflowexpense->expense_code }}</b></span> --}}
                        </h4>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('expense.update', $cashflowexpense->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                        <!-- begin: Input Image -->
                        <div class="form-group row align-items-center">
                            <div class="col-md-12">
                                <div class="profile-img-edit">
                                    <div class="crm-profile-img-edit">
                                        <img class="crm-profile-pic rounded-circle avatar-100" id="image-preview" src="{{ $cashflowexpense->cashflowexpense_image ? asset('storage/cashflowexpense/'.$cashflowexpense->cashflowexpense_image) : asset('assets/images/cashflowexpense/default.webp') }}" alt="profile-pic">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-group mb-4 col-lg-6">
                                {{-- <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('cashflowexpense_image') is-invalid @enderror" id="image" name="cashflowexpense_image" accept="image/*" onchange="previewImage();">
                                    <label class="custom-file-label" for="cashflowexpense_image">Choose file</label>
                                </div> --}}
                                @error('cashflowexpense_image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- end: Input Image -->
                        <!-- begin: Input Data -->
                        <div class=" row align-items-center">
                            <div class="form-group col-md-4">
                                <label for="cashflowexpense_date">Tanggal</label>
                                <input type="text" class="form-control bg-white" value="{{ Carbon\Carbon::parse($cashflowexpense->date)->translatedformat('l, d F Y') }}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="user_id">Diinput oleh <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-white" value="{{ $cashflowexpense->user->employee->name }}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="department_id">Divisi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-white" value="{{ $cashflowexpense->department->name }}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="cashflowcategory_id">Kategori <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-white" value="{{ $cashflowexpense->cashflowdetail->cashflowcategory->name }}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="cashflowdetail_id">Keterangan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-white" value="{{ $cashflowexpense->cashflowdetail->name }}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="nominal">Nominal Kas Keluar<span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-white" value="Rp {{ number_format($cashflowexpense->nominal) }}" readonly>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="notes">Catatan</label>
                                <input type="text" class="form-control bg-white" value="{{ $cashflowexpense->notes }}" readonly>
                            </div>
                        </div>
                        <!-- end: Input Data -->
                        <div class="mt-2">
                            <a class="btn bg-warning" href="{{ route('expense.index') }}">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>

<script>
    $('#cashflowexpense_date').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'dd-mm-yyyy'
        // https://gijgo.com/datetimepicker/configuration/format
    });
</script>

@include('components.preview-img-form')
@endsection
