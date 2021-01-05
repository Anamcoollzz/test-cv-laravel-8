@extends('layouts.app-blank')

@section('title')
  Register
@endsection

@section('content')
  <section class="section">
    <div class="container mt-5">
      <div class="row">
        <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
          <div class="login-brand">
            <img src="/assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
          </div>

          <div class="card card-primary">
            <div class="card-header">
              <h4>Register</h4>
            </div>

            <div class="card-body">
              <form method="POST" action="">
                @csrf
                <div class="row">
                  <div class="form-group col-6">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input autocomplete="name" required value="{{ old('name') }}" id="name" type="text"
                      class="form-control @error('name') is-invalid @enderror" name="name" autofocus>
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-group col-6">
                    <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
                    <input required value="{{ old('phone_number') }}" id="phone_number" type="text"
                      class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" autofocus>
                    @error('phone_number') <span class="invalid-feedback">{{ $message }}</span> @enderror
                  </div>
                </div>

                <div class="form-group">
                  <label for="email">Email <span class="text-danger">*</span></label>
                  <input autocomplete="email" required value="{{ old('email') }}" id="email" type="email"
                    class="form-control @error('email') is-invalid @enderror" name="email">
                  @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                  <label for="address">Address <span class="text-danger">*</span></label>
                  <textarea id="address" class="form-control @error('address') is-invalid @enderror"
                    name="address">{{ old('address') }}</textarea>
                  @error('address') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="row">
                  <div class="form-group col-6">
                    <label for="password" class="d-block">Password <span class="text-danger">*</span></label>
                    <input autocomplete="new-password" required id="password" type="password"
                      class="form-control pwstrength @error('password') is-invalid @enderror" data-indicator="pwindicator"
                      name="password">
                    @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-group col-6">
                    <label for="password_confirmation" class="d-block">Password Confirmation <span
                        class="text-danger">*</span></label>
                    <input autocomplete="new-password" required id="password_confirmation" type="password"
                      class="form-control @error('password_confirmation') is-invalid @enderror"
                      name="password_confirmation">
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                  </div>
                </div>


                <div class="form-group">
                  <div class="custom-control custom-checkbox">
                    <input required type="checkbox" name="agree" class="custom-control-input" id="agree">
                    <label class="custom-control-label" for="agree">I agree with the terms and conditions</label>
                  </div>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-lg btn-block">
                    Register
                  </button>
                </div>
              </form>
            </div>
          </div>
          <div class="simple-footer">
            Copyright &copy; {{ config('app.name') }} 2021
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
