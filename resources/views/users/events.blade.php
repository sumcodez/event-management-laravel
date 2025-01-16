<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Management</title>
  <link rel="stylesheet" href="{{ asset('users_styles/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
    {{-- <div class="menu-toggle" onclick="toggleMenu()"><i class="fa fa-bars"></i></div> --}}
    <a href="javascript:void(0);" class="menu-toggle" onclick="myFunction()">
      <i class="fa fa-bars"></i>
    </a>
  </nav>

  <!-- Main Content -->
  <div class="main">
    <!-- Filters Section -->
    <aside class="filters">
      <h2>Search Filters</h2>
        <form method="GET" action="{{ route('events.all') }}">
            <label for="venue">Search By Venue</label>
            <select name="venue" id="venue">
            <option value="">Select Venues</option>
            @foreach($venues as $venue)
                <option value="{{ $venue->id }}" {{ $venue->id == $venueFilter ? 'selected' : '' }}>
                    {{ $venue->name }}
                </option>
            @endforeach
            </select>
    
            <label for="search">Search By Title</label>
            <input type="text" name="title" id="search" value="{{ $search }}" placeholder="Enter event title">
    
            <label for="date">Date</label>
            <input type="date" name="date" id="date" value="{{ $dateFilter }}">
    
            <button type="submit" class="apply-filter-button">Apply Filters</button>
        </form>
        <form method="GET" action="{{ route('events.all') }}">
            <button type="submit" class="clear-filter-button">Clear Filters</button>
        </form>
    </aside>

    <!-- Events Section -->
    <section class="events" id="events">
      <h2>All Events</h2>
      <div class="event-grid">
        <!-- Example Event Cards -->

        @foreach($events as $event)
        <div class="event-card">
            <h3>{{ $event->title }}</h3> <!-- Event Name -->
            <p>
                Venue: 
                @foreach($venues as $venue)
                    @if($venue->id == $event->venue_id) <!-- Check if the venue matches the event -->
                        {{ $venue->name }} <!-- Venue Name -->
                    @endif
                @endforeach
            </p>
            <p>
                Location: 
                @foreach($venues as $venue)
                    @if($venue->id == $event->venue_id)
                        {{ $venue->location }} <!-- Venue Location -->
                    @endif
                @endforeach
            </p>
            <p>
                Date: 
                <time datetime="{{ $event->date }}">{{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}</time> <!-- Event Date -->
            </p>
            <div>
              <a href="{{ route('events.show', $event->id) }}">
                <button class="view-details-button" aria-label="View details about {{ $event->title }}">
                    View Details
                </button>
              </a>
            </div>
        </div>
        @endforeach
        
        <!-- Add more event cards as needed -->
      </div>
    </section>
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
