<?php

namespace App\Http\Controllers\Publishing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Models\WriterJob;

class WriterJobController extends Controller
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

        return view('publishing.writer.job.index', [
            'writerjobs' => WriterJob::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('publishing.writer.job.create');
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

        $writerjob = WriterJob::create($validatedData);

        // return Redirect::route('writerjob.index')->with('success', 'Type has been created!');
        // return back()->with('created', 'Profesi Penulis berhasil ditambahkan!');
        return response()->json([
            'success' => true,
            'data' => $writerjob
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(WriterJob $writerjob)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WriterJob $writerjob)
    {
        return view('publishing.writer.job.edit', [
            'writerjob' => $writerjob
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WriterJob $writerjob)
    {
        $rules = [
            'nama' => 'required|string',
        ];

        $validatedData = $request->validate($rules);

        WriterJob::where('id', $writerjob->id)->update($validatedData);

        return Redirect::route('writerjob.index')->with('success', 'Type has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WriterJob $writerjob)
    {
        WriterJob::destroy($writerjob->id);

        // return Redirect::route('writerjob.index')->with('success', 'Type has been deleted!');
        // return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        return response()->json([
            'success' => true,
            'data' => $writerjob
        ]);
    }
    
}

// {
//     public function index()
//     {
//         $writerjobs = WriterJob::all();
//         return view('publishing.writer.job.index', compact('writerjobs'));
//     }

//     public function create()
//     {
//         return view('publishing.writer.job.create');
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'nama' => 'required|string|max:255',
//         ]);

//         WriterJob::create($request->all());
//         return redirect()->route('writerjob.index');
//     }

//     public function edit($id)
//     {
//         $writerjob = WriterJob::findOrFail($id);
//         return response()->json(['data' => $writerjob]);
//     }

//     public function update(Request $request, $id)
//     {
//         $request->validate([
//             'nama' => 'required|string|max:255',
//         ]);

//         $writerjob = WriterJob::findOrFail($id);
//         $writerjob->update($request->all());
//         return redirect()->route('writerjob.index');
//     }

//     public function destroy($id)
//     {
//         $writerjob = WriterJob::findOrFail($id);
//         $writerjob->delete();
//         return response()->json(['success' => true]);
//     }
// }