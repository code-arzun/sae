<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Supplier;
use App\Models\AdvanceSalary;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $superadmin = \App\Models\User::factory()->create([
            // 'name' => 'Super Admin',
            'employee_id' => '1',
            'username' => 'superadmin',
            // 'email' => 'superadmin@saesmartgroup.com',
            // 'password' => bcrypt('sae12345'),
            'password' => bcrypt('SuperAdmin123!'),
        ]);

        $managermarketing = \App\Models\User::factory()->create([
            // 'name' => 'Manajer Marketing',
            'employee_id' => 'Manajer Marketing',
            'username' => 'manajermarketingsae',
            // 'email' => 'manajermarketing@saesmartgroup.com',
            // 'password' => bcrypt('sae12345'),
            'password' => bcrypt('ManajerMarketingSAE@'),
        ]);

        $sales = \App\Models\User::factory()->create([
            // 'name' => 'SAE',
            'employee_id' => '2',
            'username' => 'sales01',
            // 'email' => 'sales01@saesmartgroup.com',
            // 'password' => bcrypt('sae12345'),
            'password' => bcrypt('Sales01SAE#'),
        ]);

        $sales = \App\Models\User::factory()->create([
            // 'name' => 'Angger Wahyu N.',
            'employee_id' => '3',
            'username' => 'sales02',
            // 'email' => 'sales02@saesmartgroup.com',
            // 'password' => bcrypt('sae12345'),
            'password' => bcrypt('Sales02SAE$'),
        ]);

        $gudang = \App\Models\User::factory()->create([
            // 'name' => 'Gudang',
            'employee_id' => '4',
            'username' => 'gudangsae',
            // 'email' => 'gudang@saesmartgroup.com',
            // 'password' => bcrypt('sae12345'),
            'password' => bcrypt('GudangSAE%'),
        ]);
        $finance = \App\Models\User::factory()->create([
            // 'name' => 'Finance',
            'employee_id' => '5',
            'username' => 'financesae',
            // 'email' => 'finance@saesmartgroup.com',
            // 'password' => bcrypt('sae12345'),
            'password' => bcrypt('FinanceSAE^'),
        ]);

        // Employee::factory(5)->create();
        // // AdvanceSalary::factory(25)->create();

        // // Customer::factory(25)->create();
        // Supplier::factory(10)->create();

        // for ($i=0; $i < 10; $i++) {
        //     Product::factory()->create([
        //         'product_code' => IdGenerator::generate([
        //             'table' => 'products',
        //             'field' => 'product_code',
        //             'length' => 5,
        //             'prefix' => 'P'
        //         ])
        //     ]);
        // }
        Category::factory(5)->create();

        // ARUS KAS
        Permission::create(['name' => 'expense.menu', 'group_name' => 'expense']);
        Permission::create(['name' => 'income.menu', 'group_name' => 'income']);
        // KEPEGAWAIAN
        Permission::create(['name' => 'employee.menu', 'group_name' => 'employee']);
        Permission::create(['name' => 'attendence.menu', 'group_name' => 'attendence']);
        Permission::create(['name' => 'salary.menu', 'group_name' => 'salary']);
        // SALES
        Permission::create(['name' => 'pos.menu', 'group_name' => 'pos']);
        Permission::create(['name' => 'orders.menu', 'group_name' => 'orders']);
        Permission::create(['name' => 'customer.menu', 'group_name' => 'customer']);
        // GUDANG
        Permission::create(['name' => 'do.menu', 'group_name' => 'do']);
        Permission::create(['name' => 'supplier.menu', 'group_name' => 'supplier']);
        Permission::create(['name' => 'category.menu', 'group_name' => 'category']);
        Permission::create(['name' => 'product.menu', 'group_name' => 'product']);
        Permission::create(['name' => 'stock.menu', 'group_name' => 'stock']);
        Permission::create(['name' => 'deliveries.menu', 'group_name' => 'deliveries']);
        // TAGIHAN
        Permission::create(['name' => 'due.menu', 'group_name' => 'due']);
        Permission::create(['name' => 'collection.menu', 'group_name' => 'collection']);
        Permission::create(['name' => 'expense.menu', 'group_name' => 'expense']);
        // USER
        Permission::create(['name' => 'roles.menu', 'group_name' => 'roles']);
        Permission::create(['name' => 'user.menu', 'group_name' => 'user']);
        Permission::create(['name' => 'database.menu', 'group_name' => 'database']);

        Role::create(['name' => 'SuperAdmin'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'ManagerMarketing'])->givePermissionTo(['attendence.menu', 'customer.menu', 'salary.menu', 'attendence.menu', 'employee.menu', 'product.menu', 'orders.menu',]);
        Role::create(['name' => 'Sales'])->givePermissionTo(['attendence.menu', 'pos.menu', 'customer.menu',  ]);
        Role::create(['name' => 'Gudang'])->givePermissionTo(['attendence.menu', 'product.menu', 'supplier.menu', 'category.menu', 'orders.menu']);
        Role::create(['name' => 'Finance'])->givePermissionTo(['attendence.menu', 'orders.menu', 'collection.menu', 'expense.menu' ]);

        $superadmin->assignRole('SuperAdmin');
        $managermarketing->assignRole('ManagerMarketing');
        $sales->assignRole('Sales');
        $gudang->assignRole('Gudang');
        $finance->assignRole('Finance');
    }
}
