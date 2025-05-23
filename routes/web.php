<?php

use App\Http\Controllers\Dashboard\DashboardController;

// Marketing
    // Sales Order
        use App\Http\Controllers\Marketing\SalesOrderController;
    // Customer
        use App\Http\Controllers\Marketing\CustomerController;

    
//

// Warehouse
    // Product
        use App\Http\Controllers\Warehouse\ProductCategoryController;
        use App\Http\Controllers\Warehouse\ProductUnitController;
        use App\Http\Controllers\Warehouse\ProductController;
    // Delivery Order
        use App\Http\Controllers\Warehouse\DeliveryController;
    // Supplier
        use App\Http\Controllers\Warehouse\SupplierController;
    // Stok
        use App\Http\Controllers\Warehouse\StockController;
//

// Finance
    // Bank
        use App\Http\Controllers\Finance\BankController;
    // Rekening
        use App\Http\Controllers\Finance\RekeningController;
    // Collection
        use App\Http\Controllers\Finance\CollectionController;
    // Cashflow
        use App\Http\Controllers\Finance\Cashflow\CashflowController;
        use App\Http\Controllers\Finance\Cashflow\CashflowCategoryController;
//

// Human Resource
    use App\Http\Controllers\HumanResource\EmployeeController;
    use App\Http\Controllers\HumanResource\PositionController;
    use App\Http\Controllers\HumanResource\PaySalaryController;
    use App\Http\Controllers\HumanResource\AttendanceController;
    use App\Http\Controllers\HumanResource\DepartmentController;
    use App\Http\Controllers\HumanResource\AdvanceSalaryController;
//

// Settings
    use App\Http\Controllers\Settings\RoleController;
    use App\Http\Controllers\Settings\UserController;
    use App\Http\Controllers\Settings\ProfileController;
    use App\Http\Controllers\Settings\DatabaseBackupController;
//

use App\Models\Order;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Warehouse\ReturController;
use App\Http\Controllers\Warehouse\PublisherController;

use App\Http\Controllers\Publishing\WriterController;
use App\Http\Controllers\Publishing\WriterJobController;
use App\Http\Controllers\Publishing\WriterCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// LANDING PAGE
    // Route::get('/', function () {
    //     return redirect('/welcome');
    // });
    Route::get('/', function () {
        return view('landing-page.index');
    });
    Route::get('/portfolio-detail', function () {
        return view('landing-page.portfolio-details');
    });
//

// LOGIN
    // Route::get('/user/login', function () {
    //     return redirect('/login');
    // });
    Route::get('/user/signin', function () {
        return redirect('/login');
    });
    Route::get('/sign-in', function () {
        return redirect('/login');
    });
    Route::get('/log-in', function () {
        return redirect('/login');
    });
    Route::get('/akses-masuk-pengguna', function () {
        return redirect('/login');
    });
//

// HUMAN RESOURCE
    // ====== Employee ======
        Route::middleware(['permission:employee'])->group(function () {
            Route::resource('/employees', EmployeeController::class);
            Route::resource('/position', PositionController::class);
            Route::resource('/department', DepartmentController::class);
            Route::get('kehadiran-pegawai/{year}', [AttendanceController::class, 'allAttendance'])->name('allAttendance');
            Route::get('kehadiran-pegawai/', function () {
                return redirect()->route('allAttendance', ['year' => date('Y')]);
            });
        });

    // ====== Employee Attendance ======
        Route::resource('/attendance', AttendanceController::class);
        // Route::middleware(['permission:employee'])->group(function () {
        //     Route::get('attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
        //     Route::post('attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');
        //     Route::get('attendance/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
        //     Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])->name('attendance.update');
        //     Route::get('/attendance/{date}', [AttendanceController::class, 'show'])->name('attendance.show');
        // });

    // ====== Salary ======
    Route::middleware(['permission:salary.menu'])->group(function () {
        // PaySalary
        Route::resource('/pay-salary', PaySalaryController::class)->except(['show', 'create', 'edit', 'update']);
        Route::get('/pay-salary/history', [PaySalaryController::class, 'payHistory'])->name('pay-salary.payHistory');
        Route::get('/pay-salary/history/{id}', [PaySalaryController::class, 'payHistoryDetail'])->name('pay-salary.payHistoryDetail');
        Route::get('/pay-salary/{id}', [PaySalaryController::class, 'paySalary'])->name('pay-salary.paySalary');

        // Advance Salary
        Route::resource('/advance-salary', AdvanceSalaryController::class)->except(['show']);
    });
//

// MARKETING
    // SALES
        // Sales
            Route::get('/sales', [CustomerController::class, 'sales'])->name('sales');
        
        // Customer
            Route::middleware(['permission:customer'])->group(function () {
                    Route::resource('/customers', CustomerController::class);
            });

        // Sales Order
            Route::get('details/{order_id}', [SalesOrderController::class, 'orderDetails'])->name('so.orderDetails');
            Route::prefix('so')->group(function () {
                // Input Sales Order
                Route::middleware(['permission:input.so'])->prefix('input')->group(function () {
                    Route::get('', [SalesOrderController::class,'input'])->name('input.so');
                    Route::post('confirmation', [SalesOrderController::class, 'inputsoConfirmation'])->name('inputso.confirmation');

                    Route::post('add', [SalesOrderController::class, 'addCart'])->name('inputso.addCart');
                    Route::post('update/{rowId}', [SalesOrderController::class, 'updateCart'])->name('inputso.updateCart');
                    Route::get('delete/{rowId}', [SalesOrderController::class, 'deleteCart'])->name('inputso.deleteCart');
                    
                    // Sent to Database
                        Route::post('reguler/store', [SalesOrderController::class, 'storeSOReguler'])->name('store.SOReguler');
                        Route::post('het/store', [SalesOrderController::class, 'storeSOHet'])->name('store.SOHet');
                        Route::post('reguler-online/store', [SalesOrderController::class, 'storeSOROnline'])->name('store.SOROnline');
                        Route::post('het-online/store', [SalesOrderController::class, 'storeSOHOnline'])->name('store.SOHOnline');
                });

                // View Sales Order
                Route::middleware(['permission:so'])->group(function () {
                    Route::get('', [SalesOrderController::class, 'index'])->name('so.index');
                    // Route::get('all', [SalesOrderController::class, 'all'])->name('so.all');
                    Route::get('proposed', [SalesOrderController::class, 'proposed'])->name('so.proposed');
                    Route::get('approved', [SalesOrderController::class, 'approved'])->name('so.approved');
                    Route::get('sent', [SalesOrderController::class, 'sent'])->name('so.sent');
                    Route::get('delivered', [SalesOrderController::class, 'delivered'])->name('so.delivered');
                    Route::get('declined', [SalesOrderController::class, 'declined'])->name('so.declined');
                    Route::get('cancelled', [SalesOrderController::class, 'cancelled'])->name('so.cancelled');

                    // Route::get('details/{order_id}', [SalesOrderController::class, 'orderDetails'])->name('so.orderDetails');

                    // Status Update
                        Route::put('approved/status', [SalesOrderController::class, 'approvedStatus'])->name('so.approvedStatus');
                        Route::put('declined/status', [SalesOrderController::class, 'declinedStatus'])->name('so.declinedStatus');
                        Route::put('cancelled/status', [SalesOrderController::class, 'cancelledStatus'])->name('so.cancelledStatus');
                        Route::put('shipping/status', [SalesOrderController::class, 'shippingStatus'])->name('so.shippingStatus');
                        Route::put('finished/status', [SalesOrderController::class, 'finishedStatus'])->name('so.finishedStatus');

                    Route::get('invoice/download/{order_id}', [SalesOrderController::class, 'invoiceDownload'])->name('so.invoiceDownload');
                    Route::get('export', [SalesOrderController::class, 'exportData'])->name('so.exportData');
                });

                Route::get('/chart/bar', [SalesOrderController::class, 'barChart'])->name('so.barChart');
            });
// 
            
// WAREHOUSE
    Route::middleware(['permission:warehouse'])->group(function () {
    });
    // Stock
    Route::prefix('stock')->group(function () {
        // Input Stock
        Route::middleware(['permission:input.stock'])->prefix('input')->group(function () {
            Route::get('', [StockController::class,'input'])->name('input.stock');
            Route::post('add', [StockController::class, 'addCart'])->name('inputstock.addCart');
            Route::post('update/{rowId}', [StockController::class, 'updateCart'])->name('inputstock.updateCart');
            Route::get('delete/{rowId}', [StockController::class, 'deleteCart'])->name('inputstock.deleteCart');
            Route::post('confirmation', [StockController::class, 'confirmation'])->name('inputstock.confirmation');
            // Route::post('invoice/print', [InputStockController::class, 'printInvoice'])->name('inputstock.printInvoice');

            // Sent to Database
            Route::post('/inputstock/entry', [StockController::class, 'storeStock'])->name('inputstock.storeStock');
        });

        // Stock
            // Route::get('', [StockController::class, 'stockManage'])->name('product.stock');

        // Entry Stock History
            Route::get('all', [StockController::class, 'all'])->name('stock.all');
            Route::get('details/{stock_id}', [StockController::class, 'stockDetails'])->name('stock.Details');
            Route::get('invoice/download/{stock_id}', [StockController::class, 'invoiceDownload'])->name('stock.invoiceDownload');

    });
    
    // Penyiapan Produk
    Route::middleware(['permission:penyiapan'])->get('download/{order_id}', [SalesOrderController::class, 'printPenyiapan'])->name('do.printPenyiapan');

    Route::prefix('do')->group(function () {
        // Input DO
        Route::middleware(['permission:input.do'])->prefix('input')->group(function () {
            Route::get('', [DeliveryController::class,'input'])->name('input.do');
            Route::post('confirmation', [DeliveryController::class,'inputdoConfirmation'])->name('inputdo.confirmation');

            Route::post('add', [DeliveryController::class, 'addCart'])->name('inputdo.addCart');
            Route::post('update/{rowId}', [DeliveryController::class, 'updateCart'])->name('inputdo.updateCart');
            Route::get('delete/{rowId}', [DeliveryController::class, 'deleteCart'])->name('inputdo.deleteCart');

            // Sent to Database
                Route::post('reguler/store', [DeliveryController::class, 'storeDOReguler'])->name('store.DOReguler');
                Route::post('het/store', [DeliveryController::class, 'storeDOHet'])->name('store.DOHet');
                Route::post('reguler/online/store', [DeliveryController::class, 'storeDOROnline'])->name('store.DOROnline');
                Route::post('het/online/store', [DeliveryController::class, 'storeDOHOnline'])->name('store.DOHOnline');
        });

        // Delivery Order
        Route::middleware(['permission:do'])->group(function () {
            Route::get('', [DeliveryController::class, 'index'])->name('do.index');
            Route::get('details/{delivery_id}', [DeliveryController::class, 'deliveryDetails'])->name('do.deliveryDetails');

            // Status Update
            Route::put('sent/status', [DeliveryController::class, 'sentStatus'])->name('do.sentStatus');
            Route::put('delivered/status', [DeliveryController::class, 'deliveredStatus'])->name('do.deliveredStatus');
            
            // Dokumen
            Route::get('invoice/download/{delivery_id}', [DeliveryController::class, 'invoiceDownload'])->name('do.invoiceDownload');
            Route::get('label/{delivery_id}', [DeliveryController::class, 'labelPengiriman'])->name('do.labelPengiriman');

            Route::get('/chart/bar', [DeliveryController::class, 'barChart'])->name('do.barChart');

            Route::get('export', [DeliveryController::class, 'exportData'])->name('do.exportData');
        });
    });

            // Stock Management
            // Route::get('/stock', [DeliveryController::class, 'stockManage'])->name('delivery.stockManage');
            // Route::get('/stock', [StockController::class, 'stockManage'])->name('product.stock');

    // Retur Order
    Route::prefix('retur')->group(function () {
        // Input Retur Order
        Route::middleware(['permission:input.retur'])->prefix('input')->group(function () {
            Route::get('', [ReturController::class,'input'])->name('input.retur');
            Route::post('confirmation', [ReturController::class, 'inputreturConfirmation'])->name('inputretur.confirmation');

            Route::post('add', [ReturController::class, 'addCart'])->name('inputretur.addCart');
            Route::post('update/{rowId}', [ReturController::class, 'updateCart'])->name('inputretur.updateCart');
            Route::get('delete/{rowId}', [ReturController::class, 'deleteCart'])->name('inputretur.deleteCart');
            
            // Sent to Database
                Route::post('reguler/store', [ReturController::class, 'storeROReguler'])->name('store.ROReguler');
                Route::post('het/store', [ReturController::class, 'storeROHet'])->name('store.ROHet');
                Route::post('reguler-online/store', [ReturController::class, 'storeROROnline'])->name('store.ROROnline');
                Route::post('het-online/store', [ReturController::class, 'storeROHOnline'])->name('store.ROHOnline');
        });

        // View Retur Order
        Route::middleware(['permission:retur'])->group(function () {
            Route::get('', [ReturController::class, 'index'])->name('retur.index');
            // Route::get('all', [ReturController::class, 'all'])->name('retur.all');
            // Route::get('proposed', [ReturController::class, 'proposed'])->name('retur.proposed');
            // Route::get('approved', [ReturController::class, 'approved'])->name('retur.approved');
            // Route::get('declined', [ReturController::class, 'declined'])->name('retur.declined');
            // Route::get('cancelled', [ReturController::class, 'cancelled'])->name('retur.cancelled');

            Route::get('details/{retur_id}', [ReturController::class, 'returDetails'])->name('retur.Details');

            // Status Update
                Route::put('approved/status', [ReturController::class, 'approvedStatus'])->name('retur.approvedStatus');
                Route::put('declined/status', [ReturController::class, 'declinedStatus'])->name('retur.declinedStatus');
                Route::put('cancelled/status', [ReturController::class, 'cancelledStatus'])->name('retur.cancelledStatus');

            Route::get('invoice/download/{order_id}', [ReturController::class, 'invoiceDownload'])->name('retur.invoiceDownload');
            Route::get('export', [ReturController::class, 'exportData'])->name('retur.exportData');
        });
    });

    // Publisher
        Route::resource('/publisher', PublisherController::class);
    // Supplier
        Route::resource('/suppliers', SupplierController::class);

        // Product
        Route::middleware(['permission:product'])->group(function () {
            Route::resource('/products', ProductController::class);
            Route::get('import', [ProductController::class, 'importView'])->name('products.importView');
            Route::post('import', [ProductController::class, 'importStore'])->name('products.importStore');
            Route::get('export', [ProductController::class, 'exportData'])->name('products.exportData');
            // Products Category
            // Route::resource('/product/category', ProductCategoryController::class);
            Route::resource('/productcategory', ProductCategoryController::class);
            // Products Unit
            Route::resource('productunit', ProductUnitController::class);
        });
        // Stock
        Route::get('/stock', [ProductController::class, 'stock'])->name('product.stock');
//

// FINANCE
    // Bank
        Route::resource('bank', BankController::class);
    // Rekening
        Route::resource('rekening', RekeningController::class);
    // Collection
        Route::prefix('collection')->group(function () {
            // Input Collection
            Route::middleware(['permission:input.collection'])->prefix('input')->group(function () {
                Route::get('', [CollectionController::class,'input'])->name('input.collection');
                Route::post('confirmation', [CollectionController::class, 'inputColConfirmation'])->name('inputCol.confirmation');
                // Sent to Database
                    Route::post('reguler/store', [CollectionController::class, 'storeColReguler'])->name('store.ColReguler');
                    Route::post('het/store', [CollectionController::class, 'storeColHet'])->name('store.ColHet');
                    Route::post('reguler-online/store', [CollectionController::class, 'storeColROnline'])->name('store.ColROnline');
                    Route::post('het-online/store', [CollectionController::class, 'storeColHOnline'])->name('store.ColHOnline');
            });

            // View Collection
            Route::middleware(['permission:collection'])->group(function () {
                Route::get('', [CollectionController::class, 'index'])->name('collection.index');
                Route::get('details/{collection_id}', [CollectionController::class, 'collectionDetails'])->name('collection.details');
                
                Route::get('invoice/download/{collection_id}', [CollectionController::class, 'invoiceDownload'])->name('collection.invoiceDownload');
                Route::get('export', [CollectionController::class, 'exportData'])->name('collection.exportData');
            });
        });
//

// CASHFLOW
    // Arus Kas
    Route::middleware(['permission:cashflow'])->group(function () {
        Route::resource('cashflow', CashflowController::class);
        Route::resource('cashflowcategory', CashflowCategoryController::class);
    });
    // // Pengeluaran
        // Route::get('/expense/import', [CashflowController::class, 'importView'])->name('expense.importView');
        // Route::post('/expense/import', [CashflowController::class, 'importStore'])->name('expense.importStore');
        // Route::get('/expense/export', [CashflowController::class, 'exportData'])->name('expense.exportData');
    // // Pemasukan
        // Route::get('/income/import', [CashflowIncomeController::class, 'importView'])->name('income.importView');
        // Route::post('/income/import', [CashflowIncomeController::class, 'importStore'])->name('income.importStore');
        // Route::get('/income/export', [CashflowIncomeController::class, 'exportData'])->name('income.exportData');
//

// PUBLISHING
    // Writers
        Route::middleware(['permission:input.writer'])->group(function () {
            Route::resource('writer', WriterController::class);
        });
        Route::middleware(['permission:writer'])->group(function () {
            // Writers Jobs
            Route::resource('writerjob', WriterJobController::class);
            // Writers Category
            Route::resource('writercategory', WriterCategoryController::class);
        });
    // Books

    
//

// SETTINGS
    // Role Controller
    Route::middleware(['permission:roles.menu'])->group(function () {
        // Permissions
        Route::get('/permission', [RoleController::class, 'permissionIndex'])->name('permission.index');
        Route::get('/permission/create', [RoleController::class, 'permissionCreate'])->name('permission.create');
        Route::post('/permission', [RoleController::class, 'permissionStore'])->name('permission.store');
        Route::get('/permission/edit/{id}', [RoleController::class, 'permissionEdit'])->name('permission.edit');
        Route::put('/permission/{id}', [RoleController::class, 'permissionUpdate'])->name('permission.update');
        Route::delete('/permission/{id}', [RoleController::class, 'permissionDestroy'])->name('permission.destroy');

        // Roles
        Route::get('/role', [RoleController::class, 'roleIndex'])->name('role.index');
        Route::get('/role/create', [RoleController::class, 'roleCreate'])->name('role.create');
        Route::post('/role', [RoleController::class, 'roleStore'])->name('role.store');
        Route::get('/role/edit/{id}', [RoleController::class, 'roleEdit'])->name('role.edit');
        Route::put('/role/{id}', [RoleController::class, 'roleUpdate'])->name('role.update');
        Route::delete('/role/{id}', [RoleController::class, 'roleDestroy'])->name('role.destroy');

        // Role Permissions
        Route::get('/role/permission', [RoleController::class, 'rolePermissionIndex'])->name('rolePermission.index');
        Route::get('/role/permission/create', [RoleController::class, 'rolePermissionCreate'])->name('rolePermission.create');
        Route::post('/role/permission', [RoleController::class, 'rolePermissionStore'])->name('rolePermission.store');
        Route::get('/role/permission/{id}', [RoleController::class, 'rolePermissionEdit'])->name('rolePermission.edit');
        Route::put('/role/permission/{id}', [RoleController::class, 'rolePermissionUpdate'])->name('rolePermission.update');
        Route::delete('/role/permission/{id}', [RoleController::class, 'rolePermissionDestroy'])->name('rolePermission.destroy');
    });
    // ====== USERS ======
    Route::middleware(['permission:user.menu'])->group(function () {
        Route::resource('/users', UserController::class)->except(['show']);
    });
    // ====== Profile ======
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    });
// 

// ====== Database Backup ======
    Route::middleware(['permission:database.menu'])->group(function () {
        Route::get('/database/backup', [DatabaseBackupController::class, 'index'])->name('backup.index');
        Route::get('/database/backup/now', [DatabaseBackupController::class, 'create'])->name('backup.create');
        Route::get('/database/backup/download/{getFileName}', [DatabaseBackupController::class, 'download'])->name('backup.download');
        Route::get('/database/backup/delete/{getFileName}', [DatabaseBackupController::class, 'delete'])->name('backup.delete');
    });
//

Route::get('/orders/chart-status', function () {
    $orders = Order::selectRaw('
            order_status, 
            COUNT(*) as total_orders, 
            SUM(sub_total) as total_sub_total, 
            SUM(discount_rp) as total_discount, 
            SUM(grandtotal) as total_grandtotal
        ')
        ->groupBy('order_status')
        ->orderBy('order_status', 'asc')
        ->get();

    return response()->json($orders);
});

require __DIR__.'/auth.php';
