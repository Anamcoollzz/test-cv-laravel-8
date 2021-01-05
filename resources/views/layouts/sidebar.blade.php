<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.html">Test CV</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.html">TC</a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li class="@yield('dashboard')"><a class="nav-link" href="/dashboard"><i class="fas fa-fire"></i>
          <span>Dashboard</span></a>
      <li class="menu-header">Module</li>
      @if (Auth::user()->hasRole(['editor', 'administrator']))
        <li class="@yield('blog')"><a class="nav-link" href="/blog"><i class="fas fa-edit"></i> <span>Blog</span></a>
      @endif

      @if (Auth::user()->hasRole(['administrator', 'finance']))
        <li class="nav-item dropdown @yield('income') @yield('expense')">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-money-bill"></i>
            <span>Accounting</span></a>
          <ul class="dropdown-menu">
            <li class="@yield('income')"><a class="nav-link" href="/income">Income</a></li>
            <li class="@yield('expense')"><a class="nav-link" href="/expense">Expense</a></li>
          </ul>
        </li>
      @endif
      @if (Auth::user()->hasRole('administrator'))
        <li class="nav-item dropdown @yield('internal-user') @yield('public-user')">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i>
            <span>User Management</span></a>
          <ul class="dropdown-menu">
            <li class="@yield('internal-user')"><a class="nav-link" href="/internal-user">Internal User</a></li>
            <li class="@yield('public-user')"><a class="nav-link" href="/public-user">Public User</a></li>
          </ul>
        </li>
      @endif
      <li><a class="nav-link" href="/logout"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
      </li>
    </ul>

    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
      <a href="/profile" class="btn btn-primary btn-lg btn-block btn-icon-split">
        <i class="fas fa-user"></i> {{ Auth::user()->roles[0]['name'] }}
      </a>
    </div>
  </aside>
</div>
