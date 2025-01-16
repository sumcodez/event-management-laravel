<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset ('adminLTE/plugins/fontawesome-free/css/all.min.css') }}>
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset ('adminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset ('adminLTE/dist/css/adminlte.min.css') }}">

  <style>
    /* Toast message styles */
    .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #F44336; /* Red for error */
        color: white;
        padding: 15px;
        border-radius: 5px;
        font-size: 1rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
        z-index: 9999;
    }

    .toast.success {
        background-color: #4CAF50; /* Green for success */
    }

    .toast.show {
        opacity: 1;
    }
    
</style>

</head>
<body class="hold-transition login-page">

        <!-- Display success message -->
        @if(session('success'))
        <div id="success-toast" class="toast success">
            {{ session('success') }}
        </div>
        @endif
    
        <!-- Display validation errors -->
        @if ($errors->any())
            <div id="error-toast" class="toast">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Event</b>Management</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to access your dashboard</p>

      <form action="{{ route('admin.login.submit') }}" method="post">
        @csrf <!-- CSRF token -->
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4" style="margin-left: 110px;">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
        </div>
     </form>
    

      {{-- <p class="mb-0" style="margin-left: 70px;">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> --}}
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset ('adminLTE/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset ('adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset ('adminLTE/dist/js/adminlte.min.js') }}"></script>

<script>
  // Show toast message for success
  @if(session('success'))
      document.addEventListener("DOMContentLoaded", function() {
          const successToast = document.getElementById('success-toast');
          successToast.classList.add('show');

          // Hide the success toast message after 5 seconds
          setTimeout(function() {
              successToast.classList.remove('show');
          }, 5000);
      });
  @endif

  // Show toast message for validation errors
  @if ($errors->any())
      document.addEventListener("DOMContentLoaded", function() {
          const errorToast = document.getElementById('error-toast');
          errorToast.classList.add('show');

          // Hide the error toast message after 5 seconds
          setTimeout(function() {
              errorToast.classList.remove('show');
          }, 5000);
      });
  @endif
</script>

</body>
</html>
