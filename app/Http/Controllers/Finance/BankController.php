<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Models\Bank;

class BankController extends Controller
{
    public function index()
    {
        return view('finance.bank.index', [
            'banks' => Bank::all()
        ]);
    }

    public function create()
    {
        return view('finance.bank.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
        ];

        $validatedData = $request->validate($rules);

        Bank::create($validatedData);

        return back()->with('success', 'Data Bank berhasil ditambahkan!');
    }

    public function show(Bank $bank)
    {
        //
    }

    public function edit(Bank $bank)
    {
        return view('finance.bank.edit', [
            'bank' => $bank
        ]);
    }

    public function update(Request $request, Bank $bank)
    {
        $rules = [
            'name' => 'required|string',
        ];

        $validatedData = $request->validate($rules);

        Bank::where('id', $bank->id)->update($validatedData);

        return Redirect::route('bank.index')->with('success', 'Bank berhasil diperbarui!');
    }

    public function destroy(Bank $bank)
    {
        Bank::destroy($bank->id);

        return Redirect::route('bank.index')->with('success', 'Bank berhasil dihapus!');
    }
}
