<?php

namespace App\Http\Controllers\Cashflow;

use Exception;
use App\Models\CashflowExpense;
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

class CashflowExpenseController extends Controller
{
    public function index()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        return view('cashflow.expense.index', [
            'cashflowexpenses' => CashflowExpense::with(['user', 'department', 'cashflowdetail'])->filter(request(['search']))
                ->sortable()->orderBy('date', 'desc')
                ->paginate($row)->appends(request()->query()),
        ]);
    }

    public function create()
    {
        return view('cashflow.expense.create', [
            'departments' => Department::all(),
            'cashflowtypes' => CashflowType::all(),
            // 'cashflowdetails' => CashflowDetail::all(),
            'cashflowdetails' => CashflowDetail::with('cashflowcategory')->whereHas('cashflowcategory', function ($query) {
                $query->where('cashflowtype_id', 2);})->get(),
        ]);
    }

    public function store(Request $request)
    {
        $expense_code = IdGenerator::generate([
            'table' => 'cashflowexpenses',
            'field' => 'expense_code',
            'length' => 7,
            'prefix' => 'KK-'
        ]);

        $rules = [
            'user_id' => 'required|integer',
            'department_id' => 'required|integer',
            'cashflowdetail_id' => 'required|integer',
            'receipt' => 'image|file|max:1024',
            // 'date' => 'date_format:d-m-Y|max:10|nullable',
            'date' => 'date_format:Y-m-d|max:10|required',
            'nominal' => 'required|integer',
            'notes' => 'nullable|string',
        ];

        $validatedData = $request->validate($rules);

        // save product code value
        $validatedData['expense_code'] = $expense_code;

        if ($file = $request->file('receipt')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/cashflowexpense/';

            $file->storeAs($path, $fileName);
            $validatedData['receipt'] = $fileName;
        }

        CashflowExpense::create($validatedData);

        return Redirect::route('expense.index')->with('success', 'Cashflowexpense has been created!');
    }

    public function show(CashflowExpense $cashflowexpense)
    {
        return view('cashflow.expense.show', [
            'cashflowexpense' => $cashflowexpense,
            'cashflowexpenses' => CashflowExpense::all(),
            'cashflowdetail' => CashflowDetail::all(),
        ]);
    }

    public function edit(CashflowExpense $cashflowexpense)
    {
        return view('cashflow.expense.edit', [
            'cashflowexpense' => $cashflowexpense,
            'departments' => Department::all(),
            'cashflowexpenses' => CashflowExpense::all(),
            'cashflowdetails' => CashflowDetail::all(),
        ]);
    }

    public function update(Request $request, Cashflowexpense $cashflowexpense)
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

        if ($file = $request->file('receipt')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            // $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/cashflowexpense/';

            if($cashflowexpense->receipt){
                Storage::delete($path . $cashflowexpense->receipt);
            }

            $file->storeAs($path, $fileName);
            $validatedData['receipt'] = $fileName;
        }

        CashflowExpense::where('id', $cashflowexpense->id)->update($validatedData);

        return Redirect::route('cashflowexpense.index')->with('success', 'Cashflowexpense has been updated!');
    }

    public function destroy(Cashflowexpense $cashflowexpense)
    {
        if($cashflowexpense->receipt){
            Storage::delete('public/cashflowexpense/' . $cashflowexpense->receipt);
        }

        CashflowExpense::destroy($cashflowexpense->id);

        return Redirect::route('cashflowexpense.index')->with('success', 'Product has been deleted!');
    }

    // public function importView()
    // {
    //     return view('cashflowexpense.import');
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
    //         return Redirect::route('cashflowexpense.index')->with('error', 'There was a problem uploading the data!');
    //     }
    //     return Redirect::route('cashflowexpense.index')->with('success', 'Data has been successfully imported!');
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
    //             'Detail' => $product->product_code,
    //             'Nominal' => $product->product_garage,
    //             'Catatan' => $product->product_image,

    //         );
    //     }

    //     $this->ExportExcel($cashout_array);
    // }
}
