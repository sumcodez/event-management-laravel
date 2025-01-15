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

        .navbar .menu {
            display: flex;
            gap: 20px;
            margin-left: auto;
            margin-right: 40px;
        }

        .navbar a {
            text-decoration: none;
            color: #c9d1d9;
            font-size: 16px;
            padding: 8px 15px;
            border: 1px solid transparent;
            border-radius: 5px;
            transition: all 0.3s;
            border: 1px solid #c9d1d9;
        }

        .navbar a:hover {
            background-color: #c9d1d9;
            color: #0d1117;
            border: 1px solid #c9d1d9;
        }

        .navbar .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            margin-left: auto;
        }

        .navbar .hamburger div {
            width: 25px;
            height: 3px;
            background-color: #c9d1d9;
        }

        .menu.active {
            display: flex;
            flex-direction: column;
            background-color: #161b22;
            position: absolute;
            top: 50px;
            right: 20px;
            width: 150px;
            border: 1px solid #c9d1d9;
            border-radius: 5px;
            padding: 10px;
        }

        .subtext {
            font-size: 1rem;
            color: #8b949e;
            margin-top: 10px;
        }


        @media (max-width: 768px) {
            .navbar .menu {
                display: none;
            }

            .menu.active {
                display: flex;
            }

            .navbar .hamburger {
                display: flex;
            }
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

        .content .buttons button a{
            text-decoration: none;
            color: #c9d1d9;
        }

        .content .buttons button a:hover{
            color: #0d1117;
        }

        .content .buttons button:hover {
            background-color: #c9d1d9;
            color: #0d1117;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="app-name">Event Management System</div>
        <div class="hamburger" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="menu">
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Sign Up</a>
        </div>
    </div>

    <div class="content">
        <h1>Event Management System</h1>
        <p class="subtext">Prod by BitPastel</p>
        <div class="buttons">
            <button><a href="{{ route('login') }}">Get Started</a></button>
            <button><a href="{{ route('register') }}">Sign Up</a></button>
        </div>
    </div>

    <script>
        function toggleMenu() {
            const menu = document.querySelector('.menu');
            menu.classList.toggle('active');
        }
    </script>
</body>
</html>
