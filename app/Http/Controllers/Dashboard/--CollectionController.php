<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class CollectionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function storeCollection(Request $request)
    {
        $rules = [
            'order_id' => 'required|numeric',
            'payment_status' => 'nullable|string',
            'pay' => 'numeric|nullable',
            'due' => 'numeric|nullable',
        ];

        $invoice_no = IdGenerator::generate([
            'table' => 'collections',
            'field' => 'invoice_no',
            'length' => 7,
            'prefix' => 'Coll-'
        ]);

        $validatedData = $request->validate($rules);
        $validatedData['payment_date'] = Carbon::now()->format('Y-m-d');
        // $validatedData['payment_status'] = 'pending';
        $validatedData['invoice_no'] = $invoice_no;
        $validatedData['grandtotal'] = Order::grandtotal();
        $validatedData['due'] = Order::grandtotal() - $validatedData['pay'];
        $validatedData['created_at'] = Carbon::now();

        // $order_id = Order::insertGetId($validatedData);


        return Redirect::route('collection.index')->with('success', 'Collection has been created!');
    }

    public function invoiceDownload(Int $order_id)
    {
        $collection = Collection::where('id', $order_id)->first();

        return view('collection.invoice-collection', [
            'collection' => $collection,
        ]);
    }

    public function allDue()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        $collection = Collection::where('grandtotal', '>', '0')
            ->sortable()
            ->paginate($row);

        return view('collection.all-due', [
            'collection' => $collection
        ]);
    }

    public function pendingDue()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        $dues = Collection::where('due', '>', '0')
            ->sortable()
            ->paginate($row);

        return view('collection.pending-due', [
            'dues' => $dues
        ]);
    }

    public function paidDue()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        $paids = Order::where('due', '=', '0')
            ->sortable()
            ->paginate($row);

        return view('collection.paid-due', [
            'paids' => $paids
        ]);
    }

    public function orderDueAjax(Int $id)
    {
        $order = Order::findOrFail($id);

        return response()->json($order);
    }

    public function updateDue(Request $request)
    {
        $rules = [
            'order_id' => 'required|numeric',
            'due' => 'required|numeric',
        ];

        $validatedData = $request->validate($rules);

        $order = Order::findOrFail($request->order_id);
        $mainPay = $order->pay;
        $mainDue = $order->due;

        $paid_due = $mainDue - $validatedData['due'];
        $paid_pay = $mainPay + $validatedData['due'];

        Order::findOrFail($request->order_id)->update([
            'due' => $paid_due,
            'pay' => $paid_pay,
        ]);

        return Redirect::route('order.pendingDue')->with('success', 'Due Amount Updated Successfully!');
    }

}
