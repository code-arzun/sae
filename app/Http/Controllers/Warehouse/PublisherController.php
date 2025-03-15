<?php

namespace App\Http\Controllers\Warehouse;

use App\Models\Publisher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class PublisherController extends Controller
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

        return view('warehouse.publisher.index', [
            'publishers' => Publisher::filter(request(['search']))->sortable()->paginate($row)->appends(request()->query()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warehouse.publisher.create', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'NamaPenerbit' => 'required|string|max:50',
            'email' => 'nullable|email|max:50|unique:publishers,email',
            'phone' => 'nullable|string|max:15|unique:publishers,phone',
            'address' => 'nullable|string|max:100',
            'photo' => 'image|file|max:1024',
        ];

        $validatedData = $request->validate($rules);

        /**
         * Handle upload image with Storage.
         */
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/publishers/';

            $file->storeAs($path, $fileName);
            $validatedData['photo'] = $fileName;
        }

        Publisher::create($validatedData);

        return Redirect::route('publisher.index')->with('success', 'Publisher has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        return view('warehouse.publisher.show', [
            'publisher' => $publisher,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publisher $publisher)
    {
        return view('warehouse.publisher.edit', [
            'publisher' => $publisher
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        $rules = [
            'NamaPenerbit' => 'required|string|max:50',
            'email' => 'nullable|email|max:50|unique:publishers,email',
            'phone' => 'nullable|string|max:15|unique:publishers,phone',
            'address' => 'nullable|string|max:100',
            'photo' => 'image|file|max:1024',
        ];

        $validatedData = $request->validate($rules);

        /**
         * Handle upload image with Storage.
         */
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/publishers/';

            /**
             * Delete photo if exists.
             */
            if($publisher->photo){
                Storage::delete($path . $publisher->photo);
            }

            $file->storeAs($path, $fileName);
            $validatedData['photo'] = $fileName;
        }

        Publisher::where('id', $publisher->id)->update($validatedData);

        return Redirect::route('publisher.index')->with('success', 'Publisher has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        /**
         * Delete photo if exists.
         */
        if($publisher->photo){
            Storage::delete('public/publishers/' . $publisher->photo);
        }

        Publisher::destroy($publisher->id);

        return Redirect::route('publisher.index')->with('success', 'Publisher has been deleted!');
    }
}
