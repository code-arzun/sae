<?php

namespace App\Http\Controllers\Cashflow;

use App\Models\CashflowType;
use Illuminate\Http\Request;
use App\Models\CashflowDetail;
use App\Models\CashflowCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class CashflowDetailController extends Controller
{
    public function index()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        return view('cashflow.detail.index', [
            'cashflowdetails' => CashflowDetail::with(['cashflowtype', 'cashflowcategory'])
                ->sortable()
                ->paginate($row)
                ->appends(request()->query()),
        ]);
    }

    public function create()
    {
        return view('cashflow.detail.create', [
            'cashflowtype' => CashflowType::all(),
            'cashflowcategories' => CashflowCategory::all(),
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'cashflowcategory_id' => 'required|integer',
            'name' => 'required|string',
        ];

        $validatedData = $request->validate($rules);

        CashflowDetail::create($validatedData);

        return Redirect::route('cashflowdetail.index')->with('success', 'Detail has been created!');
    }

    public function show(Cashflowdetail $cashflowdetail)
    {
        //
    }

    public function edit(Cashflowdetail $cashflowdetail)
    {
        return view('cashflow.detail.edit', [
            'cashflowcategorys' => CashflowCategory::all(),
            'cashflowdetail' => $cashflowdetail
        ]);
    }

    public function update(Request $request, Cashflowdetail $cashflowdetail)
    {
        $rules = [
            'cashflowcategory_id' => 'required|integer',
            'name' => 'required|string',
        ];

        $validatedData = $request->validate($rules);

        CashflowDetail::where('id', $cashflowdetail->id)->update($validatedData);

        return Redirect::route('cashflowdetail.index')->with('success', 'Detail has been updated!');
    }

    public function destroy(Cashflowdetail $cashflowdetail)
    {
        CashflowDetail::destroy($cashflowdetail->id);

        return Redirect::route('cashflowdetail.index')->with('success', 'Detail has been deleted!');
    }
}
