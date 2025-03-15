<?php

namespace App\Http\Controllers\Warehouse;

use App\Models\Stock;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\StockDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ProductCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class StockController extends Controller
{
    public function input()
    {
        $row = (int) request('row', 20);
        $categoryFilter = request('category_id', null);
        $jenjang = request('jenjang', null);
        $kelas = request('kelas', null);
        $mapel = request('mapel', null);

        $productsQuery = Product::query();
        $categories = Product::select('category_id')->distinct()->get();

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
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

        return view('warehouse.stock.input', [
            'suppliers' => Supplier::all()->sortBy('name'),
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

            return back()->with('success', 'Product has been added!');
        }

        public function updateCart(Request $request, $rowId)
        {
            $rules = [
                'qty' => 'required|numeric',
            ];

            $validatedData = $request->validate($rules);

            Cart::update($rowId, $validatedData['qty']);
            
            return back()->with('success', 'Cart has been updated!');
        }
        
        public function deleteCart(String $rowId)
        {
            Cart::remove($rowId);

            return back()->with('success', 'Cart has been deleted!');
        }
    //

    public function confirmation(Request $request)
    {
        $rules = [
            'supplier_id' => 'required'
        ];

        $validatedData = $request->validate($rules);
        $supplier = Supplier::where('id', $validatedData['supplier_id'])->first();
        $content = Cart::content();

        return view('warehouse.stock.confirmation', [
            'supplier' => $supplier,
            'content' => $content
        ]);
    }

    // sent to DB
    public function storeStock(Request $request)
    {
        $rules = [
            'supplier_id' => 'required|numeric',
        ];

        $invoice_no = IdGenerator::generate([
            'table' => 'stocks',
            'field' => 'invoice_no',
            'length' => 7,
            'prefix' => 'SM-'
        ]);

        $validatedData = $request->validate($rules);
        $validatedData['stock_date'] = Carbon::now()->format('Y-m-d');
        $validatedData['total_products'] = Cart::count();
        $validatedData['sub_total'] = Cart::subtotal();
        $validatedData['invoice_no'] = $invoice_no;
        $validatedData['created_at'] = Carbon::now();

        $stock_id = Stock::insertGetId($validatedData);

        // Create Stock Details
        $contents = Cart::content();
        $stockDetails = array();

        foreach ($contents as $content) {
            $stockDetails['stock_id'] = $stock_id;
            $stockDetails['product_id'] = $content->id;
            $stockDetails['quantity'] = $content->qty;
            $stockDetails['unitcost'] = $content->price;
            $stockDetails['total'] = $content->total;
            $stockDetails['created_at'] = Carbon::now();

            StockDetails::insert($stockDetails);
        }

        
        // Add stock to product stock table
        $products = StockDetails::where('stock_id', $stock_id)->get();
        
        foreach ($products as $product) {
            Product::where('id', $product->product_id)
                    ->update(['product_store' => DB::raw('product_store+'.$product->quantity)]);
            Product::where('id', $product->product_id)
                    ->update([
                // Hitung stock_needed sebagai selisih antara product_store dan product_ordered
                'stock_needed' => DB::raw('GREATEST(product_ordered - product_store, 0)')]);
        }

        // Delete Cart Sopping History
        Cart::destroy();

        // return Redirect::route('warehouse.stock.allStock')->with('success', 'Stock has been created!');
        return Redirect::route('input.stock')->with('success', 'Stock has been created!');
    }

    // Detail Stock entry
    public function stockDetails(Int $stock_id)
    {
        $stocks = Stock::where('id', $stock_id)->first();
        $stockDetails = StockDetails::with('product')
                        ->where('stock_id', $stock_id)
                        ->orderBy('id', 'ASC')
                        ->get();

        return view('warehouse.stock.details-stock', [
            'stocks' => $stocks,
            'stockDetails' => $stockDetails,
        ]);
    }

    
    /**
     * Display a listing of the resource.
     */
    public function all() 
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        $stocks = Stock::query()->sortable()->orderBy('id', 'desc')->paginate($row);
        
        return view('warehouse.stock.all', [
            'stocks' => $stocks
        ]);
    }

    // public function stockManage()
    // {
    //     $row = (int) request('row', 1000);
    //     $categoryFilter = request('category_id', null);
    //     $jenjang = request('jenjang', null);
    //     $kelas = request('kelas', null);
    //     $mapel = request('mapel', null);

    //     $query = Product::query()->orderBy('id', 'asc');
        
    //     if ($categoryFilter) {
    //             $query->where('category_id', $categoryFilter);
    //         };

    //     if ($jenjang) {
    //         $query->where('product_name', 'like', "%$jenjang%");
    //     }

    //     if ($kelas) {
    //         $query->where('product_name', 'like', "%$kelas%");
    //     }
        
    //     if ($mapel) {
    //         $query->where('product_name', 'like', "%$mapel%");
    //     }

    //     $categories = Product::select('category_id')->distinct()->get();

    //     return view('warehouse.stock.index', [
    //         'products' => $query->filter(request(['search']))->sortable()
    //                         ->paginate($row)->appends(request()->query()),
    //         'categories' => $categories,
    //     ]);
    // }

    public function invoiceDownload(Int $stock_id)
    {
        $stocks = Stock::where('id', $stock_id)->first();
        $stockDetails = StockDetails::with('product')
                        ->where('stock_id', $stock_id)
                        ->orderby('id', 'asc')
                        ->get();

        // show data (only for debugging)
        return view('warehouse.stock.invoice-stock', [
            'stocks' => $stocks,
            'stockDetails' => $stockDetails,
        ]);
    }

    public function exportExcel($products)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');

        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($products);
            $Excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Products_ExportedData.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }

    function exportData()
    {
        $products = Product::all()->sortByDesc('product_id');

        $product_array [] = array(
            'Nama Produk',
            'Kategori',
            'Kode Produk',
            'Foto Produk',
            'Stok',
            'Harga Beli',
            'Harga Jual',
        );

        foreach($products as $product)
        {
            $product_array[] = array(
                'Nama Produk' => $product->product_name,
                'Kategori' => $product->category->name,
                'Kode Produk' => $product->product_code,
                'Foto Produk' => $product->product_image,
                'Stok' =>$product->product_store,
                'Harga Beli' =>$product->buying_price,
                'Harga Jual' =>$product->selling_price,
            );
        }

        $this->ExportExcel($product_array);
    }
    
}
