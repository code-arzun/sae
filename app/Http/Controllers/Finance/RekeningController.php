<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Models\Rekening;
use App\Models\Bank;

class RekeningController extends Controller
{
    public function index()
    {
        return view('finance.rekening.index', [
            'rekenings' => Rekening::with(['bank'])->sortable()
                ->paginate()->appends(request()->query()),
            'banks' => Bank::all(),
            'title' => 'Rekening',
        ]);
    }

    public function create()
    {
        return view('finance.rekening.create', [
            'banks' => Bank::all(),
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'bank_id' => 'required|integer',
            'no_rek' => 'required|string',
            'nama' => 'required|string',
        ];

        $validatedData = $request->validate($rules);

        Rekening::create($validatedData);

        return back()->with('success', 'Data Rekening berhasil ditambahkan!');
    }

    public function show(Rekening $rekening)
    {
        //
    }

    public function edit(Rekening $rekening)
    {
        return view('finance.rekening.edit', [
            'rekening' => $rekening
        ]);
    }

    public function update(Request $request, Rekening $rekening)
    {
        $rules = [
            'bank_id' => 'required|integer',
            'no_rek' => 'required|string',
            'nama' => 'required|string',
        ];

        $validatedData = $request->validate($rules);

        Rekening::where('id', $rekening->id)->update($validatedData);

        return Redirect::route('rekening.index')->with('success', 'Category has been updated!');
    }

    public function destroy(Rekening $rekening)
    {
        Rekening::destroy($rekening->id);

        return Redirect::route('rekening.index')->with('success', 'Category has been deleted!');
    }
}
