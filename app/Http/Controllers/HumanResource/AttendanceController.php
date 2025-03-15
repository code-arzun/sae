<?php

namespace App\Http\Controllers\HumanResource;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($year, Request $request)
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
        ]);
    }

    public function myattendance()
    {
        $user = User::has('employee')->get();

        $attendance = Attendance::where('employee_id', auth()->user()->employee_id)
                                ->whereDate('created_at', today())->first();

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

        // Pass the dates and attendance records to the view
        // return view('attendance.myattendance', compact('dates', 'myattendances'));
        return view('attendance.myattendance', compact('dates', 'myattendances', 'attendance'));
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
            'datang' => 'required_if:status,Hadir',
            'keterangan' => 'required_if:status,Tidak Hadir',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['employee_id'] = auth()->user()->employee_id;

        // try {
        Attendance::create($validatedData);

        // return Redirect::route('dashboard')->with('success', 'Data kehadiran berhasil dibuat!');
        return redirect()->back()->with('success', 'Absensi berhasil dibuat');
        // if ($request->ajax()) {
        //     return response()->json(['created' => true]);
        // }

        // return redirect()->back()->with('created', 'Absensi berhasil disimpan.');
        // } catch (\Exception $e) {
        //     if ($request->ajax()) {
        //         return response()->json(['created' => false, 'message' => $e->getMessage()]);
        //     }

        // return redirect()->back()->with('error', 'Gagal menyimpan absensi.');
        // }
    }
//     public function store(Request $request)
// {
//     $request->validate([
//         'status' => 'required',
//         'datang' => 'required_if:status,Hadir',
//         'keterangan' => 'required_if:status,Tidak Hadir',
//     ]);

//     try {
//         Attendance::create([
//             'employee_id' => auth()->user()->id,
//             'status' => $request->status,
//             'datang' => $request->datang,
//             'keterangan' => $request->keterangan,
//         ]);

//         if ($request->ajax()) {
//             return response()->json(['success' => true]);
//         }

//         return redirect()->back()->with('success', 'Absensi berhasil disimpan.');
//         } catch (\Exception $e) {
//             if ($request->ajax()) {
//                 return response()->json(['success' => false, 'message' => $e->getMessage()]);
//             }

//             return redirect()->back()->with('error', 'Gagal menyimpan absensi.');
//     }
// }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'pulang' => 'required',
            'work_journal' => 'required',
        ]);

        $attendance = Attendance::find($request->attendance);

        // Tambahkan debug untuk memverifikasi apakah attendance ditemukan
        if (!$attendance) {
            return response()->json(['success' => false, 'message' => 'Attendance tidak ditemukan'], 404);
        }

        $attendance->update([
            'pulang' => $validated['pulang'],
            'work_journal' => $validated['work_journal'],
        ]);

        // return response()->json(['success' => true, 'message' => 'Update berhasil']);
        return redirect()->back()->with('success', 'Update absensi berhasil');

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
