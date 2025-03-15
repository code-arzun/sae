<?php

namespace App\Http\Controllers\Warehouse;

use App\Models\ProductUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ProductUnitController extends Controller
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

        return view('warehouse.products.unit.index', [
            'productunits' => ProductUnit::filter(request(['search']))
                ->sortable()->paginate($row)->appends(request()->query()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warehouse.products.unit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:unit,name',
        ];

        $validatedData = $request->validate($rules);

        ProductUnit::create($validatedData);

        return Redirect::route('units.index')->with('success', 'Unit has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductUnit $productunit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductUnit $productunit)
    {
        return view('warehouse.products.unit.edit', [
            'productunit' => $productunit
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductUnit $productunit)
    {
        $rules = [
            'name' => 'required|unique:unit,name',
        ];

        $validatedData = $request->validate($rules);

        ProductUnit::where('id', $productunit->id)->update($validatedData);

        return Redirect::route('unit.index')->with('success', 'Unit has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductUnit $productunit)
    {
        ProductUnit::destroy($productunit->id);

        return Redirect::route('unit.index')->with('success', 'Unit has been deleted!');
    }
}
