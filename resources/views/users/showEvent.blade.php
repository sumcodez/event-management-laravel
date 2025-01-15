<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Management</title>
  <link rel="stylesheet" href="{{ asset('users_styles/style.css') }}">
</head>
<body>
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
</body>
</html>
