@if (session()->has('success'))
<div class="alert text-white bg-success" role="alert">
    <div class="iq-alert-text">{{ session('success') }}</div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <i class="ri-close-line"></i>
    </button>
</div>
@endif

    <div class="row align-items-top">
        <div class="col-sm-2 mb-3">
            <img src="{{ $user->photo ? asset('storage/profile/'.$user->photo) : asset('assets/images/user/1.png') }}" class="img-fluid rounded avatar-150" alt="profile-image">
        </div>
        <div class="col-md">
            <h3 class="mb-3">{{  auth()->user()->employee->name }}</h3>
            <span class="badge bg-warning">{{  auth()->user()->employee->position->name }}</span>
            <span class="badge bg-success">{{  auth()->user()->employee->department->name }}</span>
        </div>
        <div class="col-md-12" aria-colspan="2">
            <label for="address">Alamat</label>
            <textarea type="text" aria-colspan="3" class="form-control bg-white" id="address" value="}" readonly>{{  auth()->user()->employee->address }}</textarea>
        </div>
        <div class="col-md-6">
            <label for="phone">Telp.</label>
            <input type="text" class="form-control bg-white" id="phone" value="{{  auth()->user()->employee->phone }}" readonly>
        </div>
        <div class="col-md-6">
            <label for="email">Email</label>
            <input type="text" class="form-control bg-white" id="email" value="{{  auth()->user()->employee->email }}" readonly>
        </div>
        <div class="col-md-6">
            <label for="username">Username</label>
            <input type="text" class="form-control bg-white" id="username" value="{{  auth()->user()->username }}" readonly>
        </div>
        <div class="col-md-6">
            <label for="password">password</label>
            <input type="text" class="form-control bg-white" id="password" value="{{  auth()->user()->password }}" readonly>
        </div>
    </div>
