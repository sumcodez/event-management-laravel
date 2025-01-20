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
        z-index: 9999;
    }

    .toast.success {
        background-color: #4CAF50; /* Green for success */
    }

    .toast.show {
        opacity: 1;
    }


  /* Styling for the labels (e.g., Venue, Location, Date) */
  .event-label {
      font-weight: bold;
      font-size: 1.1rem; /* Slightly larger font size */
      color: #3498db; /* Highlighted color for labels */
  }

  /* Styling for the values (e.g., venue name, location, date) */
  .event-value {
      font-weight: normal;
      font-size: 1.1rem; /* Match label font size */
      color: #ffffff; /* White text for values */
  }
  /* Optional: Add spacing for better readability */
  .event-card p {
      margin: 8px 0; /* Adds space between each line */
  }




  .profile-pic {
        width: 40px; /* Set the desired size */
        height: 40px; /* Match the width for a perfect circle */
        border-radius: 50%; /* Makes the image circular */
        object-fit: cover; /* Ensures the image scales properly */
        border: 2px solid #fff; /* Optional: Add a border for better appearance */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Optional: Add a subtle shadow */
        vertical-align: middle; /* Aligns the image with the text */
        margin-right: 8px; /* Adds spacing between the image and text */
    }

    .dropdown {
        display: flex;
        align-items: center; /* Aligns the image and text vertically */
    }

    .dropbtn {
        margin-left: 4px; /* Adjust spacing between image and dropdown button */
    }

  /* Prevent dropdown from showing on hover */
.dropdown:hover .dropdown-content {
    display: none; /* Prevent showing on hover */
}

/* Dropdown button styles */
.dropdown .dropbtn {
    cursor: pointer; /* Indicate the button is clickable */
}

/* Dropdown content styles */
.dropdown-content {
    display: none; /* Initially hidden */
    position: absolute;
    background-color: #black;
    min-width: 160px;
    z-index: 1;
    border: 1px solid white;
    border-radius: 4px;
}

/* Show dropdown content when clicked */
.dropdown.show .dropdown-content {
    display: block;
}
  


/* Mobile Styles */
@media (max-width: 768px) {
    .navbar .nav-links {
        display: none; /* Hide navigation links by default */
        flex-direction: column; /* Stack the links vertically */
        position: absolute;
        top: 60px;
        right: 0;
        background-color: #333;
        width: 100%;
        padding: 10px;
    }

    .navbar .nav-links.show {
        display: flex; /* Show the links when the 'show' class is added */
    }

    .navbar .nav-links li {
        margin-right: 0;
        margin-bottom: 10px;
    }

    .navbar .menu-toggle {
        display: block; /* Show the hamburger icon on mobile */
        cursor: pointer;
    }

    .navbar .menu-toggle i {
        font-size: 2rem;
        color: white;
    }
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
        <li class="dropdown">
          <a href="{{ route('events.my-registrations') }}">My Registrations</a>
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
            @if($user->profile_picture)
                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Current Profile Picture" class="profile-pic" id="profile-preview">
            @else
                <img src="{{ asset('default_image/defPic.jpg') }}" alt="Default Profile Picture" class="profile-pic" id="profile-preview">
            @endif
        </li>
      </ul>
    {{-- <div class="menu-toggle" onclick="toggleMenu()"><i class="fa fa-bars"></i></div> --}}
    <a href="javascript:void(0);" class="menu-toggle" onclick="toggleMenu()">
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
              <span class="event-label">Venue:</span> 
              <span class="event-value">
                  @foreach($venues as $venue)
                      @if($venue->id == $event->venue_id) <!-- Check if the venue matches the event -->
                          {{ $venue->name }} <!-- Venue Name -->
                      @endif
                  @endforeach
              </span>
          </p>
          <p>
              <span class="event-label">Location:</span> 
              <span class="event-value">
                  @foreach($venues as $venue)
                      @if($venue->id == $event->venue_id)
                          {{ $venue->location }} <!-- Venue Location -->
                      @endif
                  @endforeach
              </span>
          </p>
          <p>
              <span class="event-label">Date:</span> 
              <span class="event-value">
                  <time datetime="{{ $event->date }}">{{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}</time> <!-- Event Date -->
              </span>
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

        {{-- <img src="{{ asset('storage/' . $user->profile_picture) }}"> --}}

      </div>
    </section>
  </div>

  <script>
// Toggle the mobile menu visibility
function toggleMenu() {
    var navLinks = document.getElementById("top-nav");
    navLinks.classList.toggle("show"); // Toggle the 'show' class to display/hide the menu
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
<script>
  // Toggle dropdown visibility on click
document.querySelector('.dropbtn').addEventListener('click', function(event) {
    const dropdown = this.closest('.dropdown');
    dropdown.classList.toggle('show'); // Toggle the 'show' class to display/hide the dropdown
});
</script>
</body>
</html>
