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
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        return view('cashflow.category.index', [
            'cashflowcategories' => CashflowCategory::with(['cashflowtype'])
                ->sortable()
                ->paginate($row)
                ->appends(request()->query()),
        ]);
    }

    public function create()
    {
        return view('cashflow.category.create', [
            'cashflowtypes' => CashflowType::all(),
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'cashflowtype_id' => 'required|integer',
            'name' => 'required|string',
        ];

        $validatedData = $request->validate($rules);

        CashflowCategory::create($validatedData);

        return Redirect::route('cashflowcategory.index')->with('success', 'Category has been created!');
    }

    public function show(Cashflowcategory $cashflowcategory)
    {
        //
    }

    public function edit(Cashflowcategory $cashflowcategory)
    {
        return view('cashflow.category.edit', [
            'cashflowcategory' => $cashflowcategory
        ]);
    }

    public function update(Request $request, Cashflowcategory $cashflowcategory)
    {
        $rules = [
            'cashflowtype_id' => 'required|integer',
            'name' => 'required|string',
        ];

        $validatedData = $request->validate($rules);

        CashflowCategory::where('id', $cashflowcategory->id)->update($validatedData);

        return Redirect::route('cashflowcategory.index')->with('success', 'Category has been updated!');
    }

    public function destroy(Cashflowcategory $cashflowcategory)
    {
        CashflowCategory::destroy($cashflowcategory->id);

        return Redirect::route('cashflowcategory.index')->with('success', 'Category has been deleted!');
    }
}
