<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <span class="brand-text font-weight-light" style="margin-left: 30px;">Event Management</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image" style="margin-top: 5px">
          {{-- <img src="adminLTE/dist/img/admin-img.png" class="img-circle elevation-2" alt="User Image"> --}}
          <i class="fa-regular fa-user" style="color:honeydew; margin-left:4px;"></i>
        </div>
        <div class="info" style="margin-left: 30px;">
          <a href="#" class="d-block">{{$fullName}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
              <i class="fa-solid fa-gauge"></i>
              <p style="margin-left: 10px">
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.venues') }}" class="nav-link {{ Request::routeIs('admin.venues') ? 'active' : '' }}">
              <i class="fa-solid fa-clipboard"></i>
              <p style="margin-left: 10px">
                Venue Management
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.events') }}" class="nav-link {{ Request::routeIs('admin.events') ? 'active' : '' }}">
              <i class="fa-regular fa-calendar-days"></i>
              <p style="margin-left: 10px">
                Events
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>