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
                        <h4 class="card-title">Edit Employee Attendance</h4>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('attendance.store') }}" method="POST">
                    @csrf
                        <!-- begin: Input Data -->
                        <div class="row align-items-center">
                            <div class="form-group col-md-6">
                                <label for="datepicker">Date <span class="text-danger">*</span></label>
                                <input id="datepicker" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date', $date) }}" />
                                @error('date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-lg-12">
                                <div class="dt-responsive table-responsive mb-3">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr class="ligth ligth-data">
                                                <th>No.</th>
                                                <th>Employee</th>
                                                <th class="text-center">Attendance Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="ligth-body">
                                            @foreach ($attendances as $attendance)
                                            <tr>
                                                <th scope="row">{{ $key = $loop->iteration  }}</th>
                                                <td>{{ $attendance->employee->name}}</td>
                                                <td>
                                                    <input type="hidden" name="employee_id[{{ $key }}]" value="{{ $attendance->employee_id }}">
                                                    <div class="input-group">
                                                        <div class="input-group justify-content-center">
                                                            <div class="input-group-text">
                                                                <div class="custom-radio">
                                                                    <input type="radio" id="present{{ $key }}" name="status{{ $key }}" class="custom-control-input position-relative" style="height: 20px" value="present" {{ $attendance->status == 'present' ? 'checked' : '' }}>
                                                                    <label class="custom-control-label" for="present{{ $key }}"> Present </label>
                                                                </div>
                                                            </div>
                                                            <div class="input-group-text mx-2">
                                                                <div class="custom-radio">
                                                                    <input type="radio" id="leave{{ $key }}" name="status{{ $key }}" class="custom-control-input position-relative" style="height: 20px" value="leave" {{ $attendance->status == 'leave' ? 'checked' : '' }}>
                                                                    <label class="custom-control-label" for="leave{{ $key }}"> Leave </label>
                                                                </div>
                                                            </div>
                                                            <div class="input-group-text">
                                                                <div class="custom-radio">
                                                                    <input type="radio" id="absent{{ $key }}" name="status{{ $key }}" class="custom-control-input position-relative" style="height: 20px" value="absent" {{ $attendance->status == 'absent' ? 'checked' : '' }}>
                                                                    <label class="custom-control-label" for="absent{{ $key }}"> Absent </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end: Input Data -->
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('attendance.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>

<script>
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
        // https://gijgo.com/datetimepicker/configuration/format
    });
</script>
@endsection
