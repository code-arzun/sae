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
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

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

        return redirect(route('bank.index'))->with('success', 'Type has been created!');
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
