<?php

namespace App\Http\Controllers\Finance\Cashflow;

use Exception;
use App\Models\Bank;
use App\Models\User;
use App\Models\Cashflow;

use App\Models\Rekening;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CashflowCategory;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Picqer\Barcode\BarcodeGeneratorHTML;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class CashflowController extends Controller
{
    public function index()
    {
        $cashflows = Cashflow::with(['createdBy', 'updatedBy', 'department', 'cashflowcategory', 'rekeningPerusahaan', 'employee'])
            ->filter(request(['search']))->sortable()->orderBy('date', 'desc')->get();

        $annualCashflows = $cashflows->groupBy(fn ($item) => $item->date->format('Y'))->sortKeysDesc()->map(fn ($items) => $items->sortBy('date'));

        $monthlyCashflows = $cashflows->groupBy(fn ($item) => $item->date->format('Y-m'))->sortKeysDesc()->map(fn ($items) => $items->sortBy('date'));

        return view('finance.cashflow.index', [
            'cashflows' => $cashflows,
            'annualCashflows' => $annualCashflows,
            'monthlyCashflows' => $monthlyCashflows,
            'departments' => Department::all(),
            'cashflowcategories' => CashflowCategory::all(),
            'createdBy' => User::all(),
            'updatedBy' => User::all(),
            'rekeningPerusahaans' => Rekening::all(),
            'banks' => Bank::all(),
            'employees' => Employee::all(),
            'title' => 'Arus Kas',
            'totalCashflow' => Cashflow::sum('nominal'),
        ]);
    }

    // Suggestion di Index
        // 'totalCashflowIn' => Cashflow::where('cashflowcategory_id', 1)->sum('nominal'),
        // 'totalCashflowOut' => Cashflow::where('cashflowcategory_id', 2)->sum('nominal'),
        // 'totalCashflowInCount' => Cashflow::where('cashflowcategory_id', 1)->count(),
        // 'totalCashflowOutCount' => Cashflow::where('cashflowcategory_id', 2)->count(),
        // 'totalCashflowCount' => Cashflow::count(),
        // 'totalCashflowInCount' => Cashflow::where('cashflowcategory_id', 1)->count(),
        // 'totalCashflowOutCount' => Cashflow::where('cashflowcategory_id', 2)->count(),
        // 'totalCashflowCount' => Cashflow::count(),
        // 'totalCashflowIn' => Cashflow::where('cashflowcategory_id', 1)->sum('nominal'),
        // 'totalCashflowOut' => Cashflow::where('cashflowcategory_id', 2)->sum('nominal'),
        // 'totalCashflowInCount' => Cashflow::where('cashflowcategory_id', 1)->count(),
        // 'totalCashflowOutCount' => Cashflow::where('cashflowcategory_id', 2)->count(),
        // 'totalCashflowCount' => Cashflow::count(),
        // 'totalCashflowIn' => Cashflow::where('cashflowcategory_id', 1)->sum('nominal'),
        // 'totalCashflowOut' => Cashflow::where('cashflowcategory_id', 2)->sum('nominal'),
        // 'totalCashflowInCount' => Cashflow::where('cashflowcategory_id', 1)->count(),
        // 'totalCashflowOutCount' => Cashflow::where('cashflowcategory_id', 2)->count(), 
        // 'totalCashflowCount' => Cashflow::count(),
        // 'totalCashflowIn' => Cashflow::where('cashflowcategory_id', 1)->sum('nominal'),
        // 'totalCashflowOut' => Cashflow::where('cashflowcategory_id', 2)->sum('nominal'),
    // 
    
    public function show(Cashflow $cashflow)
    {
        return view('finance.cashflow.show', [
            'cashflow' => $cashflow,
            'cashflowcategory' => Cashflowcategory::all(),
            'title' => 'Detail Arus Kas',
        ]);
    }

    // CRUD
        public function create()
        {
            return view('finance.cashflow.create', [
                'departments' => Department::all(),
                'cashflows' => Cashflow::all(),
                'rekenings' => Rekening::all(),
                'cashflowcategories' => CashflowCategory::all(),
            ]);
        }

        public function store(Request $request)
        {
            $user = auth()->user();

            $category = CashflowCategory::find($request->cashflowcategory_id);

            $prefix = ($category->type === 'Pemasukan') ? 'KM-' : 'KK-';

            $lastCashflow = Cashflow::where('cashflow_code', 'LIKE', "$prefix%")
                                    ->orderBy('cashflow_code', 'desc')->first();

            $nextNumber = $lastCashflow
                ? ((int) str_replace($prefix, '', $lastCashflow->cashflow_code)) + 1
                : 1;

            $cashflow_code = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $validatedData = $request->validate([
                'cashflowcategory_id' => 'required|integer',
                'department_id' => 'required|integer',
                'nominal' => 'required|integer',
                'notes' => 'required|string',
                'receipt' => 'image|file|max:2048|nullable',
                'date' => 'date_format:Y-m-d|required',
                'method' => 'string|required',
                'employee_id' => 'integer|nullable',
                'bank_id' => 'integer|nullable',
                'rekeningPartner' => 'string|nullable',
                'namaPartner' => 'string|nullable',
                'rekening_id' => 'string|nullable',
            ]);

            $validatedData['created_by'] = $user->id;
            $validatedData['cashflow_code'] = $cashflow_code;

            if ($file = $request->file('receipt')) {
                $fileName = Str::slug($cashflow_code) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/cashflow/', $fileName);
                $validatedData['receipt'] = 'storage/cashflow/' . $fileName;
            } else {
                $validatedData['receipt'] = 'storage/cashflow/default.jpg';
            }

            Cashflow::create($validatedData);

            return back()->with('success', 'Transaksi berhasil ditambahkan!');
        }

        public function edit(Cashflow $cashflow)
        {
            return view('finance.cashflow.edit', [
                'cashflow' => $cashflow,
                'departments' => Department::all(),
                'cashflows' => Cashflow::all(),
                'cashflowcategories' => Cashflowcategory::all(),
            ]);
        }

        public function update(Request $request, Cashflow $cashflow)
        {
            $user = auth()->user();

            $category = CashflowCategory::find($request->cashflowcategory_id);
            if (!$category) {
                return Redirect::back()->withErrors(['cashflowcategory_id' => 'Kategori tidak ditemukan']);
            }

            $validatedData = $request->validate([
                'cashflowcategory_id' => 'required|integer',
                'department_id' => 'required|integer',
                'nominal' => 'required|integer',
                'notes' => 'required|string',
                'receipt' => 'image|file|max:2048|nullable',
                'date' => 'date_format:Y-m-d|required',
                'method' => 'string|required',
                'employee_id' => 'integer|nullable',
                'bank_id' => 'integer|nullable',
                'rekeningPartner' => 'string|nullable',
                'namaPartner' => 'string|nullable',
                'rekening_id' => 'string|nullable',
            ]);

            // ✅ Kosongkan field yang tidak relevan sesuai dengan method
                if ($validatedData['method'] === 'Tunai') {
                    // Kosongkan semua field Transfer
                    $validatedData['bank_id'] = null;
                    $validatedData['rekeningPartner'] = null;
                    $validatedData['namaPartner'] = null;
                    $validatedData['rekening_id'] = null;
                } elseif ($validatedData['method'] === 'Transfer') {
                    // Kosongkan field Tunai
                    $validatedData['employee_id'] = null;
                }

            $validatedData['updated_by'] = $user->id;

            if ($file = $request->file('receipt')) {
                $fileName = Str::slug($cashflow->cashflow_code) . '-' . time() . '.' . $file->getClientOriginalExtension();

                // Hapus file lama jika bukan default
                if ($cashflow->receipt && $cashflow->receipt != 'storage/cashflow/default.jpg') {
                    Storage::delete(str_replace('storage/', 'public/', $cashflow->receipt));
                }

                $file->storeAs('public/cashflow/', $fileName);
                $validatedData['receipt'] = 'storage/cashflow/' . $fileName;
            } else {
                $validatedData['receipt'] = $cashflow->receipt;
            }

            $cashflow->update($validatedData);

            return back()->with('success', 'Data Arus Kas berhasil diperbarui!');
        }


        public function destroy(Cashflow $cashflow)
        {
            if($cashflow->receipt){
                Storage::delete('public/cashflow/' . $cashflow->receipt);
            }

            Cashflow::destroy($cashflow->id);

            return Redirect::route('cashflow.index')->with('success', 'Product has been deleted!');
        }
    // 

    // public function importView()
    // {
    //     return view('cashflow.import');
    // }

    // public function importStore(Request $request)
    // {
    //     $request->validate([
    //         'upload_file' => 'required|file|mimes:xls,xlsx',
    //     ]);

    //     $the_file = $request->file('upload_file');

    //     try{
    //         $spreadsheet = IOFactory::load($the_file->getRealPath());
    //         $sheet        = $spreadsheet->getActiveSheet();
    //         $row_limit    = $sheet->getHighestDataRow();
    //         $column_limit = $sheet->getHighestDataColumn();
    //         $row_range    = range( 2, $row_limit );
    //         $column_range = range( 'J', $column_limit );
    //         $startcount = 2;
    //         $data = array();
    //         foreach ( $row_range as $row ) {
    //             $data[] = [
    //                 'product_name' => $sheet->getCell( 'A' . $row )->getValue(),
    //                 'category_id' => $sheet->getCell( 'B' . $row )->getValue(),
    //                 'supplier_id' => $sheet->getCell( 'C' . $row )->getValue(),
    //                 'productcashflow_code' => $sheet->getCell( 'D' . $row )->getValue(),
    //                 'product_garage' => $sheet->getCell( 'E' . $row )->getValue(),
    //                 'product_image' => $sheet->getCell( 'F' . $row )->getValue(),
    //                 'product_store' =>$sheet->getCell( 'G' . $row )->getValue(),
    //                 'buying_date' =>$sheet->getCell( 'H' . $row )->getValue(),
    //                 'expire_date' =>$sheet->getCell( 'I' . $row )->getValue(),
    //                 'buying_price' =>$sheet->getCell( 'J' . $row )->getValue(),
    //                 'selling_price' =>$sheet->getCell( 'K' . $row )->getValue(),
    //             ];
    //             $startcount++;
    //         }

    //         Product::insert($data);

    //     } catch (Exception $e) {
    //         // $errorcashflow_code = $e->errorInfo[1];
    //         return Redirect::route('cashflow.index')->with('error', 'There was a problem uploading the data!');
    //     }
    //     return Redirect::route('cashflow.index')->with('success', 'Data has been successfully imported!');
    // }

    // public function exportExcel($cashout){
    //     ini_set('max_execution_time', 0);
    //     ini_set('memory_limit', '4000M');

    //     try {
    //         $spreadSheet = new Spreadsheet();
    //         $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
    //         $spreadSheet->getActiveSheet()->fromArray($cashout);
    //         $Excel_writer = new Xls($spreadSheet);
    //         header('Content-Type: application/vnd.ms-excel');
    //         header('Content-Disposition: attachment;filename="Pengeluaran [Exported Data].xls"');
    //         header('Cache-Control: max-age=0');
    //         ob_end_clean();
    //         $Excel_writer->save('php://output');
    //         exit();
    //     } catch (Exception $e) {
    //         return;
    //     }
    // }

    // function exportData(){
    //     $cashout = CashOut::all()->sortByDesc('cashout_id');

    //     $cashout_array [] = array(
    //         'Tanggal',
    //         'Kode',
    //         'Kategori',
    //         'Detail',
    //         'Nominal',
    //         'Catatan',

    //     );

    //     foreach($cashout as $product)
    //     {
    //         $cashout_array[] = array(
    //             'Tanggal' => $product->product_name,
    //             'Kode' => $product->category->name,
    //             'Kategori' => $product->supplier_id,
    //             'Detail' => $product->productcashflow_code,
    //             'Nominal' => $product->product_garage,
    //             'Catatan' => $product->product_image,

    //         );
    //     }

    //     $this->ExportExcel($cashout_array);
    // }
}
