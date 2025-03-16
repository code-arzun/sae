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
                    <h4 class="mb-3">Database Backup List</h4>
                </div>
                <div>
                    <a href="{{ route('backup.create') }}" class="btn btn-primary add-list"></i>Backup Now</a>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="dt-responsive table-responsive mb-3">
                <table class="table mb-0">
                    <thead>
                        <tr class="ligth ligth-data">
                            <th>No.</th>
                            <th>File Name</th>
                            <th>File Size</th>
                            <th>Path</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        @foreach ($files as $file)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $file->getFileName() }}</td>
                            <td>{{ $file->getSize() }}</td>
                            <td>{{ $file->getPath() }}</td>
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    <a class="btn btn-success me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" title="Download"
                                        href="{{ route('backup.download', $file->getFileName()) }}"><i class="fa-solid fa-download me-0"></i>
                                    </a>
                                    <a class="btn btn-danger me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" title="Delete"
                                        href="{{ route('backup.delete', $file->getFileName()) }}"><i class="fa-solid fa-trash me-0"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection
