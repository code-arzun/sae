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
                        <h4 class="card-title">Edit Income</h4>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('cashflowincome.update', $cashflowincome->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                        <!-- begin: Input Image -->
                        <div class="form-group row align-items-center">
                            <div class="col-md-12">
                                <div class="profile-img-edit">
                                    <div class="crm-profile-img-edit">
                                        <img class="crm-profile-pic rounded-circle avatar-100" id="image-preview" src="{{ $cashflowincome->income_image ? asset('storage/income/'.$cashflowincome->income_image) : asset('assets/images/income/default.webp') }}" alt="profile-pic">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-group mb-4 col-lg-6">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('income_image') is-invalid @enderror" id="image" name="income_image" accept="image/*" onchange="previewImage();">
                                    <label class="custom-file-label" for="income_image">Choose file</label>
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
                            <div class="form-group col-md-4">
                                <label for="date">Tanggal Pembelian</label>
                                <input id="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date', $cashflowincome->date) }}" />
                                @error('date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="department_id">Divisi <span class="text-danger">*</span></label>
                                <select class="form-control" name="department_id" required>
                                    <option selected="" disabled>-- Select Divis --</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id', $cashflowincome->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            {{-- <div class="form-group col-md-4">
                                <label for="cashflowcategory_id">Kategori <span class="text-danger">*</span></label>
                                <select class="form-control" name="cashflowcategory_id" required>
                                    <option selected="" disabled>-- Pilih Kategori --</option>
                                    @foreach ($cashflowcategories as $cashflowcategory)
                                    <option value="{{ $cashflowcategory->id }}" {{ old('cashflowcategory_id', $cashflowincome->cashflowcategory_id) == $cashflowcategory->id ? 'selected' : '' }}>{{ $cashflowcategory->name }}</option>
                                    @endforeach
                                </select>
                                @error('cashflowcategory_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div> --}}
                            <div class="form-group col-md-4">
                                <label for="cashflowdetail_id">Keterangan <span class="text-danger">*</span></label>
                                <select class="form-control" name="cashflowdetail_id" required>
                                    <option selected="" disabled>-- Pilih Keterangan --</option>
                                    @foreach ($cashflowdetails as $cashflowdetail)
                                    @if ($cashflowdetail->cashflowcategory->cashflowtype->name == 'Pemasukan')
                                        <option value="{{ $cashflowdetail->id }}" {{ old('cashflowdetail_id', $cashflowincome->cashflowdetail_id) == $cashflowdetail->id ? 'selected' : '' }}>{{ $cashflowdetail->cashflowcategory->name }} {{ $cashflowdetail->name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('cashflowdetail_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="nominal">Nominal Kas Keluar<span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('nominal') is-invalid @enderror" id="nominal" name="nominal" value="{{ old('nominal', $cashflowincome->nominal) }}" required>
                                @error('nominal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-8">
                                <label for="notes">Catatan</label>
                                <input type="text" class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" value="{{ old('notes', $cashflowincome->notes) }}">
                                @error('notes')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- end: Input Data -->
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Save</button>
                            <a class="btn bg-danger" href="{{ route('cashflowincome.index') }}">Cancel</a>
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
        format: 'dd-mm-yyyy'
        // https://gijgo.com/datetimepicker/configuration/format
    });
</script>

@include('components.preview-img-form')
@endsection
