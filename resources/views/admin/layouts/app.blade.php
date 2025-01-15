     @include('admin.layouts.header')

  <!-- Navbar -->
    @include('admin.layouts.nav-top')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
    @include('admin.layouts.side-nav')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  {{-- footer --}}
    @include('admin.layouts.footer')
