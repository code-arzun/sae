@extends('layout.main')

@section('breadcrumb')
    <li class="breadcrumb-item active"><a href="{{ route('attendance.index') }}">Kehadiran</a></li>
@endsection

@section('action-button')
    <a href="{{ route('attendance.edit', $attendance->id) }}" class="btn btn-primary">
        @if ($attendance && $attendance->status === 'Hadir' && is_null($attendance->work_journal))
        Pulang
        @else
        Absensi Hari ini
        @endif
    </a>
@endsection

@section('container')

<div class="d-flex justify-content-between mb-3">
    <span class="mr-3"><b>Bulan</b><span class="badge bg-primary ml-2">{{ \Carbon\Carbon::now()->translatedformat('F Y') }}</span></span>
    <span class="mr-3"><b>Hadir</b><span class="badge bg-success ml-2">{{ $myattendances->where('status', 'Hadir')->count() }}</span></span>
    <span><b>Tidak Hadir</b><span class="badge bg-danger ml-2">{{ $myattendances->where('status', 'Tidak Hadir')->count() }}</span></span>
    {{-- <a href="{{ route('attendance.create') }}" class="btn btn-primary add-list">
        <i class=."fas fa-plus me-2 "></i>Input Absensi
    </a> --}}
</div>

<div class="row">
    <div class="col-md-6">
        @include('attendance.edit')
    </div>
    <div class="col-md-6">
        <div class="dt-responsive table-responsive mb-3">
            <table class="table table-hover nowrap mb-0">
                <thead>
                    <tr>
                        <th width="5%">Hari</th>
                        <th width="25%">Tanggal</th>
                        <th>Status</th>
                        <th>Datang</th>
                        <th>Pulang</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dates as $date)
                        @php
                            $attendance = $myattendances->firstWhere(function($item) use ($date) {
                                return $item->created_at->format('Y-m-d') === $date->format('Y-m-d');
                            });
                        @endphp
                        <tr>
                            <td>{{ $date->translatedformat('l') }}</td>
                            <td>{{ $date->translatedformat('d F Y') }}</td>
                            <td class="text-center">
                                @if ($attendance)
                                    <span class="badge {{ $attendance->status === 'Hadir' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $attendance->status }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($attendance && $attendance->created_at)
                                    {{ Carbon\Carbon::parse($attendance->created_at)->translatedformat('H:i') }} WIB
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($attendance && ($attendance->created_at === $attendance->updated_at))
                                    {{ Carbon\Carbon::parse($attendance->updated_at)->translatedformat('H:i') }} WIB
                                @elseif ($attendance && $attendance->updated_at)
                                    -
                                @endif
                            </td>
                            <td>
                                {{-- @if(isset($attendances[$date->format('d M Y')])) --}}
                                @if ($attendance)
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-target="#my-detail-{{ $date->format('Y-m-d') }}">
                                        <i class="fa fa-eye me-0"></i>
                                    </button>
                                    <div class="modal fade" id="my-detail-{{ $date->format('Y-m-d') }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                {{-- <div class="modal-header">
                                                </div> --}}
                                                <div class="modal-body">
                                                    <div class="row align-items-start">
                                                        <div class="form-group col-md-2">
                                                            <label>Hari</label>
                                                            <input type="text" class="form-control bg-white text-center" value="{{ $date->translatedformat('l') }}" readonly>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label>Tanggal</label>
                                                            <input type="text" class="form-control bg-white text-center" value="{{ $date->translatedformat('d F Y') }}" readonly>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label>Status</label> <br>
                                                            @if ($attendance)
                                                                <span class="badge {{ $attendance->status === 'Hadir' ? 'bg-success' : 'bg-danger' }}">
                                                                    {{ $attendance->status }}
                                                                </span>
                                                            @else
                                                                <span class="badge bg-secondary">Belum mengisi</span>
                                                            @endif
                                                        </div>
                                                        
                                                        @if ($attendance && $attendance->status === 'Hadir')
                                                            <div class="form-group col-md-2">
                                                                <label>Jam Datang</label>
                                                                <input type="text" class="form-control bg-white text-center" value="{{ \Carbon\Carbon::parse($attendance->created_at)->format('H:i') }}" readonly>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label>Jam Pulang</label>
                                                                <input type="text" class="form-control bg-white text-center" value="{{ $attendance->updated_at ? \Carbon\Carbon::parse($attendance->updated_at)->format('H:i') : '-' }}" readonly>
                                                            </div>
                                                            {{-- <div class="form-group col-md-4">
                                                                <label>Waktu Memperbarui</label>
                                                                <input type="text" class="form-control bg-white text-center" value="{{ \Carbon\Carbon::parse($attendance->updated_at)->format('H:i:s') }}" readonly>
                                                            </div> --}}
                                                            <div class="form-group col-md-12 text-left mt-2">
                                                                <label>Worksheet Harian</label>
                                                                <textarea class="form-control bg-white" id="work_journal" name="work_journal" rows="7" readonly>{{ $attendance->work_journal }}</textarea>
                                                            </div>
                                                        @else
                                                            <div class="form-group col-md-12 text-left mt-2">
                                                                <label>Keterangan</label>
                                                                <textarea class="form-control bg-white" id="keterangan" name="keterangan" rows="20" readonly>{{ $attendance ? $attendance->keterangan : '-' }}</textarea>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@if($attendance && $attendance->status == 'Hadir' && is_null($attendance->work_journal))
@include('attendance.checkout')
    <script>
        window.onload = function () {
            $('#attendanceCheckoutModal').modal('show');
        }
    </script>
@endif