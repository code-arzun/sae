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
                        <h4 class="card-title">Daftar Kehadiran Pegawai {{ $attendance->date }}</h4>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('attendance.show') }}" method="get">
                        <div class="row align-items-center">
                            {{-- <div class="form-group col-md-6">
                                <label for="datepicker">Tanggal <span class="text-danger">*</span></label>
                                <input value="{{ old('date', $date) }}" readonly />
                                @error('date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div> --}}
                            <div class="col-lg-12">
                                <div class="dt-responsive table-responsive mb-3">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr class="ligth ligth-data">
                                                <th>No.</th>
                                                <th>Nama</th>
                                                <th>Jabatan</th>
                                                <th>Divisi</th>
                                                <th class="text-center">Status Kehadiran</th>
                                                <th>Datang</th>
                                                <th>Pulang</th>
                                                <th>Diinput pada</th>
                                                <th>Diperbarui pada</th>
                                            </tr>
                                        </thead>
                                        <tbody class="ligth-body">
                                            @foreach ($attendances as $attendance)
                                            <tr>
                                                <th scope="row">{{ $key = $loop->iteration  }}</th>
                                                <td>{{ $attendance->employee->name}}</td>
                                                <td>{{ $attendance->employee->position->name}}</td>
                                                <td>{{ $attendance->employee->department->name}}</td>
                                                <td>{{ $attendance->status }} </td>
                                                <td>{{ $attendance->datang }} </td>
                                                <td>{{ $attendance->pulang }} </td>
                                                <td>{{ $attendance->created_at }} </td>
                                                <td>{{ $attendance->updated_at }} </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>

{{-- <script>
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
        // https://gijgo.com/datetimepicker/configuration/format
    });
</script> --}}
@endsection
