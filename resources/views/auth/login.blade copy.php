@extends('auth.body.main')

@section('container')
<div class="row align-items-center justify-content-center height-self-center">
    <div class="col-lg-8">
        <div class="card auth-card">
            <div class="card-body p-0">
                <div class="d-flex align-items-center auth-content">
                    <div class="col-lg-7 align-self-center">
                        <div class="p-3">
                            <h1 class="mb-4">Log In</h1>
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="floating-label form-group">
                                            <input class="floating-input form-control @error('email') is-invalid @enderror @error('username') is-invalid @enderror" type="text" name="input_type" placeholder=" " value="{{ old('input_type') }}" autocomplete="off" required autofocus>
                                            <label>Email/Username</label>
                                        </div>
                                        @error('username')
                                        <div class="mb-4" style="margin-top: -20px">
                                            <div class="text-danger small">Masukkan Username dengan benar!</div>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="floating-label form-group">
                                            <input class="floating-input form-control @error('email') is-invalid @enderror @error('username') is-invalid @enderror" type="password" name="password" placeholder=" " required>
                                            <label>Password</label>
                                            @error('password')
                                        <div class="mb-4" style="margin-top: -20px">
                                            <div class="text-danger small">Masukkan Password dengan benar!</div>
                                        </div>
                                        @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-6">
                                        <p>
                                            Not a Member yet? <a href="{{ route('register') }}" class="text-primary">Register</a>
                                        </p>
                                    </div> --}}
                                    {{-- <div class="col-lg-6">
                                        <a href="#" class="text-primary float-right">Forgot Password?</a>
                                    </div> --}}
                                </div>
                                <button type="submit" class="btn btn-primary">Login</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-5 content-right">
                        <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid image-right" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

    {{-- <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                  </div>
                  <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input class="floating-input form-control @error('email') is-invalid @enderror @error('username') is-invalid @enderror" type="text" name="input_type" placeholder=" " value="{{ old('input_type') }}" autocomplete="off" required autofocus>>
                    </div>
                    <div class="form-group">
                        <input class="floating-input form-control @error('email') is-invalid @enderror @error('username') is-invalid @enderror" type="password" name="password" placeholder=" " required>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember
                          Me</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <a href="index.html" class="btn btn-primary btn-block">Login</a>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}
