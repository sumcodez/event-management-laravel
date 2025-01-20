<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Registered Events</title>
  <link rel="stylesheet" href="{{ asset('users_styles/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    /* Dark theme body and navbar */
    body {
      background-color: #121212; /* Dark background */
      color: #f1f1f1; /* Light text color */
      font-family: Arial, sans-serif;
    }

    .navbar {
      background-color: #1f1f1f; /* Dark navbar */
      color: #f1f1f1;
    }

    .navbar a {
      color: #f1f1f1;
    }

    /* Event heading styling */
    .registered-events h1 {
      text-align: center;
      font-size: 2rem;
      margin-bottom: 20px; /* Space between heading and cards */
      color: #fff; /* Light color for heading */
    }

    /* Individual event card styling */
    .event-card {
      background-color: #2c2c2c; /* Dark card background */
      border: 1px solid #444; /* Dark border */
      border-radius: 10px;
      width: 55%;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s ease-in-out;
      /* margin-left: 350px; */
      margin-top: 40px;
      text-align: justify;
    }

    /* Event list container styling */
    .event-list {
      display: flex;
      flex-direction: column;
      align-items: center; /* Center event cards */
      gap: 10px; /* Add gap between event cards */
    }

    .event-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5);
    }

    .event-card h2 {
      font-size: 1.5rem;
      margin-bottom: 10px;
      color: #fff; /* Light color for heading */
    }

    .event-card p {
      margin: 5px 0;
      color: #ddd; /* Slightly lighter text for paragraphs */
    }

    .event-card strong {
      font-weight: bold;
      color: #3498db; /* Blue color for strong text */
    }
    

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

  <div class="registered-eventss">
    <h1>Registered Events</h1>

    @if($registeredEvents->isEmpty())
      <p>You have not registered for any events yet.</p>
    @else
      <div class="event-list">
        @foreach($registeredEvents as $event)
          <div class="event-card">
            <h2>{{ $event->title }}</h2>
            <p><strong>Venue:</strong> {{ $event->venue_title }}</p>
            <p><strong>Location:</strong> {{ $event->venue_location }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}</p>
            <p><strong>Description:</strong> {{ $event->description }}</p>
          </div>
        @endforeach
      </div>
    @endif
  </div>

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
