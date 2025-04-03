<?php

namespace App\Http\Controllers\Cashflow;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Models\CashflowCategory;
use App\Models\CashflowType;

class CashflowCategoryController extends Controller
{
    public function index()
    {
        $row = (int) request('row', 100);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        return view('finance.cashflow.category.index', [
            'cashflowcategories' => CashflowCategory::sortable()
                ->paginate($row)
                ->appends(request()->query()),
            'title' => 'Kategori Transaksi',
        ]);
    }

    public function show(Cashflowcategory $cashflowcategory)
    {
        //
    }

    // CRUD
        public function create()
        {
            return view('finance.cashflow.category.create');
        }

        public function store(Request $request)
        {
            $rules = [
                'type' => 'required|string',
                'category' => 'required|string',
                'detail' => 'required|string',
            ];

            $validatedData = $request->validate($rules);

            CashflowCategory::create($validatedData);

            return Redirect::route('cashflowcategory.index')->with('success', 'Category has been created!');
        }

        public function edit(Cashflowcategory $cashflowcategory)
        {
            return view('finance.cashflow.category.edit', [
                'cashflowcategory' => $cashflowcategory
            ]);
        }

        public function update(Request $request, Cashflowcategory $cashflowcategory)
        {
            $rules = [
                'type' => 'nullable|string',
                'category' => 'nullable|string',
                'detail' => 'nullable|string',
            ];

            $validatedData = $request->validate($rules);

            CashflowCategory::where('id', $cashflowcategory->id)->update($validatedData);

            return Redirect::route('cashflowcategory.index')->with('success', 'Kategori Transaksi has been updated!');
        }

        public function destroy(Cashflowcategory $cashflowcategory)
        {
            CashflowCategory::destroy($cashflowcategory->id);

            return Redirect::route('cashflowcategory.index')->with('success', 'Category has been deleted!');
        }
    // 
}
