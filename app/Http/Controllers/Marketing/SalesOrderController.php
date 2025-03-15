<?php

namespace App\Http\Controllers\Marketing;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\Collection;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\DeliveryDetails;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Gloudemans\Shoppingcart\Facades\Cart;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle;

class SalesOrderController extends Controller
{
    // Input Page
    public function input()
    {
        $row = (int) request('row', 20);
        $user = auth()->user();
        $categoryFilter = request('category_id', null);
        $jenjang = request('jenjang', null);
        $kelas = request('kelas', null);
        $mapel = request('mapel', null);

        $productsQuery = Product::query();
        $customersQuery = Customer::with(['employee']);
        // $customersQuery = Customer::all();
        $categories = Product::select('category_id')->distinct()->get();
        

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        if ($user->hasRole('Sales')) {
            $customersQuery->where('employee_id', $user->employee_id);
        } else {
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

        $customers = $customersQuery->get();

        return view('marketing.salesorder.input', [
        // return view('marketing.inputso.index', [
            'customers' => $customers,
            'productItem' => Cart::content(),
            'products' => $productsQuery->filter(request(['search']))->sortable()->paginate($row)->appends(request()->query()),
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

            return Redirect::back()->with('success', 'Produk berhasil ditambahkan!');
        }

        public function updateCart(Request $request, $rowId)
        {
            $rules = [
                'qty' => 'required|numeric',
            ];

            $validatedData = $request->validate($rules);

            Cart::update($rowId, $validatedData['qty']);
            
            return Redirect::back()->with('success', 'Jumlah berhasil diperbarui!');
        }
        
        public function deleteCart(String $discount)
        {
            Cart::remove($discount);

            return Redirect::back()->with('success', 'Produk berhasil dihapus!');
        }
    // 

    // Confirmation Page
    public function inputSoConfirmation(Request $request)
    {
        $rules = [
            'customer_id' => 'required',
            'discount_percent' => 'numeric|required',
            'order_date' => 'date_format:Y-m-d|max:10',
            'pay' => 'integer|nullable',
            'due' => 'integer|nullable',
        ];

        $validatedData = $request->validate($rules);
            $customer = Customer::findOrFail($validatedData['customer_id']);
            $validatedData[('order_date')] = $request->input('order_date');
            $content = Cart::content();
            $subtotal = Cart::subtotal();
            $discountPercent = $validatedData['discount_percent'];
            $discountRp = ($subtotal * $discountPercent) / 100;
            $grandtotal = $subtotal - $discountRp;

        return view('marketing.salesorder.confirmation', [
            'customer' => $customer,
            'content' => $content,
            'subtotal' => $subtotal,
            'discount_percent' => $discountPercent,
            'discount_rp' => $discountRp,
            'grandtotal' => $grandtotal,
        ]);
    }

    private function storeOrder(Request $request, $suffix)
    {
        // Validasi input
        $rules = [
            'customer_id' => 'required|numeric',
            'discount_percent' => 'numeric|required',
            'discount_rp' => 'numeric|nullable',
            'grandtotal' => 'numeric|nullable',
            'pay' => 'numeric|nullable',
            'due' => 'numeric|nullable',
        ];

        $validatedData = $request->validate($rules);

        // Perhitungan diskon
        $discount_percent = $request->input('discount_percent');
        $sub_total = Cart::subtotal();
        $discount_rp = $sub_total * ($discount_percent / 100);
        $grandtotal = $sub_total - $discount_rp;

        // Ambil invoice terakhir tanpa mempertimbangkan suffix (RO, HO, RS, HS)
        $lastOrder = Order::where('invoice_no', 'like', 'SO-%-%')->orderByDesc('id')->first();

        // Ambil angka terakhir dari invoice terakhir
        if ($lastOrder) {
            preg_match('/SO-(\d+)-/', $lastOrder->invoice_no, $matches);
            $lastNumber = isset($matches[1]) ? (int) $matches[1] : 0;
        } else {
            $lastNumber = 0;
        }

        // Buat angka baru dengan format 4 digit
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $invoice_no = "SO-$newNumber-$suffix";
        // $invoice_no = "SO$suffix-$newNumber";

        // Persiapkan data
        $validatedData['order_date'] = Carbon::now()->format('d-m-Y');
        $validatedData['payment_method'] = $request->input('payment_method', 'Transfer Tempo');
        $validatedData['order_status'] = 'Menunggu persetujuan';
        $validatedData['total_products'] = Cart::count();
        $validatedData['sub_total'] = $sub_total;
        $validatedData['discount_percent'] = $discount_percent;
        $validatedData['discount_rp'] = $discount_rp;
        $validatedData['grandtotal'] = $grandtotal;
        $validatedData['invoice_no'] = $invoice_no;
        $validatedData['due'] = $sub_total;
        $validatedData['shipping_status'] = 'Belum ada pengiriman';
        $validatedData['payment_status'] = 'Belum dibayar';
        $validatedData['created_at'] = Carbon::now();

        // Simpan data pesanan
        $order_id = Order::insertGetId($validatedData);

        // Simpan detail pesanan
        $contents = Cart::content();
        foreach ($contents as $content) {
            OrderDetails::insert([
                'order_id' => $order_id,
                'product_id' => $content->id,
                'quantity' => $content->qty,
                'unitcost' => $content->price,
                'total' => $content->total,
                'to_send' => $content->qty,
                'ready_to_send' => 0,
                'sent' => 0,
                'delivered' => 0,
                'created_at' => Carbon::now(),
            ]);
        }

        // Hapus keranjang
        Cart::destroy();

        // Redirect ke inputso.index dengan pesan sukses
        return Redirect::route('input.so')->with('created', 'Sales Order berhasil dibuat!');
    }
    // Store methods dengan suffix sesuai format SO-(0001)-X
        public function storeSOReguler(Request $request)
        {
            return $this->storeOrder($request, 'RO');
        }

        public function storeSOHET(Request $request)
        {
            return $this->storeOrder($request, 'HO');
        }

        public function storeSOROnline(Request $request)
        {
            return $this->storeOrder($request, 'RS');
        }

        public function storeSOHOnline(Request $request)
        {
            return $this->storeOrder($request, 'HS');
        }
    //

    // Update Status
        // Setujui
        function approvedStatus(Request $request)
        {
            $order_id = $request->id;

            // Ambil detail order
            $products = OrderDetails::where('order_id', $order_id)->get();

            foreach ($products as $product) {
                $productRecord = Product::where('id', $product->product_id)->first();

                // Hitung nilai baru product_ordered
                $newProductOrdered = $productRecord->product_ordered + $product->quantity;

                // Hitung stock_needed sebagai selisih antara product_ordered dan product_store
                // Jika product_ordered tidak melebihi product_store, stock_needed akan tetap 0
                $newStockNeeded = max($newProductOrdered - $productRecord->product_store, 0);

                // Update product_ordered dan stock_needed
                Product::where('id', $product->product_id)->update
                    ([
                        'product_ordered' => $newProductOrdered,
                        'stock_needed' => $newStockNeeded
                    ]);
            }

            // Update status order menjadi 'Disetujui'
            Order::findOrFail($order_id)->update(['order_status' => 'Disetujui']);

            // Redirect dengan pesan sukses
            return back()->with('success', 'Sales Order disetujui. Silakan cek halaman SO disetujui');
        }

        // Tolak
        public function declinedStatus(Request $request)
        {
            $order_id = $request->id;

            Order::findOrFail($order_id)->update(['order_status' => 'Ditolak']);

            return back()->with('danger', 'Sales Order ditolak. Silakan cek halaman SO ditolak');
        }

        // Batalkan
        public function cancelledStatus(Request $request)
        {
            $order_id = $request->id;

            Order::findOrFail($order_id)->update(['order_status' => 'Dibatalkan']);

            return back()->with('danger', 'Sales Order dibatalkan. Silakan cek halaman SO dibatalkan');
        }

        // Pengiriman
        public function shippingStatus(Request $request)
        {
            $order = Order::findOrFail($request->id);
            $order->update(['shipping_status' => $request->shipping_status]);

            return back()->with('success', 'Status pengiriman ' . $order->invoice_no . ' berhasil diperbarui!');
        }
        
        // Selesai
        public function finishedStatus(Request $request)
        {
            $order = Order::findOrFail($request->id);
            $order->update(['order_status' => 'Selesai']);

            return back()->with('success', 'Status SO ' . $order->invoice_no . ' berhasil diperbarui menjadi Selesai!');
        }


    //

    // Root controller view all, proposed, approved, sent, delivered page
    // protected function getOrdersView($view, $statusFilter)
    public function index()
    {
        $row = (int) request('row', 10000);
        
        $user = auth()->user();
        $invoiceNo = request('invoice_no', null);  // Get 'invoice_no' parameter from request
        $salesFilter = request('employee_id', null); // Use employee_id for sales filter
        $statusFilter = request('order_status', null);

        $ordersQuery = Order::query();

        if ($user->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin'])) {
            if ($statusFilter) {
                $ordersQuery->where('order_status', 'like', $statusFilter);
            }
        } 
        elseif ($user->hasRole('Sales')) {
            if ($statusFilter) {
                $ordersQuery->where('order_status', 'like', $statusFilter);
            }
            $ordersQuery->whereHas('customer', function ($query) use ($user) {
                $query->where('employee_id', $user->employee_id);
            });
        } 
        else {
            abort(403, 'Unauthorized action.');
        }

        if ($invoiceNo) {
            $ordersQuery->where('invoice_no', 'like', "%$invoiceNo%");
        }

        if ($salesFilter) {
            $ordersQuery->whereHas('customer', function ($query) use ($salesFilter) {
                $query->where('employee_id', $salesFilter);
            });
        }
        
        $orders = $ordersQuery->sortable()->filter(request(['search']))->orderBy('id', 'desc')->paginate($row);

        $orderStatus = Order::select('order_status')->distinct()->pluck('order_status');

        // Retrieve distinct sales employees for dropdown
        $sales = Customer::select('employee_id')->distinct()->get();

        // return view("marketing.salesorder.partials.$view", [
        return view("marketing.salesorder.index", [
            'orders' => $orders,
            'sales' => $sales,
            'orderStatus' => $orderStatus,
        ]);
    }

        // // Tampilkan Semua Sales Order
        // public function all() 
        // {
        //     return $this->getOrdersView('all', null);
        // }

        // // Tampilkan Sales Order Diajukan
        // public function proposed()
        // {
        //     return $this->getOrdersView('proposed', '%Menunggu Persetujuan%');
        // }

        // // Tampilkan Sales Order disetujui
        // public function approved()
        // {
        //     return $this->getOrdersView('approved', '%Disetujui%');
        // }

        // /// Tampilkan Sales Order dalam Pengiriman
        // public function sent()
        // {
        //     return $this->getOrdersView('sent', '%Pengiriman ke-%');
        // }

        // // Tampilkan Sales Order Terkirim
        // public function delivered()
        // {
        //     return $this->getOrdersView('delivered', '%Terkirim%');
        // }

        // // Tampilkan Sales Order ditolak
        // public function declined()
        // {
        //     return $this->getOrdersView('declined', '%Ditolak%');
        // }

        // // Tampilkan Sales Order dibatalkan
        // public function cancelled()
        // {
        //     return $this->getOrdersView('cancelled', '%Dibatalkan%');
        // }

        //     // Tampilkan Semua Sales Order
        //     public function allCollection() 
        //     {
        //     //  return $this->getOrdersView('all', null);
        //         return view("finance.collection.all", [
        //         'orders' => $orders, // Send orders variable to view
        //         'sales' => $sales, // Pass sales employees for dropdown
        //     ]);
        //     }
    //

    // Order Detail
    public function orderDetails(Int $order_id) 
    {
        // Data SO
        $customer = Customer::all();
        $order = Order::where('id', $order_id)->first();
        $orderDetails = OrderDetails::with('product.category.productunit')->where('order_id', $order_id)
                        ->orderBy('id', 'asc')->get();
        
        // Data DO
        $deliveries = Delivery::where('order_id',  $order_id)
                        ->orderBy('id', 'desc')->get();
        $deliveryDetails = DeliveryDetails::with('product.category.productunit')
                        ->whereIn('delivery_id', $deliveries->pluck('id'))
                        ->orderBy('id', 'asc')->get();

        // Data Coll
        $collections = Collection::where('order_id', $order_id)
                        ->orderBy('id', 'asc')->get();

        // return view('marketing.salesorder.details', [
        //     'customer' => $customer,
        //     'order' => $order,
        //     'orderDetails' => $orderDetails,
        //     'deliveries' => $deliveries,
        //     'deliveryDetails' => $deliveryDetails,
        // ]);
        return view( 'marketing.salesorder.details', compact('customer','order','orderDetails','deliveries','deliveryDetails', 'collections'));
    }


    // SO Document
    public function invoiceDownload(Int $order_id)
    {
        $order = Order::where('id', $order_id)->first();
        $orderDetails = OrderDetails::with('product')->where('order_id', $order_id)
                        ->orderBy('product_id', 'asc')->get();

        // show data (only for debugging)
        return view('marketing.salesorder.invoice-order', [
            'order' => $order,
            'orderDetails' => $orderDetails,
        ]);
    }

     // Penyiapan Produk
     public function penyiapanProduk()
    {
        $row = (int) request('row', 1000);
        $invoiceNo = request('invoice_no', null); 
        $salesFilter = request('employee_id', null);

        $ordersQuery = Order::query();

        if ($invoiceNo) {
            $ordersQuery->where('invoice_no', 'like', "%$invoiceNo%");
        }

        if ($salesFilter) {
            $ordersQuery->whereHas('customer', function ($query) use ($salesFilter) {
                $query->where('employee_id', $salesFilter);
            });
        }

        $prepares = $ordersQuery->where('order_status', 'Disetujui')->sortable()->orderBy('id', 'desc')->paginate($row);
        $sales = Customer::select('employee_id')->distinct()->get();

        return view('warehouse.delivery.penyiapan-produk', [
            'prepares' => $prepares,
            'sales' => $sales,
        ]);
    }
 
     // Dokumen Penyiapan Produk
     public function printPenyiapan(Int $order_id)
     {
         $order = Order::where('id', $order_id)->first();
         $orderDetails = OrderDetails::with('product')
                         ->where('order_id', $order_id)
                         ->orderBy('id', 'asc')
                         ->get();
 
         // show data (only for debugging)
         return view('warehouse.delivery.print-penyiapan', [
             'order' => $order,
             'orderDetails' => $orderDetails,
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
            $sheet->getStyle("A2:A{$highestRow}")
                ->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

            // Format Currency (Rp)
            $currencyColumns = ['H', 'J', 'K', 'L', 'M']; // Kolom untuk Bruto, Diskon (Rp), dll.
            foreach ($currencyColumns as $col) {
                $sheet->getStyle("{$col}2:{$col}{$highestRow}")
                    ->getNumberFormat()
                    ->setFormatCode('"Rp" #,##0');
            }

            // Format Persentase (%)
            $sheet->getStyle("I2:I{$highestRow}")
                ->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_PERCENTAGE_00);

            // **Menjadikan data sebagai tabel di dalam Excel**
            $table = new Table("A1:{$highestColumn}{$highestRow}");
            $table->setName("SalesOrderTable");
            $table->setShowHeaderRow(true);
            $table->getAllowFilter(true); // Tambahkan filter otomatis
            
            // **Menambahkan banded row**
            $tableStyle = new TableStyle();
            $tableStyle->setTheme(TableStyle::TABLE_STYLE_MEDIUM2); // Tambahkan efek banded row
            $table->setStyle($tableStyle);

            $sheet->addTable($table);

            // Buat nama file dengan timestamp
            $filename = 'Sales Order_' . date('dmY_His') . '.xlsx';

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
        $orders = Order::all()->sortByDesc('order_id');

        $order_array[] = [
            'Tanggal Pemesanan', 'ID Sales Order', 'Nama Lembaga', 'Nama Customer',
            'Sales', 'Status SO', 'Metode Pembayaran', 'Bruto (Rp)', 'Diskon (%)',
            'Diskon (Rp)', 'Netto (Rp)', 'Telah Dibayar (Rp)', 'Sisa Tagihan (Rp)', 'Status Pembayaran'
        ];

        foreach ($orders as $order) {
            $order_array[] = [
                // \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(strtotime($order->order_date)), // Konversi ke format Excel
                \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(\Carbon\Carbon::parse($order->order_date)->startOfDay()),
                $order->invoice_no,
                $order->customer->NamaLembaga,
                $order->customer->NamaCustomer,
                $order->customer->employee->name,
                $order->order_status,
                $order->payment_method,
                $order->sub_total,
                (float) $order->discount_percent / 100, // Dibagi 100 agar format % sesuai
                $order->discount_rp,
                $order->grandtotal,
                $order->pay,
                $order->due,
                $order->payment_status,
            ];
        }

        $this->exportExcel($order_array);
    }

}
