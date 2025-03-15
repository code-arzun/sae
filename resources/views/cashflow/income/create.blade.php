@extends('layout.main')

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
                        <h4 class="card-title">Tambah Pemasukan</h4>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('income.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <!-- begin: Input Image -->
                        <div class="form-group row align-items-center">
                            <div class="col-md-12">
                                <div class="profile-img-edit">
                                    <div class="crm-profile-img-edit">
                                        <img class="crm-profile-pic rounded-circle avatar-100" id="image-preview" src="{{ asset('assets/images/product/default.webp') }}" alt="profile-pic">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-group mb-4 col-lg-6">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('income_image') is-invalid @enderror" id="image" name="income_image" accept="image/*" onchange="previewImage();">
                                    <label class="custom-file-label" for="income_image">Upload bukti transaksi</label>
                                </div>
                                @error('income_image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- end: Input Image -->

                        <!-- begin: Input Data -->
                        <div class=" row align-items-center">
                            {{-- Data penginput --}}
                            <div class="form-group col-md-3" hidden>
                                <label for="user_id">Nama<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" value="{{ auth()->user()->id }}" required readonly>
                                @error('user_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            {{-- Divisi --}}
                            <div class="form-group col-md-2">
                                <label for="department_id">Divisi <span class="text-danger">*</span></label>
                                <select class="form-control" name="department_id" required>
                                    <option selected="" disabled>-- Pilih Divisi --</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            {{-- Tanggal --}}
                            <div class="form-group col-md-2">
                                <label for="date">Tanggal</label>
                                <input id="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" />
                                @error('date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            {{-- Jenis Transaksi --}}
                            {{-- <div class="form-group col-md-3">
                                <label for="cashflowtype_id">Jenis Transaksi <span class="text-danger">*</span></label>
                                <select class="form-control" name="cashflowtype_id" required>
                                    <option selected="" disabled>-- Pilih Transaksi --</option>
                                    @foreach ($cashflowtypes as $cashflowtype)
                                        <option value="{{ $cashflowtype->id }}" {{ old('cashflowtype_id') == $cashflowtype->name ? 'selected' : '' }}>{{ $cashflowtype->name }}</option>
                                    @endforeach
                                </select>
                                @error('cashflowtype_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div> --}}
                            {{-- Kategori --}}
                            {{-- <div class="form-group col-md-3">
                                <label for="cashflowcategory_id">Kategori <span class="text-danger">*</span></label>
                                <select class="form-control" name="cashflowcategory_id" required>
                                    <option selected="" disabled>-- Pilih Kategori --</option>
                                    @foreach ($cashflowcategories as $cashflowcategory)
                                        <option value="{{ $cashflowcategory->id }}" {{ old('cashflowcategory_id') == $cashflowcategory->name ? 'selected' : '' }}>{{ $cashflowcategory->name }}</option>
                                    @endforeach
                                </select>
                                @error('cashflowcategory_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div> --}}
                            {{-- Jenis Transaksi --}}
                            {{-- <div class="form-group col-md-3">
                                <label for="">Jenis Transaksi <span class="text-danger">*</span></label>
                                <select class="form-control" name="" required>
                                    <option selected="" disabled>-- Pilih Transaksi --</option>
                                    @foreach ($cashflowtypes as $cashflowtype)
                                        <option value="">{{ $cashflowtype->name }}</option>
                                    @endforeach
                                </select>
                                @error('')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div> --}}
                            {{-- Kategori --}}
                            {{-- <div class="form-group col-md-3">
                                <label for="">Kategori <span class="text-danger">*</span></label>
                                <select class="form-control" name="" required>
                                    <option selected="" disabled>-- Pilih Kategori --</option>
                                    @foreach ($cashflowcategories as $cashflowcategory)
                                        @if ($cashflowcategory->cashflowtype->name == 'Pemasukan')
                                            <option value="">{{ $cashflowcategory->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div> --}}
                            {{-- Keterangan --}}
                            <div class="form-group col-md-4">
                                <label for="cashflowdetail_id">Keterangan <span class="text-danger">*</span></label>
                                <select class="form-control" name="cashflowdetail_id" required>
                                    <option selected="" disabled>-- Pilih Keterangan --</option>
                                    @foreach ($cashflowdetails as $cashflowdetail)
                                        {{-- @if ($cashflowdetail->cashflowcategory->cashflowtype->name == 'Pemasukan') --}}
                                            {{-- <option value="{{ $cashflowdetail->id }}" {{ old('cashflowdetail_id') == $cashflowdetail->name ? 'selected' : '' }}>{{ $cashflowdetail->name }}</option> --}}
                                            <option value="{{ $cashflowdetail->id }}" {{ old('cashflowdetail_id') == $cashflowdetail->id ? 'selected' : '' }}>{{ $cashflowdetail->cashflowcategory->name }} {{ $cashflowdetail->name }}</option>
                                        {{-- @endif --}}
                                    @endforeach
                                </select>
                                @error('cashflowdetail_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="nominal">Nominal Kas Masuk<span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('nominal') is-invalid @enderror" id="nominal" name="nominal" value="{{ old('nominal') }}" required>
                                @error('nominal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md">
                                <label for="notes">Catatan</label>
                                <input type="text" class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" value="{{ old('notes') }}">
                                {{-- <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" value="{{ old('notes') }}"></textarea> --}}
                                @error('notes')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- end: Input Data -->
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Simpan</button>
                            <a class="btn bg-danger" href="{{ route('income.index') }}">Batalkan</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>

<script>
    $('#date').datepicker({
        uiLibrary: 'bootstrap4',
        // format: 'dd-mm-yyyy'
        format: 'yyyy-mm-dd'
        // https://gijgo.com/datetimepicker/configuration/format
    });
    


</script>

@include('components.preview-img-form')
@endsection
