<?php

namespace App\Http\Controllers\Warehouse;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\DeliveryDetails;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle;

class DeliveryController extends Controller
{
    public function input()
    {
        $row = (int) request('row', 20);
        $salesorderFilter = request('order_id', null);
        $categoryFilter = request('category_id', null);
        $jenjang = request('jenjang', null);
        $kelas = request('kelas', null);
        $mapel = request('mapel', null);

        $ordersQuery = Order::query()->where('order_status', 'Disetujui');
        // $productsQuery = Product::query();
        $productsQuery = Product::query()->whereHas('orderDetails', function($query) use ($ordersQuery) {
            $query->whereIn('order_id', $ordersQuery->pluck('id'));
        });
        $categories = Product::select('category_id')->distinct()->get();

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        if ($salesorderFilter) {
            $productsQuery->whereHas('orderDetails', function($query) use ($salesorderFilter) {
                // Filter produk berdasarkan order_id dari relasi orderDetails
                $query->where('order_id', $salesorderFilter);
            });
        }

        // Ambil produk yang sudah difilter
        $products = $productsQuery->filter(request(['search']))->sortable()->paginate($row)->appends(request()->query());

        // Tambahkan data orderDetails berdasarkan SO yang dipilih
        foreach ($products as $product) {
            $product->filteredOrderDetail = $product->orderDetails->where('order_id', $salesorderFilter)->first();
            // Tentukan batas maksimal masing-masing item
            $product->maxQuantity = min($product->filteredOrderDetail->quantity ?? 0, $product->product_store);
        }

        if ($categoryFilter) {
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

        return view('warehouse.delivery.input', [
            'salesorders' => $ordersQuery->get(),
            'productItem' => Cart::content(),
            'products' => $products,
            'categories' => $categories,
            'title' => 'Input Delivery Order'
        ]);
    }

    public function inputdoConfirmation(Request $request)
    {
        $rules = [
            'order_id' => 'required',
            'delivery_date' => 'date_format:Y-m-d|max:10',
        ];

        $validatedData = $request->validate($rules);
            $salesorder = Order::findOrFail($validatedData['order_id']);
            $validatedData[('order_date')] = $request->input('order_date');
            $content = Cart::content();
            $subtotal = Cart::subtotal();

        return view('warehouse.delivery.confirmation', [
            'salesorder' => $salesorder,
            'content' => $content,
            'subtotal' => $subtotal,
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

            return Redirect::back()->with('success', 'Produk berhasil ditambahkan!');
        }

        public function updateCart(Request $request, $rowId)
        {
            $rules = [
                'qty' => 'required|numeric',
            ];

            $validatedData = $request->validate($rules);

            Cart::update($rowId, $validatedData['qty']);
            
            return Redirect::back()->with('success', 'Jumlah produk berhasil ditambahkan!');
        }
               
        public function deleteCart(String $rowId)
        {
            Cart::remove($rowId);

            return Redirect::back()->with('success', 'Produk berhasil dihapus dari pesanan!');
        }
    // 

    private function storeDeliveryOrder(Request $request, $suffix)
    {
        // Validate input
        $rules = [
            'order_id' => 'required|numeric',
        ];
        $validatedData = $request->validate($rules);

        // Ambil invoice terakhir tanpa mempertimbangkan suffix (R, H, RS, HS)
        $lastOrder = Delivery::where('invoice_no', 'like', 'DO-%-%')->orderByDesc('id')->first();

        // Ambil angka terakhir dari invoice terakhir
        if ($lastOrder) {
            preg_match('/DO-(\d+)-/', $lastOrder->invoice_no, $matches);
            $lastNumber = isset($matches[1]) ? (int) $matches[1] : 0;
        } else {
            $lastNumber = 0;
        }

        // Buat angka baru dengan format 4 digit
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $invoice_no = "DO-$newNumber-$suffix";

        // Prepare delivery data
        $validatedData['delivery_date'] = Carbon::now()->format('d-m-Y');
        $validatedData['delivery_status'] = 'Siap dikirim';
        $validatedData['total_products'] = Cart::count();
        $validatedData['sub_total'] = Cart::subtotal();
        $validatedData['invoice_no'] = $invoice_no;
        $validatedData['packed_at'] = Carbon::now();
        $validatedData['created_at'] = Carbon::now();

        // Insert delivery data
        $delivery_id = Delivery::insertGetId($validatedData);

        // Insert delivery details
        $contents = Cart::content();
        foreach ($contents as $content) {
            DeliveryDetails::insert([
                'delivery_id' => $delivery_id,
                'product_id' => $content->id,
                'quantity' => $content->qty,
                'unitcost' => $content->price,
                'total' => $content->total,
                'created_at' => Carbon::now(),
            ]);
        
            OrderDetails::where('order_id', $request->order_id)
                ->where('product_id', $content->id)
                ->update([
                    'to_send' => DB::raw('GREATEST(to_send - '.$content->qty.', 0)'),
                    // 'ready_to_send' => DB::raw('GREATEST(to_send - '.$content->qty.' + ready_to_send, 0)'),
                    'ready_to_send' => DB::raw('GREATEST(ready_to_send + '.$content->qty.', 0)'),
                    // 'ready_to_send' => $content->qty
                ]);
        }

        // Update shipping_status di orders
        $salesorder = Order::findOrFail($request->order_id);
        $salesorder->update(['shipping_status' => $request->shipping_status]);

        // Reduce the stock (Mengurangi Stok)
        $products = DeliveryDetails::where('delivery_id', $delivery_id)->get();

        foreach ($products as $product) {
            Product::where('id', $product->product_id)->update([
                'product_store' => DB::raw('GREATEST(product_store - '.$product->quantity.', 0)'),
                'product_ordered' => DB::raw('GREATEST(product_ordered - '.$product->quantity.', 0)'),
                'stock_needed' => DB::raw('GREATEST(product_ordered - product_store, 0)')
            ]);
        }

        // Clear the cart
        Cart::destroy();
        
        // Redirect with success message
        return redirect()->route('input.do')->with('created', 'Delivery Order berhasil dibuat!');
    }

    // Store
        public function storeDOReguler(Request $request)
        {
            return $this->storeDeliveryOrder($request, 'RO');
        }

        public function storeDOHET(Request $request)
        {
            return $this->storeDeliveryOrder($request, 'HO');
        }

        public function storeDOROnline(Request $request)
        {
            return $this->storeDeliveryOrder($request, 'RS');
        }

        public function storeDOHOnline(Request $request)
        {
            return $this->storeDeliveryOrder($request, 'HS');
        }
    //

    // Update Status
        public function sentStatus(Request $request)
        {
            $delivery_id = $request->id;
        
            // Update status pengiriman di tabel Delivery
            Delivery::findOrFail($delivery_id)
                ->update([
                    'delivery_status' => 'Dalam Pengiriman',
                    'sent_at' => Carbon::now()
                ]);
        
            // Ambil order_id dari tabel deliveries
            $order_id = Delivery::where('id', $delivery_id)->value('order_id');
        
            // Ambil daftar product_id dan quantity dari delivery_details
            $productQuantities = DeliveryDetails::where('delivery_id', $delivery_id)
                ->select('product_id', 'quantity')
                ->get();
        
            // Update order_details berdasarkan order_id dan product_id
            foreach ($productQuantities as $product) {
                OrderDetails::where('order_id', $order_id)  // Gunakan order_id dari deliveries
                    ->where('product_id', $product->product_id)
                    ->update([
                        'ready_to_send' => DB::raw("GREATEST(ready_to_send - {$product->quantity}, 0)"),
                        'sent' => DB::raw("sent + {$product->quantity}")
                    ]);
            }
        
            return back()->with('success', 'Status pesanan diperbarui menjadi Dalam Pengiriman!');
        }

        public function deliveredStatus(Request $request)
        {
            $delivery_id = $request->id;
        
            Delivery::findOrFail($delivery_id)
                ->update([
                    'delivery_status' => 'Terkirim',
                    'delivered_at' => Carbon::now()
                ]);
        
            $order_id = Delivery::where('id', $delivery_id)->value('order_id');
        
            $productQuantities = DeliveryDetails::where('delivery_id', $delivery_id)->select('product_id', 'quantity')->get();
        
            foreach ($productQuantities as $product) {
                OrderDetails::where('order_id', $order_id)
                    ->where('product_id', $product->product_id)
                    ->update([
                        'sent' => DB::raw("GREATEST(sent - {$product->quantity}, 0)"),
                        'delivered' => DB::raw("delivered + {$product->quantity}")
                    ]);
            }
        
            return back()->with('success', 'Status pesanan diperbarui menjadi Terkirim!');
        }
    //
    public function index()
    {
        $row = (int) request('row', 10000);

        $user = auth()->user();
        $deliveryInvoiceNo = request('delivery_invoice_no', null);  // Get delivery invoice number from request
        $orderInvoiceNo = request('order_invoice_no', null);  // Get order invoice number from request
        $salesFilter = request('employee_id', null);
        $statusFilter = request('delivery_status', null);

        // Query dasar
        $ordersQuery = Order::whereIn('order_status', ['Disetujui', 'Selesai']);
        $query = Delivery::with('salesorder');

        // Filter berdasarkan status jika diberikan
        if (!empty($statusFilter)) {
            $query->where('delivery_status', 'like', "%$statusFilter%");
        }

        // Filter berdasarkan peran user
        if ($user->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang'])) {
            $deliveries = $query;
        } elseif ($user->hasRole('Sales')) {
            $deliveries = $query->whereHas('salesorder.customer', function ($query) use ($user) {
                $query->where('employee_id', $user->employee_id);
            });
        } else {
            abort(403, 'Unauthorized action.');
        }

        // Filter berdasarkan delivery invoice_no jika ada
        $deliveries = $deliveries->when($deliveryInvoiceNo, function ($query, $deliveryInvoiceNo) {
            return $query->where('invoice_no', 'like', "%$deliveryInvoiceNo%");
        });

        // Filter by order invoice_no if provided
        $deliveries = $deliveries->when($orderInvoiceNo, function ($query, $orderInvoiceNo) {
            return $query->whereHas('salesorder', function ($query) use ($orderInvoiceNo) {
                $query->where('invoice_no', 'like', "%$orderInvoiceNo%");
            });
        });

        $deliveryStatus = Delivery::select('delivery_status')->distinct()->pluck('delivery_status');

        if ($salesFilter) {
            $deliveries = $query->whereHas('salesorder.customer', function ($query) use ($salesFilter) {
                $query->where('employee_id', $salesFilter);
            });
        }

        // Sortable dan filter tambahan
        $orders = $ordersQuery->sortable()->filter(request(['search']))->orderBy('id', 'desc')->paginate($row);
        $deliveries = $deliveries->sortable()->filter(request(['search']))->orderBy('id', 'desc')->paginate($row);

        $sales = Customer::select('employee_id')->distinct()->get();

        // return $deliveries;
        return view("warehouse.delivery.index", [
            'orders' => $orders,
            'deliveries' => $deliveries,
            'sales' => $sales,
            'deliveryStatus' => $deliveryStatus,
            'title' => 'Data Delivery Order',
        ]);
    }

    public function deliveryDetails(Int $delivery_id)
    {
        $delivery = Delivery::where('id', $delivery_id)->first();
        $deliveryDetails = DeliveryDetails::with('product')
                        ->where('delivery_id', $delivery_id)
                        ->orderBy('id', 'ASC')
                        ->get();

        return view('warehouse.delivery.details', [
            'delivery' => $delivery,
            'deliveryDetails' => $deliveryDetails,
            'title' => 'Detail Delivery Order',
        ]);
    }

    public function invoiceDownload(Int $delivery_id)
    {
        $deliveries = Delivery::where('id', $delivery_id)->first();
        $salesorder = Order::where('id', ['order_id'])->first();
        $deliveryDetails = DeliveryDetails::with('product')
                        ->where('delivery_id', $delivery_id)
                        ->orderby('id', 'asc')
                        ->get();

        // show data (only for debugging)
        return view('warehouse.delivery.invoice-delivery', [
            'deliveries' => $deliveries,
            'salesorder' => $salesorder,
            'deliveryDetails' => $deliveryDetails,
        ]);
    }
    
    public function labelPengiriman(Int $delivery_id)
    {
        // $orders = Order::where()
        $deliveries = Delivery::where('id', $delivery_id)->first();
        $deliveryDetails = DeliveryDetails::with('product')
                        ->where('delivery_id', $delivery_id)
                        ->orderby('id', 'asc')
                        ->get();

        // show data (only for debugging)
        return view('warehouse.delivery.label-pengiriman', [
            'deliveries' => $deliveries,
            'deliveryDetails' => $deliveryDetails,
        ]);
    }

    // Download Excel
    public function exportExcel($orders)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');

        try {
            $spreadSheet = new Spreadsheet();
            $sheet = $spreadSheet->getActiveSheet();
            $sheet->getDefaultColumnDimension()->setWidth(20);

            // Menambahkan data ke sheet mulai dari A1
            $sheet->fromArray($orders, null, 'A1');

            // Menentukan range header (baris pertama)
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn(); // Kolom terakhir yang ada datanya
            $headerRange = "A1:{$highestColumn}1";

            // Terapkan gaya header (hanya centering)
            $sheet->getStyle($headerRange)->applyFromArray([
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Format Tanggal (dd/mm/yyyy)
            $dateColumns = ['A', 'C']; // Sesuaikan dengan posisi kolom di Excel
            foreach ($dateColumns as $col) {
                $sheet->getStyle("{$col}2:{$col}{$highestRow}")
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }

            // Format Currency (Rp)
            $currencyColumns = ['H']; // Kolom untuk Bruto, Diskon (Rp), dll.
            foreach ($currencyColumns as $col) {
                $sheet->getStyle("{$col}2:{$col}{$highestRow}")
                    ->getNumberFormat()
                    ->setFormatCode('"Rp" #,##0');
            }

            $timestampColumns = ['J', 'K', 'L']; // Sesuaikan dengan posisi kolom di Excel
            foreach ($timestampColumns as $col) {
                $sheet->getStyle("{$col}2:{$col}{$highestRow}")
                    ->getNumberFormat()
                    ->setFormatCode('dd/mm/yyyy hh:mm:ss');
            }

            // **Menjadikan data sebagai tabel di dalam Excel**
            $table = new Table("A1:{$highestColumn}{$highestRow}");
            $table->setName("DeliveryOrderTable");
            $table->setShowHeaderRow(true);
            $table->getAllowFilter(true); // Tambahkan filter otomatis
            
            // **Menambahkan banded row**
            $tableStyle = new TableStyle();
            $tableStyle->setTheme(TableStyle::TABLE_STYLE_MEDIUM2); // Tambahkan efek banded row
            $table->setStyle($tableStyle);

            $sheet->addTable($table);

            // Buat nama file dengan timestamp
            $filename = 'Delivery Order_' . date('dmY_His') . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            ob_end_clean();
            $Excel_writer = new Xlsx($spreadSheet);
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }

    function exportData()
    {
        $deliveries = Delivery::all()->sortByDesc('delivery_id');

        $order_array[] = [
            'Tanggal DO',
            'ID Delivery Order',
            'Tanggal Pemesanan',
            'ID Sales Order',
            'Nama Lembaga',
            'Nama Customer',
            'Sales',
            'Bruto (Rp)',
            'Status Pengiriman',
            'Terpacking',
            'Dikirim',
            'Terkirim',
        ];

        foreach ($deliveries as $delivery) {
            $order_array[] = [
                \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(\Carbon\Carbon::parse($delivery->delivery_date)->startOfDay()),
                $delivery->invoice_no,
                \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(\Carbon\Carbon::parse($delivery->salesorder->order_date)->startOfDay()),
                $delivery->salesorder->invoice_no,
                $delivery->salesorder->customer->NamaLembaga,
                $delivery->salesorder->customer->NamaCustomer,
                $delivery->salesorder->customer->employee->name,
                $delivery->sub_total,
                $delivery->delivery_status,
                \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(\Carbon\Carbon::parse($delivery->packed_at)),
                \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(\Carbon\Carbon::parse($delivery->sent_at)),
                \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(\Carbon\Carbon::parse($delivery->delivered_at)),
            ];
        }

        $this->exportExcel($order_array);
    }

}
