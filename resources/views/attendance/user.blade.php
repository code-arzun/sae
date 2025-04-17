@extends('layout.main')

@section('breadcrumb')
    <li class="breadcrumb-item active"><a href="{{ route('attendance.index') }}">Kehadiran</a></li>
@endsection

{{-- @section('action-button')
    <a href="{{ route('attendance.edit', $attendance->id) }}" class="btn btn-primary">
        @if ($attendance && $attendance->status === 'Hadir' && is_null($attendance->work_journal))
        Pulang
        @else
        Absensi Hari ini
        @endif
    </a>
@endsection --}}

@section('container')

<div class="row">
    @if($attendance)
    <div class="col-md-4">
        @include('attendance.edit')
    </div>
    @endif
    <div class="col-md">
        <div class="d-flex justify-content-start mb-3">
            <div class="d-flex flex-column me-3">
                <span>Bulan</span>
                <span class="badge bg-primary">{{ \Carbon\Carbon::now()->translatedformat('F Y') }}</span>
            </div>
            <div class="d-flex flex-column me-3">
                <span>Hadir</span>
                <span class="badge bg-success">{{ $myattendances->where('status', 'Hadir')->count() }}</span>
            </div>
            <div class="d-flex flex-column me-3">
                <span>Tidak Hadir</span>
                <span class="badge bg-danger">{{ $myattendances->where('status', 'Tidak Hadir')->count() }}</span>
            </div>
        </div>
        <div class="dt-responsive table-responsive mb-3">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th width="5%">Hari</th>
                        <th width="15%">Tanggal</th>
                        <th>Status</th>
                        <th>Datang</th>
                        <th>Pulang</th>
                        <th>Worksheet Harian</th>
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
                                @if ($attendance && $attendance->status === 'Hadir' && $attendance->created_at)
                                    {{ Carbon\Carbon::parse($attendance->created_at)->translatedformat('H:i') }} WIB
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($attendance && $attendance->status === 'Hadir' && ($attendance->created_at === $attendance->updated_at))
                                    -
                                @elseif ($attendance && $attendance->status === 'Tidak Hadir')
                                    -
                                @elseif ($attendance && $attendance->updated_at)
                                    {{ Carbon\Carbon::parse($attendance->updated_at)->translatedformat('H:i') }} WIB
                                @endif
                            </td>
                            <td>
                                @if ($attendance && is_null($attendance->work_journal))
                                -
                                @elseif ($attendance && $attendance->work_journal)
                                    {{ $attendance->work_journal }}
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

{{-- @if($attendance && $attendance->status == 'Hadir' && is_null($attendance->work_journal))
@include('attendance.checkout')
    <script>
        window.onload = function () {
            $('#attendanceCheckoutModal').modal('show');
        }
    </script>
@endif --}}