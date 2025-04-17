<!-- Pulang -->
{{-- @if($attendance && $attendance->status == 'Hadir' && is_null($attendance->work_journal)) --}}
    <div class="modal fade" id="attendanceCheckoutModal" tabindex="-1" role="dialog" aria-labelledby="attendanceCheckoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendanceCheckoutModalLabel">Form Absensi Pulang</h5>
                    <span>{{ \Carbon\Carbon::parse()->translatedFormat('l, d F Y') }}</span>
                </div>
                <div class="modal-body">
                    <!-- Tampilkan Data Kehadiran yang Sudah Diisi -->
                    <div class="row d-flex flex-wrap align-items-top">
                        @if($attendance->status == 'Hadir')
                        <div class="form-group col-md-3 text-center">
                            <label class="mb-2">Status Kehadiran</label> <br>
                            <span class="badge bg-success">{{ $attendance->status }}</span>
                        </div>
                        <div class="form-group col-md-3 text-center">
                            <label class="mb-2">Datang</label>
                            <h5>{{ \Carbon\Carbon::parse($attendance->created_at)->translatedFormat('H:i') }}</h5>
                        </div>
                        <div class="form-group col-md-3 text-center">
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
                        <div class="row">
                            <!-- Jurnal Harian Kerja -->
                            @if (is_null($attendance->work_journal))
                            <div class="form-group col-md" id="work_journal">
                                <label for="work_journal" data-bs-toggle="tooltip" data-bs-placement="top" title="Wajib diisi!"><span class="text-danger">*</span>Worksheet Harian</label>
                                <textarea class="form-control @error('work_journal') is-invalid @enderror" id="work_journal" name="work_journal" rows="10" placeholder="Deskripsikan pekerjaan yang Anda selesaikan hari ini!" required></textarea>
                                @error('work_journal')
                                <div class="invalid-feedback">
                                    Worksheet harian belum diisi!
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('dashboard') }}"><span class="badge bg-warning">Isi Nanti</span></a>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                    @else
                    <div class="form-group col-md" id="work_journal">
                        <label for="work_journal" class="mb-2">Worksheet Harian</label>
                        <h5>{{ $attendance->work_journal }}</h5>
                    </div>
                        @endif
            </div>
        </div>
    </div>
    <!-- Auto trigger modal -->
    
{{-- @endif --}}