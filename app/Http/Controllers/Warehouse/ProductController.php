<?php

namespace App\Http\Controllers\Warehouse;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Models\Publisher;
use App\Models\Writer;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

use Illuminate\Support\Facades\Redirect;
use Picqer\Barcode\BarcodeGeneratorHTML;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ProductController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $row = (int) request('row', 1000);
        $categoryFilter = request('category_id', null);
        $publisherFilter = request('publisher_id', null);
        $writerFilter = request('writer_id', null);
        $jenjang = request('jenjang', null);
        $kelas = request('kelas', null);
        $mapel = request('mapel', null);
        
        $user = auth()->user();
        $query = Product::query()->orderBy('id', 'desc')->with('category', 'publisher', 'writer');

        if ($user->hasAnyRole(['Manajer Publishing', 'Admin Publishing', 'Staf Publishing'])) {
            $query->where('publisher_id', '1');
        } elseif ($user->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Sales'])) {
        } else {
            abort(403, 'Anda tidak memiliki izin untuk mengakses data ini.');
        }
        
        if ($categoryFilter)  {
            $query->where('category_id', $categoryFilter);
        }

        if ($publisherFilter)  {
            $query->where('publisher_id', $publisherFilter);
        }

        if ($writerFilter)  {
            $query->where('writer_id', $writerFilter);
        }

        if ($jenjang) {
            $query->where('product_name', 'like', "%$jenjang%");
        }

        if ($kelas) {
            $query->where('product_name', 'like', "%$kelas%");
        }
        
        if ($mapel) {
            $query->where('product_name', 'like', "%$mapel%");
        }

        $categories = Product::select('category_id')->distinct()->get();
        $publishers = Product::select('publisher_id')->distinct()->get();
        $writers = Product::select('writer_id')->distinct()->get();

        return view('warehouse.products.index', [
            'products' => $query->filter(request(['search']))->sortable()
                            ->orderBy('id', 'asc')->paginate($row)->appends(request()->query()),
            'categories' => $categories,
            'publishers' => $publishers,
            'writers' => $writers,
        ]);
    }

    // CRUD
        public function create()
        {
            return view('warehouse.products.create', [
                'categories' => ProductCategory::all(),
                'publishers' => Publisher::all(),
                'writers' => Writer::all(),
            ]);
        }

        public function store(Request $request)
        {
            $product_code = IdGenerator::generate([
                'table' => 'products',
                'field' => 'product_code',
                'length' => 6,
                'prefix' => 'P-' 
            ]);

            $rolesMarketing = ['Admin', 'Manajer Marketing', 'Super Admin']; // Daftar peran yang membutuhkan validasi required
            
            // Jika user dari divisi Publishing
            $rolesPublishing = ['Manajer Publishing', 'Staf Publishing', 'Admin Publishing'];
            // Set publisher_id menjadi 1 jika user memiliki salah satu dari peran tersebut
            if ($request->user()->hasAnyRole($rolesPublishing)) {
                $request->merge(['publisher_id' => 1]);
            }
                
            $rules = [
                'product_image' => 'image|file|max:1024',
                'product_name' => 'required|string',
                'slug' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|alpha_dash|unique:products,slug,' : 'nullable',
                // 'slug' => 'required|unique|alpha_dash',
                'category_id' => 'required|integer',
                'publisher_id' => 'nullable|integer',
                // 'writer_id' => 'nullable|integer',
                'writer_id' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|integer' : 'integer|nullable',
                'cover' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|string' : 'string|nullable',
                'isbn1' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|integer|digits:3' : 'integer|nullable|digits:3',
                'isbn2' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|in:602' : 'integer|nullable',
                'isbn3' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|integer|digits:4' : 'integer|nullable|digits:4',
                'isbn4' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|integer|digits:2' : 'integer|nullable|digits:2',
                'isbn5' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|integer|digits:1' : 'integer|nullable|digits:1',
                'published' => in_array(auth()->user()->role, $rolesPublishing) ? 'date_format:m-Y|max:10|nullable' : 'date_format:m-Y|nullable',
                'page' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|integer' : 'integer|nullable',
                'weight' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|numeric' : 'numeric|nullable',
                'length' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|numeric' : 'numeric|nullable',
                'width' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|numeric' : 'numeric|nullable',
                'thickness' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|numeric' : 'numeric|nullable',
                'description' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|string' : 'string|nullable',
                // 'product_store' => 'string|nullable|min:0',
                'product_store' => 'integer|nullable|min:0',
                'buying_date' => 'date_format:Y-m-d|max:10|nullable',
                'expire_date' => 'date_format:Y-m-d|max:10|nullable',
                // 'buying_price' => 'required|integer',
                // 'selling_price' => 'required|integer',
                'buying_price' => in_array(auth()->user()->role, $rolesMarketing) ? 'required|integer' : 'integer|nullable',
                'selling_price' => in_array(auth()->user()->role, $rolesMarketing) ? 'required|integer' : 'integer|nullable',
            ];

            $validatedData = $request->validate($rules);

            // save product code value
            $validatedData['product_code'] = $product_code;

            /**
             * Handle upload image with Storage.
             */
            if ($file = $request->file('product_image')) {
                $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
                $path = 'public/products/';

                $file->storeAs($path, $fileName);
                $validatedData['product_image'] = $fileName;
            }

            Product::create($validatedData);

            return Redirect::route('products.index')->with('success', 'Product has been created!');
        }
    
        public function edit(Product $product)
        {
            return view('warehouse.products.edit', [
                'categories' => ProductCategory::all(),
                'publishers' => Publisher::all(),
                'writers' => Writer::all(),
                'product' => $product
            ]);
        }

        public function update(Request $request, Product $product)
        {
            $rolesPublishing = ['Manajer Publishing', 'Staf Publishing', 'Admin Publishing', 'Superadmin'];
            // Set publisher_id menjadi 1 jika user memiliki salah satu dari peran tersebut
            if ($request->user()->hasAnyRole($rolesPublishing)) {
                $request->merge(['publisher_id' => 1]);
            }
            $rolesMarketing = ['Admin', 'Manajer Marketing', 'Super Admin']; // Daftar peran yang membutuhkan validasi required
            
            $rules = [
                'product_image' => 'image|file|max:1024',
                'product_name' => 'required|string',
                'slug' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|alpha_dash' : 'nullable',
                // 'slug' => 'required|alpha_dash',
                'category_id' => 'required|integer',
                'publisher_id' => 'nullable|integer',
                // 'writer_id' => 'nullable|integer',
                'writer_id' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|integer' : 'integer|nullable',
                'cover' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|string' : 'string|nullable',
                'isbn1' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|integer|digits:3' : 'integer|nullable|digits:3',
                'isbn2' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|in:602' : 'integer|nullable',
                'isbn3' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|integer|digits:4' : 'integer|nullable|digits:4',
                'isbn4' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|integer|digits:2' : 'integer|nullable|digits:2',
                'isbn5' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|integer|digits:1' : 'integer|nullable|digits:1',
                'published' => in_array(auth()->user()->role, $rolesPublishing) ? 'date_format:m-Y|max:10|nullable' : 'date_format:m-Y|nullable',
                'page' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|integer' : 'integer|nullable',
                'weight' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|numeric' : 'numeric|nullable',
                'length' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|numeric' : 'numeric|nullable',
                'width' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|numeric' : 'numeric|nullable',
                'thickness' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|numeric' : 'numeric|nullable',
                'description' => in_array(auth()->user()->role, $rolesPublishing) ? 'required|string' : 'string|nullable',
                // 'product_store' => 'string|nullable|min:0',
                'product_store' => 'integer|nullable|min:0',
                'buying_date' => 'date_format:Y-m-d|max:10|nullable',
                'expire_date' => 'date_format:Y-m-d|max:10|nullable',
                // 'buying_price' => 'required|integer',
                // 'selling_price' => 'required|integer',
                'buying_price' => in_array(auth()->user()->role, $rolesMarketing) ? 'required|integer' : 'integer|nullable',
                'selling_price' => in_array(auth()->user()->role, $rolesMarketing) ? 'required|integer' : 'integer|nullable',
            ];

            $validatedData = $request->validate($rules);

            

            /**
             * Handle upload image with Storage.
             */
            if ($file = $request->file('product_image')) {
                $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
                $path = 'public/products/';

                /**
                 * Delete photo if exists.
                 */
                if($product->product_image){
                    Storage::delete($path . $product->product_image);
                }

                $file->storeAs($path, $fileName);
                $validatedData['product_image'] = $fileName;
            }

            Product::where('id', $product->id)->update($validatedData);
            // Product::where('slug', $product->slug)->update($validatedData);

            return Redirect::route('products.index')->with('success', 'Product has been updated!');
        }

        public function destroy(Product $product)
        {
            /**
             * Delete photo if exists.
             */
            if($product->product_image){
                Storage::delete('public/products/' . $product->product_image);
            }

            Product::destroy($product->id);

            return Redirect::route('products.index')->with('success', 'Product has been deleted!');
        }
    //

    

    public function show(Product $product)
    {
        // Barcode Generator
        $generator = new BarcodeGeneratorHTML();

        $barcode = $generator->getBarcode($product->product_code, $generator::TYPE_CODE_128);

        return view('warehouse.products.show', [
            'product' => $product,
            'barcode' => $barcode,
        ]);
    }

    public function stock()
    {
        $row = (int) request('row', 1000);
        $categoryFilter = request('category_id', null);
        $jenjang = request('jenjang', null);
        $kelas = request('kelas', null);
        $mapel = request('mapel', null);

        $query = Product::query()
            // SO
                ->withSum(['orderDetails as rekap_SOdiajukan' => function ($query) {
                        $query->whereHas('order', function ($q) {
                            $q->where('order_status', 'menunggu persetujuan');
                        });
                    }], 'quantity')
                ->withSum(['orderDetails as rekap_SOdisetujui' => function ($query) {
                        $query->whereHas('order', function ($q) {
                            $q->where('order_status', 'disetujui'); // Hanya order yang disetujui
                        });
                    }], 'quantity')
                ->withSum(['orderDetails as rekap_SOditolak' => function ($query) {
                        $query->whereHas('order', function ($q) {
                            $q->where('order_status', 'ditolak'); // Hanya order yang disetujui
                        });
                    }], 'quantity')
                ->withSum(['orderDetails as rekap_SOdibatalkan' => function ($query) {
                        $query->whereHas('order', function ($q) {
                            $q->where('order_status', 'dibatalkan'); // Hanya order yang disetujui
                        });
                    }], 'quantity')
            // DO 
            ->withSum(['deliveryDetails as rekap_DOterpacking' => function ($query) {
                    $query->whereHas('delivery', function ($q) {
                        $q->where('delivery_status', 'siap dikirim');
                    });
                }], 'quantity')
            ->withSum(['deliveryDetails as rekap_DOpengiriman' => function ($query) {
                    $query->whereHas('delivery', function ($q) {
                        $q->where('delivery_status', 'dalam pengiriman');
                    });
                }], 'quantity')
            ->withSum(['deliveryDetails as rekap_DOterkirim' => function ($query) {
                    $query->whereHas('delivery', function ($q) {
                        $q->where('delivery_status', 'terkirim'); // Hanya pengiriman yang berstatus terkirim
                    });
                }], 'quantity')
            ->withSum(['orderDetails as rekap_selesai' => function ($query) {
                    $query->whereHas('order', function ($q) {
                        $q->where('order_status', 'selesai'); // Hanya order yang disetujui
                    });
                }], 'quantity')
            ->orderBy('id', 'asc');
        
        if ($categoryFilter) {
                $query->where('category_id', $categoryFilter);
            };

        if ($jenjang) {
            $query->where('product_name', 'like', "%$jenjang%");
        }

        if ($kelas) {
            $query->where('product_name', 'like', "%$kelas%");
        }
        
        if ($mapel) {
            $query->where('product_name', 'like', "%$mapel%");
        }

        $categories = Product::select('category_id')->distinct()->get();

        return view('warehouse.stock.index', [
            'products' => $query->filter(request(['search']))->sortable()
                            ->paginate($row)->appends(request()->query()),
            'categories' => $categories,
        ]);
    }

    public function importView()
    {
        return view('warehouse.products.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'upload_file' => 'required|file|mimes:xls,xlsx',
        ]);

        $the_file = $request->file('upload_file');

        try{
            $spreadsheet = IOFactory::load($the_file->getRealPath());
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range( 2, $row_limit );
            $column_range = range( 'J', $column_limit );
            $startcount = 2;
            $data = array();
            foreach ( $row_range as $row ) {
                $data[] = [
                    'product_name' => $sheet->getCell( 'A' . $row )->getValue(),
                    'category_id' => $sheet->getCell( 'B' . $row )->getValue(),
                    'product_code' => $sheet->getCell( 'D' . $row )->getValue(),
                    'product_image' => $sheet->getCell( 'F' . $row )->getValue(),
                    'product_store' =>$sheet->getCell( 'G' . $row )->getValue(),
                    'buying_price' =>$sheet->getCell( 'J' . $row )->getValue(),
                    'selling_price' =>$sheet->getCell( 'K' . $row )->getValue(),
                ];
                $startcount++;
            }

            Product::insert($data);

        } catch (Exception $e) {
            // $error_code = $e->errorInfo[1];
            return Redirect::route('products.index')->with('error', 'There was a problem uploading the data!');
        }
        return Redirect::route('products.index')->with('success', 'Data has been successfully imported!');
    }

    public function exportExcel($products)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
    
        try {
            $spreadSheet = new Spreadsheet();
            $sheet = $spreadSheet->getActiveSheet();
    
            // Set default column width
            $sheet->getDefaultColumnDimension()->setWidth(20);
    
            // Add data to the sheet
            $sheet->fromArray($products);
    
            // Apply currency format to specific columns
            $highestRow = $sheet->getHighestRow();
            $currencyColumns = ['G', 'I', 'K', 'L']; // Kolom yang harus menggunakan format mata uang
            foreach ($currencyColumns as $column) {
                $sheet->getStyle("{$column}2:{$column}{$highestRow}")
                    ->getNumberFormat()
                    ->setFormatCode('"Rp"#,##0.00');
            }

            // Set middle alignment for all headers
            $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Set center alignment for specific columns
            $alignColumns = ['C', 'D', 'E', 'F', 'H', 'J'];
            foreach ($alignColumns as $column) {
                $sheet->getStyle("{$column}2:{$column}{$highestRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
            $sheet->getStyle('A1:L' . $highestRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    
            // Convert data to a table
            $table = new Table('A1:L' . $highestRow, 'StokProdukTable');
            $tableStyle = new TableStyle();
            $tableStyle->setTheme(TableStyle::TABLE_STYLE_MEDIUM2);
            $table->setStyle($tableStyle);
            $sheet->addTable($table);
    
            // Set headers for download
            $timestamp = date('dmY_His');
            $filename = "Stok Produk_$timestamp.xlsx";
    
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
    
            $Excel_writer = new Xlsx($spreadSheet);
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }
    
    public function exportData()
    {
        $products = Product::query()
            ->withSum(['orderDetails as rekap_dipesan' => function ($query) {
                $query->whereHas('order', function ($q) {
                    $q->where('order_status', 'disetujui'); // Hanya order yang disetujui
                });
            }], 'quantity')
            ->withSum(['deliveryDetails as rekap_terkirim' => function ($query) {
                $query->whereHas('delivery', function ($q) {
                    $q->where('delivery_status', 'terkirim'); // Hanya pengiriman yang berstatus terkirim
                });
            }], 'quantity')
            ->withSum(['orderDetails as rekap_selesai' => function ($query) {
                $query->whereHas('order', function ($q) {
                    $q->where('order_status', 'selesai'); // Hanya order yang selesai
                });
            }], 'quantity')
            ->orderByDesc('id') // Mengurutkan berdasarkan id sebelum get
            ->get();
    
        $product_array[] = [
            'Nama Produk',
            'Kategori',
            'Stok',
            'Jumlah dipesan',
            'Kebutuhan Stok',
            'Rekap Total Dipesan',
            'Rekap Total Dipesan (Rp)',
            'Rekap Total Terkirim',
            'Rekap Total Terkirim (Rp)',
            'Rekap Total Selesai',
            'Rekap Total Selesai (Rp)',
            'Harga (Rp)',
        ];
    
        foreach ($products as $product) {
            $product_array[] = [
                'Nama Produk' => $product->product_name,
                'Kategori' => optional($product->category)->name, // Hindari error jika kategori null
                'Stok' => $product->product_store,
                'Jumlah dipesan' => $product->product_ordered,
                'Kebutuhan Stok' => $product->stock_needed,
                'Rekap Total Dipesan' => $product->rekap_dipesan ?? 0, // Set default 0 jika null
                'Rekap Total Dipesan (Rp)' => $product->rekap_dipesan * $product->selling_price, // Set default 0 jika null
                'Rekap Total Terkirim' => $product->rekap_terkirim ?? 0,
                'Rekap Total Terkiri (Rp)m' => $product->rekap_terkirim * $product->selling_price,
                'Rekap Total Selesai' => $product->rekap_selesai ?? 0,
                'Rekap Total Selesai (Rp)' => $product->rekap_selesai * $product->selling_price,
                'Harga (Rp)' => $product->selling_price,
            ];
        }
    
        $this->exportExcel($product_array);
    }
    
}
