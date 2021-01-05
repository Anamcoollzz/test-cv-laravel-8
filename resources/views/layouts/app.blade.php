<!DOCTYPE html>
<html lang="en">

<head>
  @include('layouts.meta')
  @include('layouts.title')

  @include('layouts.css')
</head>

<body>
  <div id="app">
    <div class="main-wrapper">

      @include('layouts.navbar')
      @include('layouts.sidebar')
      @yield('content')
      @include('layouts.footer')
    </div>
  </div>

  @stack('modals')

  @include('layouts.js')

  <!-- Page Specific JS File -->
</body>

</html>
