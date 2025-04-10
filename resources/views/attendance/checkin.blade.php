<div class="modal fade" id="attendanceCheckinModal" tabindex="-1" role="dialog" aria-labelledby="attendanceCheckinModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="mb-0 text-white">Absensi</h4>
            </div>
            <div class="modal-body bg-gray-100">
                <form id="attendanceForm" action="{{ route('attendance.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Jam, Hari, dan Tanggal -->
                        <div class="form-group col-md-12 d-flex justify-content-between mb-3">
                            <span id="clock" class="fw-bold fs-5"></span>
                            <span class="fw-bold fs-5">{{ Carbon\Carbon::parse()->translatedFormat('l, d F Y') }}</span>
                        </div>
                        <!-- Pilih Status Kehadiran -->
                        <div class="form-group col-md-12 mb-3">
                            <label for="status" class="mb-2"><span class="text-danger">*</span>Status Kehadiran</label><br>
                            <div class="col-md-12 d-flex justify-content-between" id="status" name="status">
                                <input type="radio" class="@error('status') is-invalid @enderror" id="tidak_hadir" name="status" value="Tidak Hadir" required hidden>
                                <label class="btn btn-outline-danger tidak_hadir w-100 me-2" for="tidak_hadir"> Tidak Hadir </label>
                                <input type="radio" class="@error('status') is-invalid @enderror" id="hadir" name="status" value="Hadir" required hidden>
                                <label class="btn btn-outline-success hadir w-100" for="hadir"> Hadir </label>
                            </div>
                            @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Alasan untuk 'Tidak Hadir' -->
                        <div class="form-group col-md-12" id="keteranganDiv" style="display: none;">
                            <label for="keterangan" class="mb-2"><span class="text-danger">*</span>Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="10" value="{{ old('keterangan') }}" placeholder="Tuliskan keterangan mengapa tidak dapat hadir!"></textarea>
                            @error('keterangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
