@extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            @if (session()->has('success'))
                <div class="alert text-white bg-success" role="alert">
                    <div class="iq-alert-text">{{ session('success') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Publisher List</h4>
                    <p class="mb-0">A publisher dashboard lets you easily gather and visualize publisher data from optimizing <br>
                        the publisher experience, ensuring publisher retention. </p>
                </div>
                <div>
                    <a href="{{ route('publisher.create') }}" class="btn btn-primary add-list"><i class="fa-solid fa-plus me-3"></i>Add Publisher</a>
                    <a href="{{ route('publisher.index') }}" class="btn btn-danger add-list"><i class="fa-solid fa-trash me-3"></i>Clear Search</a>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <form action="{{ route('publisher.index') }}" method="get">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="form-group row">
                        <label for="row" class="col-sm-3 align-self-center">Row:</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="row">
                                <option value="10" @if(request('row') == '10')selected="selected"@endif>10</option>
                                <option value="25" @if(request('row') == '25')selected="selected"@endif>25</option>
                                <option value="50" @if(request('row') == '50')selected="selected"@endif>50</option>
                                <option value="100" @if(request('row') == '100')selected="selected"@endif>100</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-3 align-self-center" for="search">Search:</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" id="search" class="form-control" name="search" placeholder="Search publisher" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="input-group-text bg-primary"><i class="fa-solid fa-magnifying-glass font-size-20"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-12">
            <div class="dt-responsive table-responsive mb-3">
                <table class="table mb-0">
                    <thead>
                        <tr class="ligth ligth-data">
                            <th>No.</th>
                            <th>Photo</th>
                            <th>@sortablelink('name')</th>
                            <th>@sortablelink('email')</th>
                            <th>@sortablelink('phone')</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        @foreach ($publishers as $publisher)
                        <tr>
                            <td>{{ (($publishers->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>
                                <img class="avatar-60 rounded" src="{{ $publisher->photo ? asset('storage/publishers/'.$publisher->photo) : asset('assets/images/user/1.png') }}">
                            </td>
                            <td>{{ $publisher->NamaPenerbit }}</td>
                            <td>{{ $publisher->email }}</td>
                            <td>{{ $publisher->phone }}</td>
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    <a class="badge badge-primary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="View"
                                        href="{{ route('publisher.show', $publisher->id) }}"><i class="ri-eye-line me-0"></i>
                                    </a>
                                    <a class="badge bg-warning me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Edit"
                                        href="{{ route('publisher.edit', $publisher->id) }}"><i class="ri-pencil-line me-0"></i>
                                    </a>
                                    <form action="{{ route('publisher.destroy', $publisher->id) }}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="badge bg-danger me-2 border-none" onclick="return confirm('Are you sure you want to delete this record?')" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Delete"><i class="ri-delete-bin-line me-0"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $publishers->links() }}
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection
