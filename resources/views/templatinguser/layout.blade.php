<!DOCTYPE html>
<html lang="en">
  <head>
    @include('layouts.head')
  </head>
  <body>
    <div class="wrapper">
      @include('layouts.sidebar')
      @include('layouts.header')
      @yield('content')
      @include('layouts.footer')
    </div>
    @include('layouts.script')
    @stack('scripts')
  </body>
</html>
