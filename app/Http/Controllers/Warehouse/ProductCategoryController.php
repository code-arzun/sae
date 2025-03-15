<?php

namespace App\Http\Controllers\Warehouse;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductUnit;
use Illuminate\Support\Facades\Redirect;

class ProductCategoryController extends Controller
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

        return view('warehouse.products.category.index', [
            'categories' => ProductCategory::with(['productunit'])
                ->filter(request(['search']))->sortable()->paginate($row)->appends(request()->query()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warehouse.products.category.create', [
            'units' => ProductUnit::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:categories,name',
            'productunit_id' => 'required|integer'
        ];

        $validatedData = $request->validate($rules);

        ProductCategory::create($validatedData);

        return Redirect::route('productcategory.index')->with('success', 'Category has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productcategory)
    {
        return view('warehouse.products.category.edit', [
            'category' => $productcategory,
            'units' => ProductUnit::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productcategory)
    {
        $rules = [
            'name' => 'required|unique:categories,name,'.$productcategory->id,
            'productunit_id' => 'required|integer'
        ];

        $validatedData = $request->validate($rules);

        ProductCategory::where('id', $productcategory->id)->update($validatedData);

        return Redirect::route('productcategory.index')->with('success', 'Category has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productcategory)
    {
        ProductCategory::destroy($productcategory->id);

        return Redirect::route('productcategory.index')->with('success', 'Category has been deleted!');
    }
}
