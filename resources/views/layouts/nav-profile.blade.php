@if (Auth::check())
  <li class="dropdown">
    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
      <img alt="image" src="{{ $_profile_picture ? $_profile_picture : '/assets/img/avatar/avatar-1.png' }}"
        class="rounded-circle mr-1">
      <div class="d-sm-none d-lg-inline-block">
        Hi, {{ Auth::user()->name }}
      </div>

    </a>
    <div class="dropdown-menu dropdown-menu-right">
      {{-- <div class="dropdown-title">Logged in 5 min ago</div>
      --}}
      @if (Auth::user()->hasRole(['administrator', 'finance', 'editor', 'editor']))
        <a href="/dashboard" class="dropdown-item has-icon">
          <i class="fas fa-fire"></i> Dashboard
        </a>

      @endif
      <a href="/profile" class="dropdown-item has-icon">
        <i class="fas fa-user"></i> Profile
      </a>
      {{-- <a href="features-activities.html" class="dropdown-item has-icon">
        <i class="fas fa-bolt"></i> Activities
      </a>
      <a href="features-settings.html" class="dropdown-item has-icon">
        <i class="fas fa-cog"></i> Settings
      </a> --}}
      <div class="dropdown-divider"></div>
      <a href="/logout" class="dropdown-item has-icon text-danger">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </div>
  </li>

@else

  <li class="dropdown">
    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
      <img alt="image" src="{{ '/assets/img/avatar/avatar-1.png' }}" class="rounded-circle mr-1">
      <div class="d-sm-none d-lg-inline-block">
        Login / Register
      </div>

    </a>
    <div class="dropdown-menu dropdown-menu-right">
      {{-- <div class="dropdown-title">Logged in 5 min ago</div>
      --}}
      <a href="/register" class="dropdown-item has-icon">
        <i class="fa fa-user"></i> Register
      </a>
      <a href="/login" class="dropdown-item has-icon">
        <i class="fa fa-sign-in-alt"></i> Login
      </a>
      {{-- <a href="features-activities.html" class="dropdown-item has-icon">
        <i class="fas fa-bolt"></i> Activities
      </a>
      <a href="features-settings.html" class="dropdown-item has-icon">
        <i class="fas fa-cog"></i> Settings
      </a> --}}
    </div>
  </li>
@endif
