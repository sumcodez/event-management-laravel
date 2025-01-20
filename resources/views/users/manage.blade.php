<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Profile</title>
    <link rel="stylesheet" href="{{ asset('users_styles/style.css') }}">
</head>

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

    .profile-picture-container {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .profile-picture {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ccc;
    }

    .edit-button {
        position: absolute;
        margin-top: 140px;
        margin-left: 5px;
        background-color: #007BFF;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .edit-button:hover {
        background-color: #0056b3;
    }

    /* Style for the cancel button container */
   .cancel-container {
        text-align: center;
        margin-top: 20px;
    }

    .cancel-buttonn {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 13px;
        text-decoration: none;
        width: 50%;
    }

    .cancel-buttonn a {
        color: white;
        text-decoration: none;
    }

    .cancel-buttonn:hover {
        background-color: #d32f2f;
    }





    /* Style for the deactivate button container */
    .deactivate-container {
        text-align: center;
        margin-top: 20px;
    }

    .deactivate-buttonn {
        background-color: #007bff; /* Primary blue color */
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 13px;
        text-decoration: none;
        width: 50%;
        transition: background-color 0.3s ease; /* Smooth transition for hover effect */
    }

    .deactivate-buttonn a {
        color: white;
        text-decoration: none;
    }

    .deactivate-buttonn:hover {
        background-color: #0056b3; /* Darker blue for hover effect */
    }

    
</style>

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


    <div class="container">
        <h1>Manage Profile</h1>

        {{-- <label for="profile_picture" class="update-profile">Profile Picture:</label> --}}

        <!-- Display the current profile picture with an edit button -->
        <div class="profile-picture-container">
            @if($user->profile_picture)
                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Current Profile Picture" class="profile-picture" id="profile-preview">
            @else
                <img src="{{ asset('default_image/defPic.jpg') }}" alt="Default Profile Picture" class="profile-picture" id="profile-preview">
            @endif
            <button type="button" class="edit-button" id="edit-picture-button">Edit</button>
        </div>
        
        <!-- File input for uploading a new profile picture (hidden by default) -->
        <form id="profile-pic-form" method="POST" action="{{ route('profile.update_pic') }}" enctype="multipart/form-data" style="display: none;">
            @csrf
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" style="display: none;">
            <button type="submit" id="save-picture-button" style="display: none;">Save</button>
        </form>

        <!-- Profile Form -->
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            <label for="first_name" class="update-profile">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>

            <label for="last_name" class="update-profile">First Name:</label>
            <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>

            <label for="email" class="update-profile">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>

            <button type="submit" class="update-button">Update Profile</button>
            
        </form>

        <!-- Cancel Button -->
        <div class="cancel-container">
            <button class="cancel-buttonn"><a href="{{ route('events.all') }}">Back To Dashboard</a></button>
        </div>

        <!-- Cancel Button -->
        <div class="deactivate-container">
            <button class="deactivate-buttonn"><a href="{{ route('profile.deactivate') }}">Deactivate Your Account</a></button>
        </div>
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
    document.addEventListener("DOMContentLoaded", function () {
        const editButton = document.getElementById("edit-picture-button");
        const fileInput = document.getElementById("profile_picture");
        const form = document.getElementById("profile-pic-form");

        // Show file input when "Edit" button is clicked
        editButton.addEventListener("click", function () {
            fileInput.click();
        });

        // Automatically submit the form when a file is selected
        fileInput.addEventListener("change", function () {
            if (fileInput.files.length > 0) {
                form.style.display = "block"; // Show the form (optional)
                form.submit(); // Automatically submit the form
            }
        });
    });
</script>
</body>
</html>
