@extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            @if (session()->has('success'))
                <div class="alert text-white bg-success" role="alert">
                    <div class="iq-alert-text">{{ session('success') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-3">Absensi Semua Pegawai</h4>
            </div>
            <form method="GET" action="{{ route('attendance.index', ['year' => $currentYear]) }}">
                <div class="form-group md-4">
                    <label for="month">Bulan</label>
                    <select name="month" id="month" class="form-control" onchange="this.form.submit()">
                        @foreach (range(1, 12) as $month)
                            <option value="{{ $month }}" {{ $month == $currentMonth ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }} {{ date('Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        

        {{-- Tabel Absensi Semua Pegawai --}}
            <div class="col-lg-12">
                <div class="dt-responsive table-responsive mb-3">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th width="30%">Tanggal</th>
                                <th width="65%">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach($dates as $date)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td>{{ $date->translatedformat('l, d F Y') }}</td>
                                    <td>
                                        @if(isset($attendances[$date->format('d M Y')]))
                                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-target="#details-{{ $date->format('Ymd') }}">
                                                Lihat Detail
                                            </button>
                        
                                            <div class="modal fade" id="details-{{ $date->format('Ymd') }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable scroller modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><span class="badge bg-primary">{{ $date->translatedformat('l, d F Y') }}</span></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nama</th>
                                                                        <th>Status</th>
                                                                        <th>Datang</th>
                                                                        <th>Pulang</th>
                                                                        <th>#</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($employees as $employee)
                                                                        @php
                                                                            $attendanceRecord = $attendances[$date->format('d M Y')]->firstWhere('employee_id', $employee->id) ?? null;
                                                                        @endphp
                                                                        <tr>
                                                                            <td>{{ $employee->name }}</td>
                                                                            <td class="text-center">
                                                                                @if ($attendanceRecord)
                                                                                    <span class="badge {{ $attendanceRecord->status === 'Hadir' ? 'badge-success' : 'badge-danger' }}">
                                                                                        {{ $attendanceRecord->status }}
                                                                                    </span>
                                                                                @else
                                                                                    <span class="badge badge-secondary">Belum mengisi</span>
                                                                                @endif
                                                                            </td>
                                                                            <td class="text-center">{{ $attendanceRecord && $attendanceRecord->datang ? \Carbon\Carbon::parse($attendanceRecord->datang)->format('H:i') : '-' }}</td>
                                                                            <td class="text-center">{{ $attendanceRecord && $attendanceRecord->pulang ? \Carbon\Carbon::parse($attendanceRecord->pulang)->format('H:i') : '-' }}</td>
                                                                            {{-- <td>{{ $attendanceRecord ? $attendanceRecord->work_journal : '-' }}</td> --}}
                                                                            <td class="text-center">
                                                                                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-target="#employee-detail-{{ $employee->id }}-{{ $date->format('Ymd') }}">
                                                                                    <i class="fa fa-eye me-0"></i>
                                                                                </button>
                        
                                                                                <!-- Modal untuk detail masing-masing employee -->
                                                                                <div class="modal fade" id="employee-detail-{{ $employee->id }}-{{ $date->format('Ymd') }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-md">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h5 class="modal-title">{{ $employee->name }}</h5>
                                                                                                <div>
                                                                                                    <span class="badge bg-primary">{{ $employee->position->name }}</span>
                                                                                                    <span class="badge bg-secondary">{{ $employee->department->name }}</span>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <div class="row align-items-start">
                                                                                                    <div class="form-group col-md-4">
                                                                                                        <label>Hari</label>
                                                                                                        <input type="text" class="form-control bg-white text-center" value="{{ $date->translatedformat('l') }}" readonly>
                                                                                                    </div>
                                                                                                    <div class="form-group col-md-5">
                                                                                                        <label>Tanggal</label>
                                                                                                        <input type="text" class="form-control bg-white text-center" value="{{ $date->translatedformat('d F Y') }}" readonly>
                                                                                                    </div>
                                                                                                    <div class="form-group col-md-3">
                                                                                                        <label>Status</label> <br>
                                                                                                        @if ($attendanceRecord)
                                                                                                            <span class="badge {{ $attendanceRecord->status === 'Hadir' ? 'badge-success' : 'badge-danger' }}">
                                                                                                                {{ $attendanceRecord->status }}
                                                                                                            </span>
                                                                                                        @else
                                                                                                            <span class="badge badge-secondary">Belum mengisi</span>
                                                                                                        @endif
                                                                                                    </div>
                                                                                                    {{-- <div class="form-group col-md-4">
                                                                                                        <label>Waktu Pengisian</label>
                                                                                                        <input type="text" class="form-control bg-white text-center" 
                                                                                                        value="{{ $attendanceRecord && $attendanceRecord->created_at ? \Carbon\Carbon::parse($attendanceRecord->created_at)->format('H:i:s') : '-' }}" readonly>
                                                                                                    </div> --}}

                                                                                                    @if ($attendanceRecord && $attendanceRecord->status === 'Hadir')
                                                                                                        <div class="form-group col-md-4">
                                                                                                            <label>Jam Datang</label>
                                                                                                            <input type="text" class="form-control bg-white text-center" value="{{ \Carbon\Carbon::parse($attendanceRecord->datang)->format('H:i') }}" readonly>
                                                                                                        </div>
                                                                                                        <div class="form-group col-md-4">
                                                                                                            <label>Jam Pulang</label>
                                                                                                            <input type="text" class="form-control bg-white text-center" value="{{ \Carbon\Carbon::parse($attendanceRecord->pulang)->format('H:i') }}" readonly>
                                                                                                        </div>
                                                                                                        {{-- <div class="form-group col-md-4">
                                                                                                            <label>Waktu Memperbarui</label>
                                                                                                            <input type="text" class="form-control bg-white text-center" value="{{ \Carbon\Carbon::parse($attendanceRecord->updated_at)->format('H:i:s') }}" readonly>
                                                                                                        </div> --}}
                                                                                                        <div class="form-group col-md-12 text-left mt-2">
                                                                                                            <label>Worksheet Harian</label>
                                                                                                            <textarea class="form-control bg-white" id="work_journal" name="work_journal" rows="7" readonly>{{ $attendanceRecord->work_journal }}</textarea>
                                                                                                        </div>
                                                                                                    @else
                                                                                                        <div class="form-group col-md-12 text-left mt-2">
                                                                                                            <label>Keterangan</label>
                                                                                                            <textarea class="form-control bg-white" id="keterangan" name="keterangan" rows="10" readonly>{{ $attendanceRecord ? $attendanceRecord->keterangan : '-' }}</textarea>
                                                                                                        </div>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                            {{-- <div class="modal-footer">
                                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                                                                                    data-target="#employee-detail-{{ $employee->id }}-{{ $date->format('Ymd') }}">
                                                                                                    Tutup
                                                                                                </button>
                                                                                            </div> --}}
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
                                            </div>
                                        @else
                                            <span>Data tidak ditemukan.</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                        
                    </table>
                </div>
            </div>
                        
            {{-- {{ $attendances->links() }} --}}
        </div>

    </div>
    <!-- Page end  -->
</div>

@endsection
