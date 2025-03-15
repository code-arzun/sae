<?php

namespace App\Http\Controllers\Cashflow;

use Exception;
use App\Models\CashflowIncome;
use App\Models\CashflowType;
use Illuminate\Http\Request;
use App\Models\CashflowDetail;

use App\Models\CashflowCategory;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Picqer\Barcode\BarcodeGeneratorHTML;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class CashflowIncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        return view('cashflow.income.index', [
            'cashflowincomes' => CashflowIncome::with(['user', 'department', 'cashflowdetail'])
                ->filter(request(['search']))
                ->sortable()
                ->orderBy('date', 'desc')
                ->paginate($row)
                ->appends(request()->query()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cashflow.income.create', [
            'departments' => Department::all(),
            'cashflowtypes' => CashflowType::all(),
            // 'cashflowdetails' => CashflowDetail::all(),
            'cashflowdetails' => CashflowDetail::with('cashflowcategory.cashflowtype')->whereHas('cashflowcategory.cashflowtype', function ($query) {
                $query->where('name', 'Pemasukan');})->get(),
            // 'cashflowdetails' => CashflowDetail::with('cashflowcategory')->whereHas('cashflowcategory', function ($query) {
            // $query->where('cashflowtype_id', 2);})->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $income_code = IdGenerator::generate([
            'table' => 'cashflowincomes',
            'field' => 'income_code',
            'length' => 7,
            'prefix' => 'KK-'
        ]);

        $rules = [
            'user_id' => 'required|integer',
            'department_id' => 'required|integer',
            'cashflowdetail_id' => 'required|integer',
            'receipt' => 'image|file|max:1024',
            // 'date' => 'date_format:d-m-Y|max:10|nullable',
            'date' => 'date_format:Y-m-d|max:10|nullable',
            'nominal' => 'required|integer',
            'notes' => 'nullable|string',
        ];

        $validatedData = $request->validate($rules);

        // save product code value
        $validatedData['income_code'] = $income_code;

        /**
         * Handle upload image with Storage.
         */
        if ($file = $request->file('receipt')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/cashflowincome/';

            $file->storeAs($path, $fileName);
            $validatedData['receipt'] = $fileName;
        }

        CashflowIncome::create($validatedData);

        return Redirect::route('cashflowincome.index')->with('success', 'Cashflowincome has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CashflowIncome $cashflowincome)
    {
        // Barcode Generator
        // $generator = new BarcodeGeneratorHTML();

        // $barcode = $generator->getBarcode($cashflowincomes->incomes_code, $generator::TYPE_CODE_128);

        return view('cashflow.income.show', [
            'cashflowincome' => $cashflowincome,
            'cashflowincomes' => CashflowIncome::all(),
            // 'cashflowcategories' => CashflowIncome::all(),
            'cashflowdetail' => CashflowDetail::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CashflowIncome $cashflowincome)
    {
        return view('cashflow.income.edit', [
            'cashflowincome' => $cashflowincome,
            'departments' => Department::all(),
            'cashflowincomes' => CashflowIncome::all(),
            // 'cashflowcategories' => CashflowIncome::all(),
            'cashflowdetails' => CashflowDetail::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cashflowincome $cashflowincome)
    {
        $rules = [
            'user_id' => 'required|integer',
            'department_id' => 'required|integer',
            'cashflowdetail_id' => 'required|integer',
            'receipt' => 'image|file|max:1024',
            'date' => 'date_format:d-m-Y|max:10|nullable',
            'nominal' => 'required|integer',
            'notes' => 'nullable|string',
        ];

        $validatedData = $request->validate($rules);

        /**
         * Handle upload image with Storage.
         */
        if ($file = $request->file('receipt')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            // $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/cashflowincome/';

            /**
             * Delete photo if exists.
             */
            if($cashflowincome->receipt){
                Storage::delete($path . $cashflowincome->receipt);
            }

            $file->storeAs($path, $fileName);
            $validatedData['receipt'] = $fileName;
        }

        CashflowIncome::where('id', $cashflowincome->id)->update($validatedData);

        return Redirect::route('cashflowincome.index')->with('success', 'Cashflowincome has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cashflowincome $cashflowincome)
    {
        /**
         * Delete photo if exists.
         */
        if($cashflowincome->receipt){
            Storage::delete('public/cashflowincome/' . $cashflowincome->receipt);
        }

        CashflowIncome::destroy($cashflowincome->id);

        return Redirect::route('cashflowincome.index')->with('success', 'Product has been deleted!');
    }

    /**
     * Show the form for importing a new resource.
     */
    // public function importView()
    // {
    //     return view('cashflowincome.import');
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
    //                 'product_code' => $sheet->getCell( 'D' . $row )->getValue(),
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
    //         // $error_code = $e->errorInfo[1];
    //         return Redirect::route('cashflowincome.index')->with('error', 'There was a problem uploading the data!');
    //     }
    //     return Redirect::route('cashflowincome.index')->with('success', 'Data has been successfully imported!');
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

    /**
     *This function loads the customer data from the database then converts it
     * into an Array that will be exported to Excel
     */
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
    //             'Detail' => $product->product_code,
    //             'Nominal' => $product->product_garage,
    //             'Catatan' => $product->product_image,

    //         );
    //     }

    //     $this->ExportExcel($cashout_array);
    // }
}
