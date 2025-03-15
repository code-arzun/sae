@extends('auth.body.main')

@section('container')
<div class="card-body">
    <div class="d-flex justify-content-between align-items-start mb-4">
      <h1>Login</h1>
      <img src="../assets/images/logo.png" alt="img" class="logo">
    </div>
    <form action="{{ route('login') }}" method="POST">
        @csrf
    <div class="form-group mb-4">
      <label class="form-label">Username</label>
      <input class="form-control @error('username') is-invalid @enderror" type="text" name="username" placeholder="Masukkan username" value="{{ old('username') }}" autocomplete="off" required autofocus>
      {{-- @error('username')
        <div class="text-danger">Masukkan Username dengan benar!</div>
      @enderror --}}
    </div>
    <div class="form-group mb-4">
      <label class="form-label">Password</label>
      <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Masukkan password" required>
      {{-- @error('password')
        <div class="text-danger">Masukkan Password dengan benar!</div>
      @enderror --}}
    </div>
    @if ($errors->has('username') || $errors->has('password'))
        <div class="text-danger">Masukkan username dan password dengan benar!</div>
    @endif
    {{-- <div class="d-flex mt-1 justify-content-between">
      <div class="form-check">
        <input class="form-check-input input-primary" type="checkbox" id="customCheckc1">
        <label class="form-check-label text-muted" for="customCheckc1">Keep me sign in</label>
      </div>
    </div> --}}
    <div class="d-grid mt-5">
        <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>
@endsection
