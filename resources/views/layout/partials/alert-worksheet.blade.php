@if ((!isset($attendance)) 
        && (Carbon\Carbon::now()->format('H:i') >= '15:00'
        && Carbon\Carbon::now()->format('H:i') <= '17:00'
        && Carbon\Carbon::now()->format('l') != 'Sunday'
    ))

<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <span class="fw-bold fs-5 text-danger">* Jangan lupa mengisi
        <span class="text-secondary">worksheet harian</span>
        di halaman 
        <a href="{{ route('attendance.index') }}">absensi</a>! *
    </span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

@endif