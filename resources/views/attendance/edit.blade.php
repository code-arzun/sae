{{-- @extends('layout.main')

@section('container') --}}
<div class="card">
    <div class="card-header bg-primary">
        <h4 class="card-title text-white mb-0" id="attendanceCheckoutModalLabel">Form Absensi</h4>
    </div>
    <div class="card-body">
        <!-- Tampilkan Data Kehadiran yang Sudah Diisi -->
        <div class="row d-flex flex-wrap align-items-top">
            @if($attendance && $attendance->status == 'Hadir')
            <div class="form-group col-md-6">
                <label class="mb-2">Hari/Tanggal</label>
                <h5>{{ \Carbon\Carbon::parse()->translatedFormat('l, d F Y') }}</h5>
            </div>
            <div class="form-group d-flex flex-column col-md-6">
                <label class="mb-2">Status Kehadiran</label>
                @if ($attendance->status == 'Hadir' && is_null($attendance->work_journal))
                    <span class="badge bg-success">{{ $attendance->status }}</span>
                @else
                    Belum mengisi
                @endif
            </div>
            <div class="form-group col-md-6">
                <label class="mb-2">Datang</label>
                <h5>{{ \Carbon\Carbon::parse($attendance->created_at)->translatedFormat('H:i') }}</h5>
            </div>
            <div class="form-group col-md-6">
                <label class="mb-2">Pulang</label>
                @if (is_null($attendance->work_journal))
                    <h5 id="clock"></h5>
                    @else
                    <h5>{{ \Carbon\Carbon::parse($attendance->updated_at)->translatedFormat('H:i') }}</h5>
                @endif
            </div>
            @endif
        </div>
        <!-- Form Pulang (muncul setelah status Hadir dan absensi disubmit) -->
        <form id="checkoutForm" action="{{ route('attendance.update', ['attendance' => $attendance->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <!-- Jurnal Harian Kerja -->
        @if ($attendance->status == 'Hadir' && is_null($attendance->work_journal))
        <div class="form-group col-md" id="work_journal">
            <label for="work_journal" data-bs-toggle="tooltip" data-bs-placement="top" title="Wajib diisi!"><span class="text-danger">*</span>Worksheet Harian</label>
            <textarea class="form-control @error('work_journal') is-invalid @enderror" id="work_journal" name="work_journal" rows="10" placeholder="Deskripsikan pekerjaan yang Anda selesaikan hari ini!" required></textarea>
            @error('work_journal')
            <div class="invalid-feedback">
                Worksheet harian belum diisi!
            </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success w-100">Simpan</button>
        </form>
        @elseif ($attendance->status == 'Tidak Hadir')
        <div class="form-group col-md-6">
            <label class="mb-2">Status Kehadiran</label>
            <span class="badge bg-danger">{{ $attendance->status }}</span>
        </div>
        <div class="form-group col-md" id="keterangan">
            <label for="keterangan" class="mb-2">Keterangan</label>
            <h5>{{ $attendance->keterangan }}</h5>
        </div>
        @else
        <div class="form-group col-md" id="work_journal">
            <label for="work_journal" class="mb-2">Worksheet Harian</label>
            <h5>{{ $attendance->work_journal }}</h5>
        </div>
        @endif
    </div>
</div>
{{-- @endsection --}}

<script>
    function updateClock() {
            const now = new Date();
            const jam = String(now.getHours()).padStart(2, '0');
            const menit = String(now.getMinutes()).padStart(2, '0');
            const detik = String(now.getSeconds()).padStart(2, '0');
            const clockEl = document.getElementById('clock');
            if (clockEl) {
                clockEl.textContent = `${jam}:${menit}:${detik}`;
            }
        }

        setInterval(updateClock, 1000);
        updateClock();
</script>