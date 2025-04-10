<?php

namespace App\Http\Controllers\HumanResource;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function allAttendance($year, Request $request)
    {
        // Ambil bulan dari request, atau gunakan bulan saat ini jika tidak ada
        $month = $request->get('month', date('n'));

        // Tentukan awal dan akhir bulan
        $startOfMonth = Carbon::createFromDate($year, $month, 1);
        $endOfMonth = Carbon::createFromDate($year, $month, cal_days_in_month(CAL_GREGORIAN, $month, $year));

        // Buat koleksi tanggal
        $dates = collect();
        $currentDate = $startOfMonth->copy();

        while ($currentDate->lte($endOfMonth)) {
            $dates->push($currentDate->copy());
            $currentDate->addDay();
        }

        // Ambil semua pegawai
        $employees = Employee::orderBy('name')->get();

        $attendances = Attendance::with('employee')
                ->whereBetween('created_at', [$startOfMonth->startOfDay(), $endOfMonth->endOfDay()])
                ->orderBy('created_at', 'asc')
                ->get()
                ->groupBy(function($item) {
                    return Carbon::parse($item->created_at)->format('d M Y'); // Group by date
                });

        return view('attendance.index', [
            'currentYear' => $year,
            'currentMonth' => $month,
            'dates' => $dates,
            'employees' => $employees,
            'attendances' => $attendances,
            'title' => 'Daftar Kehadiran Pegawai'
        ]);
    }

    public function index()
    {
        $attendance = Attendance::where('employee_id', auth()->user()->employee_id)->whereDate('created_at', today())->first();

        $showCheckoutModal = false;

        if ($attendance && $attendance->status == 'Hadir' && is_null($attendance->work_journal)) {
            $showCheckoutModal = true;
        }

        $authenticatedUser = auth()->user(); // Get the authenticated user

        // Get the current date
        $today = Carbon::today();

        // Get the start and end of the current month
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();

        // Generate dates from the start to the end of the current month
        $dates = [];
        $currentDate = $startOfMonth->copy();
        while ($currentDate->lte($endOfMonth)) {
            $dates[] = $currentDate->copy();
            $currentDate->addDay();
        }

        // Retrieve attendance records for the authenticated user for the current month
        $myattendances = Attendance::where('employee_id', $authenticatedUser->employee_id)
            ->whereBetween('created_at', [$startOfMonth->startOfDay(), $endOfMonth->endOfDay()])
            ->orderBy('created_at', 'asc')->get();

        return view('attendance.user', array_merge(
            compact('dates', 'myattendances', 'attendance', 'showCheckoutModal'),
            ['title' => 'Daftar Kehadiran Saya']
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::has('employee')->get();

        // Ambil data absensi terakhir dari database untuk pengguna
        $attendance = Attendance::where('employee_id', auth()->user()->employee_id)
                                ->whereDate('created_at', today())->first();

        return view('attendance.create', [
            'users' => $users,
            'attendance' => $attendance,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'status' => 'required',
            'keterangan' => 'required_if:status,Tidak Hadir',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['employee_id'] = auth()->user()->employee_id;

        Attendance::create($validatedData);

        return back()->with('success', 'Absensi berhasil dibuat');
    }

    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);

        // Pastikan hanya bisa edit milik sendiri (jika pakai auth)
        if ($attendance->employee_id !== Auth::user()->employee->id) {
            abort(403, 'Unauthorized access');
        }

        // Tampilkan halaman edit (modal bisa disisipkan di sana)
        return view('attendance.edit', compact('attendance'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request)
    // {
    //     $validated = $request->validate([
    //         'work_journal' => 'required',
    //     ]);

    //     $attendance = Attendance::find($request->attendance);

    //     // Tambahkan debug untuk memverifikasi apakah attendance ditemukan
    //     if (!$attendance) {
    //         return response()->json(['success' => false, 'message' => 'Attendance tidak ditemukan'], 404);
    //     }

    //     $attendance->update([
    //         'work_journal' => $validated['work_journal'],
    //     ]);

    //     return redirect()->back()->with('success', 'Update absensi berhasil');

    // }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        if ($request->has('work_journal')) {
            // berarti ini checkout
            $request->validate([
                'work_journal' => 'required|string',
            ]);

            $attendance->update([
                'work_journal' => $request->work_journal,
                'updated_at' => now(),
            ]);
        }

        // Tambahkan logic lain kalau kamu ingin handle update selain checkout

        return redirect()->back()->with('success', 'Data absensi diperbarui.');
    }


    public function show($id)
    {
        // Retrieve the authenticated user
        $authenticatedUser = auth()->user();
    
        // Find the attendance record by ID and ensure it belongs to the authenticated user
        $attendance = Attendance::where('employee_id', $authenticatedUser->employee_id)
            ->where('id', $id)
            ->firstOrFail();
    
        // Return the view with the attendance details
        return view('attendance.show', compact('attendance'));
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }

}
