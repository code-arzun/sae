<?php

namespace App\Http\Controllers\Marketing;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $row = (int) request('row', 10);
    
        if ($row < 1 || $row > 10000) {
            abort(400, 'The per-page parameter must be an integer between 1 and 10000.');
        }
    
        $user = auth()->user();
        $salesFilter = request('employee_id', null);
        $potensi = request('Potensi', null);
        $jenjang = request('jenjang', null);
    
        $customers = Customer::with(['employee']);
                       
        if ($user->hasRole('Sales')) {
            $customers->where('employee_id', $user->employee_id);
        } elseif ($user->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin'])) {
        } else {
            abort(403, 'Anda tidak memiliki izin untuk mengakses data ini.');
        }

        if ($salesFilter) {
                $customers->where('employee_id', $salesFilter);
        };
        
        if ($potensi) {
                $customers->where('Potensi', $potensi);
        };

        if ($jenjang) {
            $customers->where('NamaLembaga', 'like', "%$jenjang%");
        };
        
        $sales = Customer::select('employee_id')->distinct()->get();

        $employees = [];
        if ($user->hasRole('Sales')) {
            $employees = Employee::where('id', $user->employee_id)->get();
        } elseif ($user->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin'])) {
            $employees = Employee::where('department_id', '2')->get();
        }
    
        return view('marketing.customers.index', [
            'sales' => $sales,
            'employees' => $employees,
            'customers' => $customers->filter(request(['search']))->sortable()->orderBy('id', 'desc')
                ->paginate($row)->appends(request()->query()),
            'title' => 'Data Customer'
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $user = auth()->user();
        // $employees = [];
        // if ($user->hasRole('Sales')) {
        // } else {
        //     $employees = Employee::where('department_id', '2')->get();
        // }
        return view('marketing.customers.create', [
            // 'employees' => $employees,
            'title' => 'Tambah Customer Baru'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'NamaLembaga' => 'required|string|max:100',
            'AlamatLembaga' => 'nullable|string|max:500',
            'TelpLembaga' => 'nullable|string|min:7|max:12',
            'EmailLembaga' => 'nullable|email|max:50',
            'Potensi' => 'nullable|max:20',
            'CatatanLembaga' => 'nullable|max:500',
            'NamaCustomer' => 'required|string|max:100',
            'Jabatan' => 'nullable|max:25',
            'AlamatCustomer' => 'nullable|string|max:500',
            'TelpCustomer' => 'nullable|string|min:9|max:14',
            'EmailCustomer' => 'nullable|email|max:50',
            'CatatanCustomer' => 'max:500',
            'FotoCustomer' => 'image|file|max:1024',
            // 'employee_id' => 'required|integer',
        ];

        $validatedData = $request->validate($rules);

        // Tentukan employee_id berdasarkan role
        if ($user->hasRole('Sales')) {
            $validatedData['employee_id'] = $user->employee_id;
        } else {
            $rules['employee_id'] = 'required|integer';
            $validatedData = $request->validate($rules);
        }

        // Handle upload gambar jika ada
        if ($file = $request->file('FotoCustomer')) {
            // Format nama file: nama-produk-timestamp.extensi
            $customer = Str::slug($request->NamaCustomer); // Membuat slug dari nama produk
            $timestamp = time(); // atau format date('YmdHis')
            $extension = $file->getClientOriginalExtension();
            
            $fileName = "{$customer}-{$timestamp}.{$extension}";
            $path = 'public/customers/';
        
            // Simpan file
            $file->storeAs($path, $fileName);
            
            // Simpan path yang bisa diakses publik
            $validatedData['FotoCustomer'] = 'storage/customers/'.$fileName;
        } else {
            // Set default image jika tidak ada upload
            $validatedData['FotoCustomer'] = 'storage/customers/default.jpg';
        }

        // Simpan data ke database
        Customer::create($validatedData);

        // Redirect dengan pesan sukses
        return Redirect::route('customers.index')->with('success', 'Data customer terbaru berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $employees = Employee::where('department_id', '2')->get();
        // Data SO
        $orders = Order::with('customer')
            ->where('customer_id', $customer->id)->get();
        
        return view('marketing.customers.show', 
            compact('customer', 'orders'), 
            ['employees' => $employees,
            'title' => 'Detail Customer']
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $employees = Employee::where('department_id', '2')->get();

        return view('marketing.customers.edit', [
            'customer' => $customer,
            'employees' => $employees,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $user = auth()->user();

        $rules = [
            'NamaLembaga' => 'required|string|max:100',
            'AlamatLembaga' => 'nullable|string|max:500',
            'TelpLembaga' => 'nullable|string|min:7|max:12',
            'EmailLembaga' => 'nullable|email|max:50',
            'Potensi' => 'nullable|max:20',
            'CatatanLembaga' => 'nullable|max:500',
            'NamaCustomer' => 'required|string|max:100',
            // 'Jabatan' => 'required|max:25',
            'Jabatan' => 'nullable|max:25',
            'AlamatCustomer' => 'nullable|string|max:500',
            'TelpCustomer' => 'nullable|string|min:9|max:14',
            'EmailCustomer' => 'nullable|email|max:50',
            'CatatanCustomer' => 'max:500',
            'FotoCustomer' => 'image|file|max:1024',
            // 'employee_id' => 'required|integer',
        ];

        $validatedData = $request->validate($rules);

        // Tentukan employee_id berdasarkan role
        if ($user->hasRole('Sales')) {
            $validatedData['employee_id'] = $user->employee_id;
        } else {
            $rules['employee_id'] = 'required|integer';
            $validatedData = $request->validate($rules);
        }

        /**
         * Handle upload image with Storage.
         */
        if ($file = $request->file('FotoCustomer')) {
            // Format nama file: nama-produk-timestamp.extensi
            $namaLembaga = Str::slug($request->NamaLembaga); // Membuat slug dari nama produk
            $namaCustomer = Str::slug($request->NamaCustomer); // Membuat slug dari nama produk
            $timestamp = time(); // atau format date('YmdHis')
            $extension = $file->getClientOriginalExtension();
            
            $fileName = "{$namaLembaga}_{$namaCustomer}_{$timestamp}.{$extension}";
            $path = 'public/customers/';
            /**
             * Delete photo if exists.
             */
            if($customer->FotoCustomer){
                Storage::delete($path . $customer->FotoCustomer);
            }
            if ($customer->FotoCustomer && $customer->FotoCustomer != 'storage/customers/default.jpg') {
                // Ubah path dari 'storage/' ke 'public/' untuk kompatibilitas Storage::delete
                $oldFilePath = str_replace('storage/', 'public/', $customer->FotoCustomer);
                Storage::delete($oldFilePath);
            }

            $file->storeAs($path, $fileName);
            $validatedData['FotoCustomer'] = 'storage/customers/'.$fileName;
        } else {
            // Set default image jika tidak ada upload
            $validatedData['FotoCustomer'] = 'storage/customers/default.jpg';
        }


        Customer::where('id', $customer->id)->update($validatedData);

        // return Redirect::route('customers.index')->with('success', 'Data customer telah berhasil diperbarui!');
        return back()->with('success', 'Data customer telah berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        /**
         * Delete photo if exists.
         */
        if($customer->FotoCustomer){
            Storage::delete('public/customers/' . $customer->FotoCustomer);
        }

        Customer::destroy($customer->id);

        return Redirect::route('customers.index')->with('success', 'Customer has been deleted!');
    }

    // Sales
    public function sales(Employee $sales)
    {
        $sales = Employee::where('department_id', 2)
                ->with(['orders' => function ($query) {
                    // $query->select('id', 'customer_id', 'order_status'); // Sesuaikan field yang diperlukan
                    
                }])
                ->get();

        return view('marketing.sales.index', compact('sales'));
    }
}
