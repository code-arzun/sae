<?php

namespace App\Http\Controllers\Cashflow;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Models\CashflowType;

class CashflowTypeController extends Controller
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

        return view('cashflow.type.index', [
            'cashflowtypes' => CashflowType::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cashflow.type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
        ];

        $validatedData = $request->validate($rules);

        CashflowType::create($validatedData);

        return Redirect::route('cashflowtype.index')->with('success', 'Type has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cashflowtype $cashflowtype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cashflowtype $cashflowtype)
    {
        return view('cashflow.type.edit', [
            'cashflowtype' => $cashflowtype
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cashflowtype $cashflowtype)
    {
        $rules = [
            'name' => 'required|string',
        ];

        $validatedData = $request->validate($rules);

        CashflowType::where('id', $cashflowtype->id)->update($validatedData);

        return Redirect::route('cashflowtype.index')->with('success', 'Type has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cashflowtype $cashflowtype)
    {
        CashflowType::destroy($cashflowtype->id);

        return Redirect::route('cashflow.type.index')->with('success', 'Type has been deleted!');
    }
}
