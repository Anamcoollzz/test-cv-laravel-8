<!DOCTYPE html>
<html lang="en">

<head>
  @include('layouts.meta')
  @include('layouts.title')

  @include('layouts.css')
</head>

<body>
  <div id="app">
    @yield('content')
  </div>

  @include('layouts.js')
</body>

</html>
