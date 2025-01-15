<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Registered Events</title>
  <link rel="stylesheet" href="{{ asset('users_styles/style.css') }}">
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar" id="myTopnav">
    <div class="logo"><a href="{{ route('events.all') }}">Events Dashboard</a></div>
    <ul class="nav-links" id="top-nav">
      <li><a href="{{ route('events.my-registrations') }}">My Registrations</a></li>
      <li class="dropdown">
        <a href="javascript:void(0)" class="dropbtn">Profile</a>
        <div class="dropdown-content">
          <a href="{{ route('profile.manage') }}">Manage</a>
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
    <a href="javascript:void(0);" class="menu-toggle" onclick="myFunction()">
      <i class="fa fa-bars"></i>
    </a>
  </nav>

  <div class="registered-events">
    <h1>Registered Events</h1>

    @if($registeredEvents->isEmpty())
      <p>You have not registered for any events yet.</p>
    @else
      <ul class="event-list">
        @foreach($registeredEvents as $event)
          <li class="event-item">
            <h2>{{ $event->title }}</h2>
            <p><strong>Venue:</strong> {{ $event->venue_title }}</p>
            <p><strong>Location:</strong> {{ $event->venue_location }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}</p>
            <p><strong>Description:</strong> {{ $event->description }}</p>
        @endforeach
      </ul>
    @endif
  </div>

  <script>
    function myFunction() {
      var x = document.getElementById("myTopnav");
      if (x.className === "navbar") {
        x.className += " responsive";
      } else {
        x.className = "navbar";
      }
    }
  </script>
</body>
</html>
