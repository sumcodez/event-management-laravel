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

        <!-- Profile Form -->
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            <label for="first_name" class="update-profile">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>

            <label for="last_name" class="update-profile">First Name:</label>
            <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>

            <label for="email" class="update-profile">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>

            <button type="submit" class="update-button">Update Profile</button>
            <button class="cancel-button"><a href="{{ route('events.all') }}">Back To Dashboard</a></button>
        </form>
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
