<?php

namespace App\Http\Controllers\Warehouse;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Retur;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\ReturDetails;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ReturController extends Controller
{
    public function input()
    {
        $row = (int) request('row', 20);
        $deliveryOrderFilter = request('delivery_id', null);
        $categoryFilter = request('category_id', null);
        $jenjang = request('jenjang', null);
        $kelas = request('kelas', null);
        $mapel = request('mapel', null);

        $deliveriesQuery = Delivery::query()->where('delivery_status', 'Terkirim');
        $productsQuery = Product::query()->whereHas('deliveryDetails', function($query) use ($deliveriesQuery) {
            $query->whereIn('delivery_id', $deliveriesQuery->pluck('id'));
        });
        $categories = Product::select('category_id')->distinct()->get();

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        if ($deliveryOrderFilter) {
            $productsQuery->whereHas('deliveryDetails', function($query) use ($deliveryOrderFilter) {
                $query->where('delivery_id', $deliveryOrderFilter);
            });
        }

        if ($categoryFilter)  {
            $productsQuery->where('category_id', $categoryFilter);
        }

        if ($jenjang) {
            $productsQuery->where('product_name', 'like', "%$jenjang%");
        }

        if ($kelas) {
            $productsQuery->where('product_name', 'like', "%$kelas%");
        }
        
        if ($mapel) {
            $productsQuery->where('product_name', 'like', "%$mapel%");
        }

        return view('warehouse.retur.input', [
            'deliveryOrders' => $deliveriesQuery->get(),
            'productItem' => Cart::content(),
            'products' => $productsQuery->filter(request(['search']))
                            ->sortable()->paginate($row)->appends(request()->query()),
            'categories' => $categories,
        ]);
    }
    
    // Cart
        public function addCart(Request $request)
        {
            $rules = [
                'id' => 'required|numeric',
                'name' => 'required|string',
                'category' => 'required|string',
                'price' => 'required|numeric',
            ];

            $validatedData = $request->validate($rules);

            Cart::add([
                'id' => $validatedData['id'],
                'name' => $validatedData['name'],
                'category' => $validatedData['category'],
                'qty' => 1,
                'price' => $validatedData['price'],
                'options' => ['size' => 'large']
            ]);

            return Redirect::back()->with('success', 'Product has been added!');
        }

        public function updateCart(Request $request, $rowId)
        {
            $rules = [
                'qty' => 'required|numeric',
            ];

            $validatedData = $request->validate($rules);

            Cart::update($rowId, $validatedData['qty']);
            
            return Redirect::back()->with('success', 'Cart has been updated!');
        }
        
        public function deleteCart(String $rowId)
        {
            Cart::remove($rowId);

            return Redirect::back()->with('success', 'Cart has been deleted!');
        }
    //
    
    public function inputReturConfirmation(Request $request)
    {
        $rules = [
            'delivery_id' => 'required',
            // 'retur_date' => 'date_format:Y-m-d|max:10',
            'discount_percent' => 'numeric|required',
        ];

        $validatedData = $request->validate($rules);
            $deliveryorder = Delivery::findOrFail($validatedData['delivery_id']);
            $validatedData[('delivery_date')] = $request->input('delivery_date');
            $content = Cart::content();
            $subtotal = Cart::subtotal();
            $discountPercent = $validatedData['discount_percent'];
            $discountRp = ($subtotal * $discountPercent) / 100;
            $grandtotal = $subtotal - $discountRp;

        return view('warehouse.retur.confirmation', [
            'deliveryorder' => $deliveryorder,
            'content' => $content,
            'subtotal' => $subtotal,
            'discount_percent' => $discountPercent,
            'discount_rp' => $discountRp,
            'grandtotal' => $grandtotal,
        ]);
    }

    private function storeRetur(Request $request, $prefix)
    {
        // Validate input
        $rules = [
            'delivery_id' => 'required|numeric',
            'discount_percent' => 'numeric|required',
            'discount_rp' => 'numeric|nullable',
            'grandtotal' => 'numeric|nullable',
            
        ];
        $validatedData = $request->validate($rules);

        $discount_percent = $request->input('discount_percent');
        $sub_total = Cart::subtotal();
        $discount_rp = $sub_total * ($discount_percent / 100);
        $grandtotal = $sub_total - $discount_rp;

        // Determine the length based on the prefix
        $length = (in_array($prefix, ['ROR-', 'ROH-'])) ? 8 : 9;

        // Generate invoice number
        $invoice_no = IdGenerator::generate([
            'table' => 'returs',
            'field' => 'invoice_no',
            'length' => $length,
            'prefix' => $prefix,
        ]);

        // Prepare Retur data
        $validatedData['retur_date'] = Carbon::now()->format('d-m-Y');
        $validatedData['retur_status'] = 'Diajukan';
        $validatedData['total_products'] = Cart::count();
        $validatedData['sub_total'] = Cart::subtotal();
        $validatedData['discount_percent'] = $discount_percent;
        $validatedData['discount_rp'] = $discount_rp;
        $validatedData['grandtotal'] = $grandtotal;
        $validatedData['invoice_no'] = $invoice_no;
        $validatedData['created_at'] = Carbon::now();

        // Insert Retur data
        $retur_id = Retur::insertGetId($validatedData);

        // Insert delivery details
        $contents = Cart::content();
        foreach ($contents as $content) {
            ReturDetails::insert([
                'retur_id' => $retur_id,
                'product_id' => $content->id,
                'quantity' => $content->qty,
                'unitcost' => $content->price,
                'total' => $content->total,
                'created_at' => Carbon::now(),
            ]);
        }

        // Clear the cart
        Cart::destroy();

        // Redirect with success message
        return redirect()->route('input.retur')->with('created', 'Retur berhasil dibuat!');
    }

        public function storeROReguler(Request $request)
        {
            return $this->storeRetur($request, 'ROR-');
        }

        public function storeROHET(Request $request)
        {
            return $this->storeRetur($request, 'ROH-');
        }

        public function storeROROnline(Request $request)
        {
            return $this->storeRetur($request, 'RORS-');
        }

        public function storeROHOnline(Request $request)
        {
            return $this->storeRetur($request, 'ROHS-');
        }
    //

    private function getReturs($view, $status = null)
    {
        $row = (int) request('row', 10000);

        $user = auth()->user();
        $returInvoiceNo = request('retur_invoice_no', null);
        $deliveryInvoiceNo = request('delivery_invoice_no', null);
        $orderInvoiceNo = request('order_invoice_no', null);
        $salesFilter = request('employee_id', null);

        $query = Retur::query();

        if ($status) {
            $query->where('retur_status', 'like', "%$status%");
        }

        if ($user->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin'])) {
            $returs = $query;
        } elseif ($user->hasRole('Sales')) {
            $returs = $query->whereHas('delivery.salesorder.customer', function ($query) use ($user) {
                $query->where('employee_id', $user->employee_id);
            });
        } else {
            abort(403, 'Unauthorized action.');
        }

        $returs = $returs->when($returInvoiceNo, function ($query, $returInvoiceNo) {
            return $query->where('invoice_no', 'like', "%$returInvoiceNo%");
        });

        $returs = $returs->when($deliveryInvoiceNo, function ($query, $deliveryInvoiceNo) {
            return $query->whereHas('delivery', function ($query) use ($deliveryInvoiceNo) {
                $query->where('invoice_no', 'like', "%$deliveryInvoiceNo%");
            });
        });

        $returs = $returs->when($orderInvoiceNo, function ($query, $orderInvoiceNo) {
            return $query->whereHas('salesorder', function ($query) use ($orderInvoiceNo) {
                $query->where('invoice_no', 'like', "%$orderInvoiceNo%");
            });
        });

        if ($salesFilter) {
            $returs = $query->whereHas('delivery.salesorder.customer', function ($query) use ($salesFilter) {
                $query->where('employee_id', $salesFilter);
            });
        }

        $returs = $returs->sortable()->filter(request(['search']))->orderBy('id', 'desc')->paginate($row);

        $sales = Customer::select('employee_id')->distinct()->get();

        return view("warehouse.retur.$view", [
            'returs' => $returs,
            'sales' => $sales,
        ]);
    }
        // View
            public function all()
            {
                return $this->getReturs('all', null);
            }

            public function proposed()
            {
                return $this->getReturs('proposed', '%Diajukan%');
            }

            public function approved()
            {
                return $this->getReturs('approved', '%Disetujui%');
            }

            public function declined()
            {
                return $this->getReturs('declined', '%Ditolak%');
            }

            public function cancelled()
            {
                return $this->getReturs('cancelled', '%Dibatalkan%');
            }
        // 

    public function returDetails(Int $retur_id)
    {
        $returs = Retur::where('id', $retur_id)->first();
        $returDetails = ReturDetails::with('product')->where('retur_id', $retur_id)
                        ->orderBy('id', 'ASC')->get();

        return view('warehouse.retur.details-retur', [
            'returs' => $returs,
            'returDetails' => $returDetails,
        ]);
    }
    // Update Status
        function approvedStatus(Request $request)
        {
            $retur_id = $request->id;

            // Add the stock (Tambah Stok)
            $products = ReturDetails::where('retur_id', $retur_id)->get();

            foreach ($products as $product) {
            Product::where('id', $product->product_id)
                ->update([
                    'product_store' => DB::raw('product_store + '.$product->quantity),
                    'stock_needed' => DB::raw('GREATEST(product_ordered - product_store, 0)')
                ]);
            }

            Retur::findOrFail($retur_id)->update(['retur_status' => 'Disetujui']);

            return back()->with('success', 'Status pesanan diperbarui menjadi disetujui!');
        }

        public function declinedStatus(Request $request)
        {
            $retur_id = $request->id;

            Retur::findOrFail($retur_id)->update(['retur_status' => 'Ditolak']);

            return back()->with('success', 'Pesanan telah ditolak!');
        }

        public function cancelledStatus(Request $request)
        {
            $retur_id = $request->id;

            Retur::findOrFail($retur_id)->update(['retur_status' => 'Dibatalkan']);

            return back()->with('success', 'Pesanan telah dibatalkan!');
        }
    //

}
