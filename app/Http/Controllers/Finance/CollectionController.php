<?php

namespace App\Http\Controllers\Finance;

use App\Models\Bank;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\Employee;
use App\Models\Rekening;
use App\Models\Collection;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle;


class CollectionController extends Controller
{
    public function input()
    {
        $row = (int) request('row', 20);
        $salesorders = request('order_id', null);
        $subtotal = request('subtotal', null);

        $ordersQuery = Order::query()->where('order_status', 'Disetujui')
                        ->whereIn('payment_status', ['Belum Lunas', 'Belum dibayar']);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        if ($subtotal)  {
            $ordersQuery->where('sub_total', $subtotal);
        }

        return view('finance.collection.input', [
            'salesorders' => $ordersQuery->get(),
            'employees' => Employee::get(),
            'banks' => Bank::get(),
            'rekenings' => Rekening::get(),
        ]);
    }

    public function inputColConfirmation(Request $request)
    {
        $rules = [
            'order_id' => 'integer|required',
            'paid_by' => 'string|required',
            'payment_method' => 'string|required',
            'received_by' => 'integer|required_if:payment_method,Tunai',
            'bank' => 'integer|required_if:payment_method,Transfer',
            'no_rek' => 'string|nullable',
            'transfer_to' => 'integer|nullable',
            'pay' => 'numeric|required',
            'discount_percent' => 'numeric|nullable',
            'discount_rp' => 'numeric|nullable',
            'PPh22_percent' => 'numeric|nullable',
            'PPh22_rp' => 'numeric|nullable',
            'PPN_percent' => 'numeric|nullable',
            'PPN_rp' => 'numeric|nullable',
            'admin_fee' => 'integer|nullable',
            'other_fee' => 'integer|nullable',
            'grandtotal' => 'numeric|required',
            'due' => 'numeric|required',
            'payment_status' => 'string|required',
            'payment_date' => 'date_format:Y-m-d|max:10',
        ];
    
        $validatedData = $request->validate($rules);
        $salesorder = Order::findOrFail($validatedData['order_id']);
        $received_by = $validatedData['payment_method'] === 'Tunai' ? Employee::findOrFail($validatedData['received_by']) : null;
        $bank = $validatedData['payment_method'] === 'Transfer' ? Bank::findOrFail($validatedData['bank']) : null;
        $transfer_to = $validatedData['payment_method'] === 'Transfer' ? Rekening::findOrFail($validatedData['transfer_to']) : null;
        $validatedData['collection_date'] = $request->input('collection_date');
    
        return view('finance.collection.confirmation', [
            'salesorder' => $salesorder,
            'pay' => $validatedData['pay'],
            'paid_by' => $validatedData['paid_by'],
            'received_by' => $received_by,
            'bank' => $bank,
            'no_rek' => $validatedData['no_rek'],
            'transfer_to' => $transfer_to,
            'payment_method' => $validatedData['payment_method'],
            'discount_percent' => $validatedData['discount_percent'],
            'discount_rp' => $validatedData['discount_rp'],
            'PPh22_percent' => $validatedData['PPh22_percent'],
            'PPh22_rp' => $validatedData['PPh22_rp'],
            'PPN_percent' => $validatedData['PPN_percent'],
            'PPN_rp' => $validatedData['PPN_rp'],
            'admin_fee' => $validatedData['admin_fee'],
            'other_fee' => $validatedData['other_fee'],
            'grandtotal' => $validatedData['grandtotal'],
            'due' => $validatedData['due'],
            'payment_status' => $validatedData['payment_status'],
        ]);
    }

    private function storeCollection(Request $request, $suffix)
    {
        // Validate input (expand rules as necessary)
        $rules = [
            'order_id' => 'required|integer',
            'paid_by' => 'required|string',
            'pay' => 'required|integer',
            'payment_method' => 'required|string',
            'employee_id' => 'integer|nullable',
            'bank_id' => 'integer|nullable',
            'no_rek' => 'string|nullable',
            'rekening_id' => 'integer|nullable',
            'discount_percent' => 'numeric|nullable',
            'discount_rp' => 'numeric|nullable',
            'PPh22_percent' => 'numeric|nullable',
            'PPh22_rp' => 'numeric|nullable',
            'PPN_percent' => 'numeric|nullable',
            'PPN_rp' => 'numeric|nullable',
            'admin_fee' => 'integer|nullable',
            'other_fee' => 'integer|nullable',
            // 'grandtotal' => 'integer|required',
            'grandtotal' => 'numeric|required',
            'due' => 'numeric|required',
            'payment_status' => 'string|required',
            'payment_date' => 'date_format:Y-m-d|max:10',
        ];
        $validatedData = $request->validate($rules);

        // Ambil invoice terakhir tanpa mempertimbangkan suffix (RO, HO, RS, HS)
        $lastOrder = Order::where('invoice_no', 'like', 'Co-%-%')->orderByDesc('id')->first();

        // Ambil angka terakhir dari invoice terakhir
        if ($lastOrder) {
            preg_match('/Co-(\d+)-/', $lastOrder->invoice_no, $matches);
            $lastNumber = isset($matches[1]) ? (int) $matches[1] : 0;
        } else {
            $lastNumber = 0;
        }

        // Buat angka baru dengan format 4 digit
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $invoice_no = "Co-$newNumber-$suffix";

        // Prepare delivery data
        $validatedData['payment_date'] = Carbon::now()->format('Y-m-d');
        $validatedData['invoice_no'] = $invoice_no;
        $validatedData['created_at'] = Carbon::now();

        Collection::create($validatedData);

        // Sent to Order table
            $salesorder = Order::findOrFail($request->order_id);

                $newPay = (($salesorder->pay ?? 0) + $request->pay);
                $newDue = max($salesorder->due - $request->pay, 0);
                $paymentStatus = $request->payment_status;

            $salesorder->update([
                'pay' => $newPay,
                'due' => $newDue,
                'payment_status' => $paymentStatus,
            ]);

        return Redirect::route('collection.index')->with('created', 'Collection berhasil dibuat!');
    }

        // Store
            public function storeColReguler(Request $request)
            {
                return $this->storeCollection($request, 'RO');
            }

            public function storeColHET(Request $request)
            {
                return $this->storeCollection($request, 'HO');
            }

            public function storeColROnline(Request $request)
            {
                return $this->storeCollection($request, 'RS');
            }

            public function storeColHOnline(Request $request)
            {
                return $this->storeCollection($request, 'HS');
            }

    //

    public function index()
    {
        $row = (int) request('row', 10000);

        $user = auth()->user();
        $collectionInvoiceNo = request('collection_invoice_no', null);
        $orderInvoiceNo = request('order_invoice_no', null);
        $salesFilter = request('employee_id', null);
        $statusFilter = request('delivery_status', null);

        $ordersQuery = Order::whereIn('order_status', ['Disetujui', 'Selesai'])->with('collections');
        $query = Collection::query();

        if (!empty($statusFilter)) {
            $query->where('payment_status', 'like', "%$statusFilter%");
            $ordersQuery->where('payment_status', 'like', "%$statusFilter%");
        }

        if ($user->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin'])) {
            $collections = $query;
            $orders = $ordersQuery;
        } elseif ($user->hasRole('Sales')) {
            $collections = $query->whereHas('salesorder.customer', function ($query) use ($user) {
                $query->where('employee_id', $user->employee_id);
            });
            $orders = $ordersQuery->whereHas('customer', function ($ordersQuery) use ($user) {
                $ordersQuery->where('employee_id', $user->employee_id);
            });
        } else {
            abort(403, 'Unauthorized action.');
        }

        $collections = $collections->when($collectionInvoiceNo, function ($query, $collectionInvoiceNo) {
            return $query->where('invoice_no', 'like', "%$collectionInvoiceNo%");
        });

        $collections = $collections->when($orderInvoiceNo, function ($query, $orderInvoiceNo) {
            return $query->whereHas('salesorder', function ($query) use ($orderInvoiceNo) {
                $query->where('invoice_no', 'like', "%$orderInvoiceNo%");
            });
        });

        $orders = $orders->when($collectionInvoiceNo, function ($ordersQuery, $collectionInvoiceNo) {
            return $ordersQuery->where('invoice_no', 'like', "%$collectionInvoiceNo%");
        });

        if ($salesFilter) {
            $collections = $query->whereHas('salesorder.customer', function ($query) use ($salesFilter) {
                $query->where('employee_id', $salesFilter);
            });
        }

        $collections = $collections->sortable()->filter(request(['search']))->orderBy('id', 'desc')->paginate($row);

        $orders = $orders->sortable()->filter(request(['search']))->orderBy('id', 'desc')->paginate($row);

        $sales = Customer::select('employee_id')->distinct()->get();

        return view("finance.collection.index", [
            'orders' => $orders,
            'collections' => $collections, // Send orders variable to view
            'sales' => $sales, // Pass sales employees for dropdown
        ]);
    }
      
    public function collectionDetails(Int $collection_id)
    {
        $collection = Collection::where('id', $collection_id)->first();

        return view('finance.collection.details',
            compact('collection')
        );
    }

    public function invoiceDownload(Int $collection_id)
    {
        $salesorder = Order::where('id', ['order_id'])->first();
        $collections = Collection::where('id', $collection_id)->first();

        return view('finance.collection.invoice-collection',
            compact('salesorder', 'collection')
        );
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
            $currencyColumns = ['O', 'Q', 'R', 'S', 'U', 'W', 'Y', 'Z', 'AA', 'AB', 'AC']; // Kolom untuk Bruto, Diskon (Rp), dll.
            foreach ($currencyColumns as $col) {
                $sheet->getStyle("{$col}2:{$col}{$highestRow}")
                    ->getNumberFormat()
                    ->setFormatCode('"Rp" #,##0');
            }

            // Format Persentase (%)
            $percentColumns = ['P', 'T', 'V', 'X'];
            foreach ($percentColumns as $col) {
                $sheet->getStyle("{$col}2:{$col}{$highestRow}")
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_PERCENTAGE_00);
            }

            // **Menjadikan data sebagai tabel di dalam Excel**
            $table = new Table("A1:{$highestColumn}{$highestRow}");
            $table->setName("CollectionTable");
            $table->setShowHeaderRow(true);
            $table->getAllowFilter(true); // Tambahkan filter otomatis
            
            // **Menambahkan banded row**
            $tableStyle = new TableStyle();
            $tableStyle->setTheme(TableStyle::TABLE_STYLE_MEDIUM2); // Tambahkan efek banded row
            $table->setStyle($tableStyle);

            $sheet->addTable($table);

            // Buat nama file dengan timestamp
            $filename = 'Collection_' . date('dmY_His') . '.xlsx';

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
        $collections = Collection::all()->sortByDesc('collection_id');

        $order_array[] = [
            'Tgl Collection',
            'ID Collection',
            'Tgl Pemesanan',
            'ID Sales Order',
            'Nama Lembaga',
            'Nama Customer',
            'Sales',
            'Metode Pembayaran',
            'Dibayar oleh',
            'Bank Pengirim',
            'Rekening Pengirim',
            'Diterima oleh',
            'Bank Penerima',
            'Rekening Penerima',
            'Bruto (Rp)',
            'Diskon SO (%)',
            'Diskon SO (Rp)',
            'Netto (Rp)',
            'Bruto Dibayarkan (Rp)',
            'Diskon (%)',
            'Diskon (Rp)',
            'PPh 22 (%)',
            'PPh 22 (Rp)',
            'PPN (%)',
            'PPN (Rp)',
            'Biaya Admin (Rp)',
            'Biaya Lainya (Rp)',
            'Netto Dibayarkan (Rp)',
            'Tagihan (Rp)',
            'Status Pembayaran',
        ];

        foreach ($collections as $collection) {
            $order_array[] = [
                \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(\Carbon\Carbon::parse($collection->collection_date)->startOfDay()),
                $collection->invoice_no,
                \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(\Carbon\Carbon::parse($collection->salesorder?->order_date)->startOfDay()),
                $collection->salesorder?->invoice_no ?? '-',
                $collection->salesorder?->customer?->NamaLembaga ?? '-',
                $collection->salesorder?->customer?->NamaCustomer ?? '-',
                $collection->salesorder?->customer?->employee?->name ?? '-',
                $collection->payment_method ?? '-',
                $collection->paid_by ?? '-',
                $collection->bank?->name ?? '-',
                $collection->no_rek ?? '-',
                $collection->employee?->name ?? '-',
                $collection->bank?->name ?? '-',
                $collection->rekening?->no_rek ?? '-',
                $collection->salesorder?->sub_total ?? 0,
                $collection->salesorder?->discount_percent ?? 0,
                $collection->salesorder?->discount_rp ?? 0,
                $collection->salesorder?->grandtotal ?? 0,
                $collection->pay ?? 0,
                $collection->discount_percent ?? 0,
                $collection->discount_rp ?? 0,
                $collection->PPh22_percent ?? 0,
                $collection->PPh22_rp ?? 0,
                $collection->PPN_percent ?? 0,
                $collection->PPN_rp ?? 0,
                $collection->admin_fee ?? 0,
                $collection->other_fee ?? 0,
                $collection->grandtotal ?? 0,
                $collection->due ?? 0,
                $collection->salesorder->payment_status ?? '-',
            ];
        }

        $this->exportExcel($order_array);
    }

}
