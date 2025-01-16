<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Management</title>
  <link rel="stylesheet" href="{{ asset('users_styles/style.css') }}">

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
    }

    .toast.success {
        background-color: #4CAF50; /* Green for success */
    }

    .toast.show {
        opacity: 1;
    }
    
  </style>

</head>
<body>

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


  <!-- Navigation Bar -->
  <nav class="navbar" id="myTopnav">
    <div class="logo"><a href="href="{{ route('events.all') }}">Events Dashboard</a></div>
      <ul class="nav-links" id="top-nav">
        <li><a href="{{ route('events.my-registrations') }}">My Registrations</a></li>
        <li class="dropdown">
          <a href="javascript:void(0)" class="dropbtn">Profile</a>
          <div class="dropdown-content">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <x-dropdown-link :href="route('logout')"
                  onclick="event.preventDefault();
                              this.closest('form').submit();">
                  {{ __('Log Out') }}
              </x-dropdown-link>
            </form>
          </div>
        </li>
      </ul>
    {{-- <div class="menu-toggle" onclick="toggleMenu()"><i class="fa fa-bars"></i></div> --}}
    <a href="javascript:void(0);" class="menu-toggle" onclick="myFunction()">
      <i class="fa fa-bars"></i>
    </a>
  </nav>

  <div class="event-details">
    <h1>{{ $event->title }}</h1>
    <p><strong>Venue:</strong> {{ $venue->title }}</p>
    <p><strong>Location:</strong> {{ $venue->location }}</p>
    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}</p>
    <p><strong>Description:</strong> {{ $event->description }}</p>
    <p><strong>Venue Capacity:</strong> {{ $venue->capacity }}</p>
    <p>
      <strong>Status:</strong> 
      @if($venue->capacity > 0)
        <span class="status-available">Available</span>
      @else
        <span class="status-unavailable">Unavailable</span>
      @endif
    </p>

    @if(session('success'))
      <p class="flash-message">{{ session('success') }}</p>
    @endif

    @if($isRegistered)
      <p class="already-registered">You are already registered for this event.</p>
    @elseif($venue->capacity > 0)
      <form action="{{ route('events.register', $event->id) }}" method="POST">
          @csrf
          <button type="submit" class="register-button">Register</button>
      </form>
    @endif
  </div>


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
