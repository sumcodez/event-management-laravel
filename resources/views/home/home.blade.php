<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #0d1117;
            color: #c9d1d9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow-x: hidden;
        }

        .navbar {
            position: absolute;
            top: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #161b22;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }

        .navbar .app-name {
            font-size: 18px;
            font-weight: bold;
            color: #c9d1d9;
            margin-left: 40px;
        }

        .navbar .datetime {
            margin-right: 40px;
            font-size: 16px;
            color: #8b949e;
        }

        .content {
            text-align: center;
        }

        .content h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .content .buttons {
            margin-top: 20px;
        }

        .content .buttons button {
            background-color: #21262d;
            color: #c9d1d9;
            border: 2px solid #c9d1d9;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 10px;
            transition: all 0.3s;
        }

        .content .buttons button a {
            text-decoration: none;
            color: #c9d1d9;
        }

        .content .buttons button a:hover {
            color: #0d1117;
        }

        .content .buttons button:hover {
            background-color: #c9d1d9;
            color: #0d1117;
        }

        .footer {
            position: absolute;
            bottom: 10px;
            right: 20px;
            font-size: 20px;
            color: #8b949e;
        }


    /* toast message */
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


    <div class="navbar">
        <div class="app-name">Event Management System</div>
        <div class="datetime" id="datetime"></div>
    </div>

    <div class="content">
        <h1>Event Management System</h1>
        <div class="buttons">
            <a href="{{ route('login') }}"><button>Get Started</button></a>
            <a href="{{ route('register') }}"><button>Sign Up</button></a>
        </div>
    </div>

    <div class="footer">Developed by @Bitpastel</div>

    <script>
        function updateDateTime() {
            const datetimeElement = document.getElementById('datetime');
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric', 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            };
            datetimeElement.textContent = now.toLocaleDateString('en-US', options);
        }

        // Update the date and time every second
        setInterval(updateDateTime, 1000);

        // Initialize the date and time
        updateDateTime();
    </script>
</body>
</html>
