<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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

        .login-container {
            background: #222;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
        }

        .login-container h1 {
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

        .login-btn {
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

        .login-btn:hover {
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


    /* Validation error message */
    .error-message {
        color: #F44336;
        font-size: 0.85rem;
        margin-top: 0.3rem;
    }

    .input-error {
        border-color: #F44336;
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


    <div class="login-container">
        <h1>Let's Step In</h1>
        <form method="POST" action="{{ route('login') }}" id="frm">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
        <div class="footer">
            <p>Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js" integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script>
        $(document).ready(function () {
            // Initialize form validation
            $("#frm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    }
                },
                messages: {
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address."
                    },
                    password: {
                        required: "Please provide your password.",
                        minlength: "Your password must be at least 8 characters long."
                    }
                },
                errorElement: "div",
                errorPlacement: function (error, element) {
                    error.addClass("error-message");
                    error.insertAfter(element);
                },
                highlight: function (element) {
                    $(element).addClass("input-error");
                },
                unhighlight: function (element) {
                    $(element).removeClass("input-error");
                }
            });
        });
    </script>
    
</body>
</html>
