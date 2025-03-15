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
    // {
    //     return view('dashboard.index', [
    //         'so_bruto' => Order::sum('sub_total'),
    //         'so_nett' => Order::sum('grandtotal'),
    //         // 'so_diskon' => Order::sum('vat'),
    //         'total_paid' => Order::sum('pay'),
    //         'total_due' => Order::sum('due'),
    //         'pending_orders' => Order::where('order_status', 'pending')->get(),
    //         'complete_orders' => Order::where('order_status', 'complete')->get(),
    //         'products' => Product::orderBy('product_store')->take(5)->get(),
    //         'new_products' => Product::orderBy('buying_date')->take(2)->get(),
    //     ]);
    // }
    {
        $user = User::has('employee')->get();

        $attendance = Attendance::where('employee_id', auth()->user()->employee_id)
                                ->whereDate('created_at', today())->first();
                                
        return view('dashboard.index', compact('attendance'));
        // return view('dashboard.index');
    }
}
