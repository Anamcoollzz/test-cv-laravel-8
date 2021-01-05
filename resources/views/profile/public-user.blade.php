@extends('layouts.app-top-nav')

@section('title')
  Profile
@endsection

@section('content')
  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Profile</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
          <div class="breadcrumb-item">Profile</div>
        </div>
      </div>
      @if (session('success_message'))
        <div class="alert alert-success">{{ session('success_message') }}</div>
      @endif
      <div class="section-body">
        <h2 class="section-title">Hi, {{ $user->name }}!</h2>
        <p class="section-lead">
          Change information about yourself on this page.
        </p>

        <div class="row mt-sm-4">
          <div class="col-12 col-md-12 col-lg-5">
            <div class="card profile-widget">
              <div class="profile-widget-header">
                <img alt="{{ $user->name }}"
                  src="{{ $profilePicture ? $profilePicture : '/assets/img/avatar/avatar-1.png' }}"
                  class="rounded-circle profile-widget-picture">
                <div class="profile-widget-items">
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">Posts</div>
                    <div class="profile-widget-item-value">187</div>
                  </div>
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">Followers</div>
                    <div class="profile-widget-item-value">6,8K</div>
                  </div>
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">Following</div>
                    <div class="profile-widget-item-value">2,1K</div>
                  </div>
                </div>
              </div>
              <div class="profile-widget-description">
                <div class="profile-widget-name">{{ $user->name }}
                  <div class="text-muted d-inline font-weight-normal">
                    <div class="slash"></div> Web Developer
                  </div>
                </div>
                {{ $user->name }} adalah seorang web developer asal Indonesia. Dia menggeluti dunia pengembangan
                web sejak tahun 2016. Karya-karya atau portofolio yang pernah dibuat meliputi
                <ol>
                  <li><a href="https://aksiberbagi.com" target="_blank">aksiberbagi.com</a> sebuah website donasi ternama
                    di
                    Indonesia</li>
                  <li><a href="https://aksiberbagi.org" target="_blank">aksiberbagi.og</a> sebuah website donasi ternama
                    di
                    Indonesia (berbeda tampilan dan payment)
                  </li>
                  <li><a href="https://nusalink.asia" target="_blank">nusalink.asia</a> sebuah website booking properti di
                    Indonesia
                  </li>
                  <li><a href="https://bajaga.online" target="_blank">bajaga.online</a> sebuah website e-commerce
                    multiseller di
                    Indonesia
                  </li>
                  <li><a href="https://bantukerja.com" target="_blank">bantukerja.com</a> sebuah website freelancer dan
                    study untuk murid SMK/SMA di
                    Indonesia
                  </li>
                  <li><a href="https://hrms.nururrohmah.com/" target="_blank">hrms.nururrohmah.com</a> sebuah website
                    untuk penghitungan gaji pegawai
                  </li>
                  <li><a href="https://sipad.nururrohmah.com/" target="_blank">sipad.nururrohmah.com</a> sebuah website
                    untuk arsip dan dokumen
                  </li>
                </ol>
              </div>
              <div class="card-footer text-center">
                <div class="font-weight-bold mb-2">Follow {{ $user->name }}</div>
                <a target="_blank" href="https://facebook.com/hairul.anam.3591"
                  class="btn btn-social-icon btn-facebook mr-1">
                  <i class="fab fa-facebook-f"></i>
                </a>
                <a target="_blank" href="https://twitter.com/hr_anam" class="btn btn-social-icon btn-twitter mr-1">
                  <i class="fab fa-twitter"></i>
                </a>
                <a target="_blank" href="https://github.com/Anamcoollzz" class="btn btn-social-icon btn-github mr-1">
                  <i class="fab fa-github"></i>
                </a>
                <a target="_blank" href="https://instagram.com/hr.anam" class="btn btn-social-icon btn-instagram">
                  <i class="fab fa-instagram"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-12 col-lg-7">
            <div class="card">
              <form method="post" class="needs-validation" novalidate="" action="" enctype="multipart/form-data">
                @csrf
                <div class="card-header">
                  <h4>Edit Profile</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-6 col-12">
                      <label>Name <span class="text-danger">*</span></label>
                      <input value="{{ old('name', $user->name) }}" required type="text"
                        class="form-control  @error('name') is-invalid @enderror" name="name" id="name">
                      @error('name')
                        <span class="invalid-feedback" id="nameInvalidFeedback">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group col-md-6 col-12">
                      <label>Email <span class="text-danger">*</span></label>
                      <input value="{{ old('email', $user->email) }}" required type="email"
                        class="form-control  @error('email') is-invalid @enderror" name="email" id="email">
                      @error('email')
                        <span class="invalid-feedback" id="emailInvalidFeedback">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group col-md-6 col-12">
                      <label>Phone Number </label>
                      <input value="{{ old('phone_number', $user->phone_number) }}" type="text"
                        class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                        id="phone_number">
                      @error('phone_number')
                        <span class="invalid-feedback" id="phone_numberInvalidFeedback">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group col-md-6 col-12">
                      <label>Profile Picture </label>
                      <input type="file" accept="image/*"
                        class="form-control @error('profile_picture') is-invalid @enderror" name="profile_picture"
                        id="profile_picture">
                      @error('profile_picture')
                        <span class="invalid-feedback" id="profile_pictureInvalidFeedback">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group col-md-6 col-12">
                      <label>Address</label>
                      <textarea class="form-control @error('address') is-invalid @enderror" name="address"
                        id="address">{{ old('address', $user->address) }}</textarea>
                      @error('address')
                        <span class="invalid-feedback" id="addressInvalidFeedback">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  {{-- <div class="row">
                    <div class="form-group mb-0 col-12">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" id="newsletter">
                        <label class="custom-control-label" for="newsletter">Subscribe to newsletter</label>
                        <div class="text-muted form-text">
                          You will get new information about products, offers and promotions
                        </div>
                      </div>
                    </div>
                  </div> --}}
                </div>
                <div class="card-footer text-right">
                  <button class="btn btn-primary">Save Changes</button>
                </div>
              </form>
            </div>
            <div class="card">
              <form method="post" class="needs-validation" novalidate="" action="/profile/password">
                @csrf
                <div class="card-header">
                  <h4>Edit Password</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-6 col-12">
                      <label>Password <span class="text-danger">*</span></label>
                      <input required type="password" class="form-control  @error('password') is-invalid @enderror"
                        name="password" id="password">
                      @error('password')
                        <span class="invalid-feedback" id="passwordInvalidFeedback">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group col-md-6 col-12">
                      <label>Password Confirmation <span class="text-danger">*</span></label>
                      <input required type="password"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        name="password_confirmation" id="password_confirmation">
                      @error('password_confirmation')
                        <span class="invalid-feedback" id="password_confirmationInvalidFeedback">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button class="btn btn-primary">Save Changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection

@push('css')
  <link rel="stylesheet" href="/plugins/bootstrap-social/bootstrap-social.css">
@endpush
