@if (session()->has('success'))
<div class="alert text-white bg-success" role="alert">
    <div class="iq-alert-text">{{ session('success') }}</div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <i class="ri-close-line"></i>
    </button>
</div>
@endif

<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
@csrf
@method('put')
    <div class="row align-items-center">
        <div class="d-flex align-items-center mb-3">
            <div class="col-sm-3">
                <img src="{{ $user->photo ? asset('storage/profile/'.$user->photo) : asset('assets/images/user/1.png') }}" class="img-fluid rounded avatar-150" alt="profile-image">
                <div class="custom-file mt-3">
                    <input type="file" class="custom-file-input @error('photo') is-invalid @enderror" id="image" name="photo" accept="image/*" onchange="previewImage();">
                    <label class="custom-file-label" for="photo">Pilih file</label>
                </div>
                @error('photo')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            {{-- <div class="ml-3">
                <h2 class="mb-2">{{  auth()->user()->employee->name }}</h2>
                <h5><span class="badge bg-warning">{{  auth()->user()->employee->position->name }}</span></h5>
                <h5><span class="badge bg-success">{{  auth()->user()->employee->department->name }}</span></h5>
            </div> --}}
        </div>
    </div>
    <div class="row align-items-center">
        <div class="form-group col-md-6">
            <label for="name">Nama</label>
            <input type="text" class="form-control bg-white" id="name" value="{{  auth()->user()->employee->name }}">
        </div>
        <div class="form-group col-md-3">
            <label for="position">Jabatan</label>
            <input type="text" class="form-control bg-white" id="position" value="{{  auth()->user()->employee->position->name }}" readonly>
            {{-- <h5><span class="badge bg-warning">{{  auth()->user()->employee->position->name }}</span></h5> --}}
                
        </div>
        <div class="form-group col-md-3">
            <label for="department">Divisi</label>
            <input type="text" class="form-control bg-white" id="department" value="{{  auth()->user()->employee->department->name }}" readonly>
            {{-- <h5><span class="badge bg-success">{{  auth()->user()->employee->department->name }}</span></h5> --}}
        </div>
        <div class="form-group col-md-12">
            <label for="address">Alamat</label>
            <textarea type="text" aria-colspan="3" class="form-control bg-white" id="address" >{{  auth()->user()->employee->address }}</textarea>
        </div>
        <div class="form-group col-md-6">
            <label for="phone">Telp.</label>
            <input type="tel" class="form-control bg-white" id="phone" value="{{  auth()->user()->employee->phone }}">
        </div>
        <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="text" class="form-control bg-white" id="email" value="{{  auth()->user()->employee->email }}">
        </div>
        <div class="form-group col-md-6">
            <label for="username">Username</label>
            <input type="text" class="form-control bg-white" id="username" value="{{  auth()->user()->username }}">
        </div>
        {{-- <div class="form-group col-md-6">
            <label for="password">password</label>
            <input type="text" class="form-control bg-white" id="password" value="{{  auth()->user()->password }}">
        </div> --}}
        <div class="form-group col-md-6 mt-2">
            <button type="submit" class="btn btn-primary me-2">Simpan</button>
            <a class="btn bg-danger" href="{{ route('profile') }}">Cancel</a>
        </div>
    </form>
    </div>