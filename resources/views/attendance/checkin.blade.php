<div class="modal fade" id="attendanceModal" tabindex="-1" role="dialog" aria-labelledby="attendanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attendanceModalLabel">Absensi</h5>
                <span>{{ Carbon\Carbon::parse()->translatedFormat('l, d F Y') }}</span>
            </div>
            <div class="modal-body">
                <form id="attendanceForm" action="{{ route('attendance.store') }}" method="POST">
                    @csrf
                    <div class="row d-flex flex-wrap align-items-top">
                        <!-- Pilih Status Kehadiran -->
                        <div class="form-group col-md-6">
                            <label data-bs-toggle="tooltip" data-bs-placement="top" title="Wajib diisi!"><span class="text-danger">*</span>Status Kehadiran</label><br>
                            <div class="col" name="status">
                                <input type="radio" class="@error('status') is-invalid @enderror" id="tidak_hadir" name="status" value="Tidak Hadir" required hidden>
                                <label class="btn btn-outline-danger tidak_hadir me-2" for="tidak_hadir"> Tidak Hadir </label>
                                <input type="radio" class="@error('status') is-invalid @enderror" id="hadir" name="status" value="Hadir" required hidden>
                                <label class="btn btn-outline-primary hadir" for="hadir"> Hadir </label>
                            </div>
                            @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Timepicker untuk 'Hadir' -->
                        <div class="form-group col-md" id="timepickerDiv" style="display: none;">
                            <label for="datang" data-bs-toggle="tooltip" data-bs-placement="top" title="Wajib diisi!"><span class="text-danger">*</span>Jam Datang</label>
                            <input id="datangTime" type="time" class="form-control @error('datang') is-invalid @enderror" name="datang" value="{{ old('datang') }}">
                            @error('datang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Alasan untuk 'Tidak Hadir' -->
                        <div class="form-group col-md-12" id="keteranganDiv" style="display: none;">
                            <label for="keterangan" data-bs-toggle="tooltip" data-bs-placement="top" title="Wajib diisi!"><span class="text-danger">*</span>Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="10" value="{{ old('keterangan') }}"></textarea>
                            @error('keterangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
