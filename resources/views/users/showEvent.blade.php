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


    strong {
      color: #3498db; /* Vibrant blue color for strong text */
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

  <div class="event-details">
    <h1>{{ $event->title }}</h1>
    <p><strong>Venue:</strong> {{ $venue->name }}</p>
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

    {{-- @if(session('success'))
      <p class="flash-message">{{ session('success') }}</p>
    @endif --}}

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
  <script>
    // Toggle the mobile menu visibility
function toggleMenu() {
    var navLinks = document.getElementById("top-nav");
    navLinks.classList.toggle("show"); // Toggle the 'show' class to display/hide the menu
}

  // Toggle dropdown visibility on click
  document.querySelector('.dropbtn').addEventListener('click', function(event) {
    const dropdown = this.closest('.dropdown');
    dropdown.classList.toggle('show'); // Toggle the 'show' class to display/hide the dropdown
});
  </script>
</body>
</html>
