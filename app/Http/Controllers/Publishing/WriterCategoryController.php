<?php

namespace App\Http\Controllers\Publishing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Models\WriterCategory;

class WriterCategoryController extends Controller
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

        return view('publishing.writer.category.index', [
            'writercategories' => WriterCategory::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('publishing.writer.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nama' => 'required|string',
        ];

        $validatedData = $request->validate($rules);

        WriterCategory::create($validatedData);

        // return Redirect::route('writercategory.index')->with('success', 'Type has been created!');
        return back()->with('created', 'Kategori Penulis berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(WriterCategory $writercategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WriterCategory $writercategory)
    {
        return view('publishing.writer.category.edit', [
            'writercategory' => $writercategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WriterCategory $writercategory)
    {
        $rules = [
            'nama' => 'required|string',
        ];

        $validatedData = $request->validate($rules);

        WriterCategory::where('id', $writercategory->id)->update($validatedData);

        return Redirect::route('writercategory.index')->with('success', 'Type has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WriterCategory $writercategory)
    {
        WriterCategory::destroy($writercategory->id);

        return Redirect::route('writercategory.index')->with('success', 'Type has been deleted!');
    }
}
