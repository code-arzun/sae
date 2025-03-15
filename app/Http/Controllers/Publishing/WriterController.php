<?php

namespace App\Http\Controllers\Publishing;

use App\Models\Writer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Employee;
use App\Models\WriterCategory;
use App\Models\WriterJob;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;


class WriterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $row = (int) request('row', 10);
        $writerJobFilter = request('writerjob_id', null);
        $writerCategoryFilter = request('writercategory_id', null);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        $writerQuery = Writer::query();
        $writerjobs = Writer::select('writerjob_id')->distinct()->get();
        $writercategories = Writer::select('writercategory_id')->distinct()->get();
        // $writerJobs = WriterJob::query();

        if ($writerJobFilter)  {
            $writerQuery->where('writerjob_id', $writerJobFilter);
        }

        if ($writerCategoryFilter)  {
            $writerQuery->where('writercategory_id', $writerCategoryFilter);
        }

        return view('publishing.writer.index', [
            // 'writers' => Writer::with('writercategory', 'writerjob')->filter(request(['search']))->sortable()->paginate($row)->appends(request()->query()),
            'writers' => $writerQuery->with('writercategory', 'writerjob')->filter(request(['search']))->sortable()->paginate($row)->appends(request()->query()),
            'writerjobs' => $writerjobs,
            'writercategories' => $writercategories,
            // 'writerjobs' => WriterJob::get(),
            // 'writercategories' => WriterCategory::get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('publishing.writer.create', [
            'employees' => Employee::where('department_id', '1')->get(),
            'writerjobs' => WriterJob::get(),
            'writercategories' => WriterCategory::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $sales = Employee::where('id')->first();
        $rules = [
            'NamaPenulis' => 'required|string|max:100',
            'AlamatPenulis' => 'nullable|string|max:500',
            'TelpPenulis' => 'nullable|string|min:7|max:12',
            'EmailPenulis' => 'nullable|email|max:50',
            'CatatanLembaga' => 'nullable|max:500',
            'NIK' => 'nullable|integer',
            'NPWP' => 'nullable|integer',
            'writerjob_id' => 'nullable|integer',
            'writercategory_id' => 'nullable|integer',
            // 'employee_id' => 'required|integer',
            'FotoPenulis' => 'image|file|max:1024',
            'FotoKTP' => 'image|file|max:1024',
        ];

        $validatedData = $request->validate($rules);

        /**
         * Handle upload image with Storage.
         */
        if ($file = $request->file('FotoPenulis')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/publishing/writer/foto/';

            $file->storeAs($path, $fileName);
            $validatedData['FotoPenulis'] = $fileName;
        }
        if ($file = $request->file('FotoKTP')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/publishing/writer/KTP/';

            $file->storeAs($path, $fileName);
            $validatedData['FotoKTP'] = $fileName;
        }

        Writer::create($validatedData);

        return Redirect::route('writer.index')->with('create', 'Data Penulis berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Writer $writer)
    {
        return view('publishing.writer.show', [
            'writer' => $writer,
            'employees' => Employee::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Writer $writer)
    {
        return view('publishing.writer.edit', [
            'writer' => $writer,
            'employees' => Employee::where('department_id', '1')->get(),
            'writerjobs' => WriterJob::get(),
            'writercategories' => WriterCategory::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Writer $writer)
    {
        // $sales = Employee::where('id')->first();
        $rules = [
            'NamaPenulis' => 'required|string|max:100',
            'AlamatPenulis' => 'nullable|string|max:500',
            'TelpPenulis' => 'nullable|string|min:7|max:12',
            'EmailPenulis' => 'nullable|email|max:50',
            'CatatanLembaga' => 'nullable|max:500',
            'NIK' => 'nullable|integer',
            'NPWP' => 'nullable|integer',
            'writerjob_id' => 'nullable|integer',
            'writercategory_id' => 'nullable|integer',
            // 'employee_id' => 'required|integer',
            'FotoPenulis' => 'image|file|max:1024',
            'FotoKTP' => 'image|file|max:1024',
        ];

        $validatedData = $request->validate($rules);

        /**
         * Handle upload image with Storage.
         */
        if ($file = $request->file('FotoPenulis')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/publishing/writer/foto/';

            /**
             * Delete photo if exists.
             */
            if($writer->FotoPenulis){
                Storage::delete($path . $writer->FotoPenulis);
            }

            $file->storeAs($path, $fileName);
            $validatedData['FotoPenulis'] = $fileName;
        }

        Writer::where('id', $writer->id)->update($validatedData);

        return Redirect::route('writer.index')->with('create', 'Data Penulis berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Writer $writer)
    {
        /**
         * Delete photo if exists.
         */
        if($writer->FotoPenulis){
            Storage::delete('public/publishing/writer/foto/' . $writer->FotoCustomer);
        }
        if($writer->FotoKTP){
            Storage::delete('public/publishing/writer/KTP/' . $writer->FotoCustomer);
        }

        Writer::destroy($writer->id);

        return Redirect::route('writer.index')->with('success', 'Customer has been deleted!');
    }

}
