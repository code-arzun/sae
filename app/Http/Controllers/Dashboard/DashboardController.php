<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::has('employee')->get();
        $currentUser = auth()->user();

        $ordersQuery = Order::query();
        if ($currentUser->hasRole('Sales')) {
            $ordersQuery->whereHas('customer', function ($query) use ($currentUser) {
                $query->where('employee_id', $currentUser->employee_id);
            });
        } elseif ($currentUser->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin'])) { 
                $ordersQuery;
        } else if ($currentUser->hasAnyRole(['Admin Gudang'])) { 
            $ordersQuery;
        } else {
            abort(403, 'Unauthorized action.');
        }

        $orders = $ordersQuery->sortable()->filter(request(['search']))->orderBy('id', 'desc');

        $attendance = Attendance::where('employee_id', $currentUser->employee_id)
                                ->whereDate('created_at', today())->first();
                                
        return view('dashboard.index', compact('attendance', 'users', 'orders'), 
        [
            'title' => 'Dashboard'
        ]);
    }
}
