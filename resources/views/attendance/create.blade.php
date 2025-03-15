@extends('layout.main')
@section('container')

<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <div>
            <a href="{{ url()->previous() }}" class="badge bg-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali">
                <i class="fa fa-arrow-left mb-0"></i>
            </a>
        </div>
        <div>
            <a href="{{ route('myattendance') }}" class="badge bg-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Data Kehadiran Saya">
                <i class="fa fa-table mb-0"></i>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                {{-- <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Input Kehadiran</h4>
                    </div>
                </div> --}}
                <div class="card-body">
                    {{-- <div class="container">
                        <iframe src="https://calendar.google.com/calendar/embed?src=your_calendar_id&ctz=Asia/Jakarta"></iframe>
                    </div> --}}
                    <!-- Form Kehadiran -->
                    @if (!isset($attendance) || $attendance->status == null)
                        <form id="attendanceForm" action="{{ route('attendance.store') }}" method="POST">
                            @csrf
                            <div class="row d-flex flex-wrap align-items-top">
                                <!-- Pilih Status Kehadiran -->
                                <div class="form-group col-md-3">
                                    <label data-bs-toggle="tooltip" data-bs-placement="top" title="Wajib diisi!"><span class="text-danger">*</span>Status Kehadiran</label><br>
                                    <div class="col">
                                        <input type="radio" id="tidak_hadir" name="status" value="Tidak Hadir" hidden>
                                        <label class="btn btn-outline-danger tidak_hadir me-2" for="tidak_hadir"> Tidak Hadir </label>
                                        <input type="radio" id="hadir" name="status" value="Hadir" hidden>
                                        <label class="btn btn-outline-primary hadir" for="hadir"> Hadir </label>
                                    </div>
                                    <!-- 
                                        <div class="form-group row-md-1">
                                            <div class="input-group-text" id="status">
                                                <div class="custom-radio">
                                                    <input type="radio" id="hadir" name="status" class="custom-control-input position-relative" style="height: 20px" value="Hadir">
                                                    <label class="custom-control-label" for="hadir"> Hadir </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row-md-1">
                                            <div class="input-group-text" id="status">
                                                <div class="custom-radio">
                                                    <input type="radio" id="tidak_hadir" name="status" class="custom-control-input position-relative" style="height: 20px" value="Tidak Hadir">
                                                    <label class="custom-control-label" for="tidak_hadir"> Tidak Hadir </label>
                                                </div>
                                            </div>
                                        </div>
                                    -->
                                </div>
                                <!-- Timepicker untuk 'Hadir' -->
                                <div class="form-group col-md-2" id="timepickerDiv" style="display: none;">
                                    <label for="datang" data-bs-toggle="tooltip" data-bs-placement="top" title="Wajib diisi!"><span class="text-danger">*</span>Jam Datang</label>
                                    <input id="datangTime" type="time" class="form-control @error('datang') is-invalid @enderror" name="datang" value="{{ old('datang') }}" />
                                    @error('datang')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <!-- Alasan untuk 'Tidak Hadir' -->
                                <div class="form-group col-md" id="keteranganDiv" style="display: none;">
                                    <label for="keterangan" data-bs-toggle="tooltip" data-bs-placement="top" title="Wajib diisi!"><span class="text-danger">*</span>Keterangan</label>
                                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="10" value="{{ old('keterangan') }}"></textarea>
                                    @error('keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success mt-1">Simpan</button>
                        </form>
                    @else
                    <!-- Tampilkan Data Kehadiran yang Sudah Diisi -->
                        <div class="row align-items-start">
                            <div class="form-group col-md-2">
                                <label>Hari</label>
                                <input type="text" class="form-control text-center bg-white" value="{{ Carbon\Carbon::parse($attendance->created_at)->translatedFormat('l') }}" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Tanggal</label>
                                <input type="text" class="form-control text-center bg-white" value="{{ Carbon\Carbon::parse($attendance->created_at)->translatedFormat('d F Y') }}" readonly>
                            </div>
                            @if($attendance->status == 'Hadir')
                            <div class="form-group col-md-3 text-center">
                                <label>Status Kehadiran</label> <br>
                                <span class="badge bg-success">{{ $attendance->status }}</span>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Jam Datang</label>
                                <input type="text" class="form-control text-center bg-white" value="{{ Carbon\Carbon::parse($attendance->datang)->translatedFormat('H:i') }}" readonly>
                            </div>
                                @if ($attendance->pulang !== null)
                                    <div class="form-group col-md-2">
                                        <label>Jam Pulang</label>
                                        <input type="text" class="form-control text-center bg-white" value="{{ Carbon\Carbon::parse($attendance->pulang)->translatedFormat('H:i') }}" readonly>
                                    </div>
                                    <div class="form-group col-md">
                                        <label>Deskripsi pekerjaan hari ini</label>
                                        <textarea class="form-control bg-white" id="work_journal" name="work_journal" rows="20" readonly>{{ old('work_journal', $attendance->work_journal) }}</textarea>
                                    </div>
                                @endif
                            @else
                            <div class="form-group col-md-4">
                                <label>Status Kehadiran</label> <br>
                                <span class="badge bg-danger">{{ $attendance->status }}</span>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Keterangan</label>
                                <textarea class="form-control bg-white" id="work_journal" name="work_journal" rows="20" readonly>{{ $attendance->keterangan }}</textarea>
                            </div>
                            @endif
                        </div>
                    @endif
                    <!-- Form Pulang (muncul setelah status Hadir dan absensi disubmit) -->
                    @if(isset($attendance) && $attendance->status == 'Hadir' && !$attendance->pulang)
                        <form id="checkoutForm" action="{{ route('attendance.update', ['attendance' => $attendance->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <!-- Input Pulang -->
                            <div class="row">
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
                                    <textarea class="form-control @error('work_journal') is-invalid @enderror" id="work_journal" name="work_journal" rows="20" value="{{ old('work_journal') }}" required></textarea>
                                    @error('work_journal')
                                    <div class="invalid-feedback">
                                        Worksheet harian belum diisi!
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success mt-1">Simpan</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hadirRadio = document.getElementById('hadir');
        const tidakHadirRadio = document.getElementById('tidak_hadir');
        const timepickerDiv = document.getElementById('timepickerDiv');
        const keteranganDiv = document.getElementById('keteranganDiv');

        hadirRadio.addEventListener('change', function () {
            if (this.checked) {
                timepickerDiv.style.display = 'block';
                document.getElementById('datangTime').setAttribute('required', 'required');  // Tetap required saat hadir
                keteranganDiv.style.display = 'none';
                document.getElementById('keterangan').removeAttribute('required');  // Tidak required saat hadir
            }
        });

        tidakHadirRadio.addEventListener('change', function () {
            if (this.checked) {
                timepickerDiv.style.display = 'none';
                document.getElementById('datangTime').removeAttribute('required');  // Hapus required saat tidak hadir
                keteranganDiv.style.display = 'block';
                document.getElementById('keterangan').setAttribute('required', 'required');  // Set required saat tidak hadir
            }
        });

        // Handle attendance form submission
        const attendanceForm = document.getElementById('attendanceForm');
        const checkoutForm = document.getElementById('checkoutForm');

        attendanceForm?.addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(attendanceForm);

            fetch('{{ route('attendance.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      attendanceForm.style.display = 'none';  // Hide attendance form after submission
                      location.reload();  // Reload to show readonly data and pulang form
                  }
              });
        });

        // Cek apakah attendance ada sebelum men-define updateUrl
        @if ($attendance)
        const updateUrl = '{{ route('attendance.update', ['attendance' => $attendance->id]) }}';
        @else
        const updateUrl = '';  // Kosongkan jika tidak ada $attendance
        @endif

        // Handle checkout form submission
        if (updateUrl !== '') {  // Hanya jika ada updateUrl
            checkoutForm?.addEventListener('submit', function (event) {
                event.preventDefault();

                const formData = new FormData(this);

                fetch(updateUrl, {
                    method: 'POST',  // POST dengan method override PUT
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'X-HTTP-Method-Override': 'PUT'  // Override method ke PUT
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    }
                });
            });
        }
    });
</script>

@endsection
