<!-- Pulang -->
@if(isset($attendance) && $attendance->status == 'Hadir' && !$attendance->pulang)
<div class="modal fade" id="attendanceModal" tabindex="-1" role="dialog" aria-labelledby="attendanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attendanceModalLabel">Form Absensi Pulang</h5>
                <span>{{ Carbon\Carbon::parse()->translatedFormat('l, d F Y') }}</span>
            </div>
            <div class="modal-body">
                <!-- Tampilkan Data Kehadiran yang Sudah Diisi -->
                {{-- <div class="row d-flex flex-wrap align-items-top">
                    @if($attendance->status == 'Hadir')
                    <div class="form-group col-md-3 text-center">
                        <label>Status Kehadiran</label> <br>
                        <span class="badge bg-success">{{ $attendance->status }}</span>
                    </div>
                    <div class="form-group col-md-3 text-center">
                        <label>Jam Datang</label>
                        <input type="text" class="form-control text-center bg-white" value="{{ Carbon\Carbon::parse($attendance->datang)->translatedFormat('H:i') }}" readonly>
                    </div>
                    @endif
                </div> --}}
                <!-- Form Pulang (muncul setelah status Hadir dan absensi disubmit) -->
                <form id="checkoutForm" action="{{ route('attendance.update', ['attendance' => $attendance->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Input Pulang -->
                    <div class="form-group col-md-2" id="timepickerDiv">
                        <label for="pulang" data-bs-toggle="tooltip" data-bs-placement="top" title="Wajib diisi!"><span class="text-danger">*</span>Jam Pulang</label>
                        <input id="pulang" type="time" class="form-control @error('pulang') is-invalid @enderror" name="pulang" value="{{ old('pulang') }}" required>
                        @error('pulang')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <!-- Jurnal Harian Kerja -->
                    <div class="form-group col-md" id="work_journal">
                        <label for="work_journal" data-bs-toggle="tooltip" data-bs-placement="top" title="Wajib diisi!"><span class="text-danger">*</span>Worksheet Harian</label>
                        <textarea class="form-control @error('work_journal') is-invalid @enderror" id="work_journal" name="work_journal" rows="10" value="{{ old('work_journal') }}" required></textarea>
                        @error('work_journal')
                        <div class="invalid-feedback">
                            Worksheet harian belum diisi!
                        </div>
                        @enderror
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('dashboard') }}"><span class="badge bg-warning">Isi Nanti</span></a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif