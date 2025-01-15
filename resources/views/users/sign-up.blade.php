<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-Up Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1f1f1f, #121212);
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .signup-container {
            background: #222;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
        }

        .signup-container h1 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
            color: #f0f0f0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: #bbbbbb;
        }

        .form-group input {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 4px;
            background: #333;
            color: #fff;
            font-size: 1rem;
        }

        .form-group input:focus {
            outline: none;
            border: 2px solid #555;
        }

        .signup-btn {
            width: 100%;
            padding: 0.8rem;
            background: #3b82f6;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
        }

        .signup-btn:hover {
            background: #2563eb;
        }

        .footer {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.8rem;
            color: #888;
        }

        .footer a {
            color: #3b82f6;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #ff6b6b;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .valid-message {
            color: #4caf50;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const passwordInput = document.getElementById('password');
            const passwordError = document.getElementById('passwordError');
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const confirmPasswordError = document.getElementById('confirmPasswordError');
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('emailError');


            emailInput.addEventListener('input', () => {
                const email = emailInput.value;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailRegex.test(email)) {
                    emailError.textContent = 'Please enter a valid email address.';
                    emailError.classList.remove('valid-message');
                    emailError.classList.add('error-message');
                } else {
                    emailError.textContent = 'Email looks good!';
                    emailError.classList.remove('error-message');
                    emailError.classList.add('valid-message');
                }
            });

            passwordInput.addEventListener('input', () => {
                const password = passwordInput.value;
                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

                if (!passwordRegex.test(password)) {
                    passwordError.textContent = 'Password must be at least 8 characters long, include an uppercase letter, a lowercase letter, and a number.';
                    passwordError.classList.remove('valid-message');
                    passwordError.classList.add('error-message');
                } else {
                    passwordError.textContent = 'Password looks good!';
                    passwordError.classList.remove('error-message');
                    passwordError.classList.add('valid-message');
                }
            });

            confirmPasswordInput.addEventListener('input', () => {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                if (confirmPassword !== password) {
                    confirmPasswordError.textContent = "Passwords didn't match.";
                    confirmPasswordError.classList.remove('valid-message');
                    confirmPasswordError.classList.add('error-message');
                } else {
                    confirmPasswordError.textContent = "Passwords match.";
                    confirmPasswordError.classList.remove('error-message');
                    confirmPasswordError.classList.add('valid-message');
                }
            });
        });
    </script>
</head>
<body>
    <div class="signup-container">
        <h1>Sign Up</h1>
        <form method="POST" action="{{ route('users.sign-up') }}">
            @csrf
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="first_name" placeholder="Enter your first name" required>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="last_name" placeholder="Enter your last name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                <div id="emailError" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <div id="passwordError" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="password_confirmation" placeholder="Confirm your password" required>
                <div id="confirmPasswordError" class="error-message"></div>
            </div>
            <button type="submit" class="signup-btn">Sign Up</button>
        </form>
        
        <div class="footer">
            <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
        </div>
    </div>
</body>
</html>
