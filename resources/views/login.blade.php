<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jobs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            animation: backgroundAnimation 10s ease-in-out infinite;
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        @keyframes backgroundAnimation {

            0%,
            100% {
                background: linear-gradient(135deg, #00c6ff, #0072ff);
            }

            50% {
                background: linear-gradient(135deg, #f05832, #feb47b);
            }
        }

        .fixed-width-alert {
            max-width: 500px;
            /* Increased width */
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .fixed-width-alert:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.5);
        }

        .form-label,
        .form-text {
            color: #333;
        }

        .btn-primary {
            background-color: #0072ff;
            border: none;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.1);
        }

        .btn-secondary {
            background-color: #ff7e5f;
            border: none;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-secondary:hover {
            background-color: #e85c3b;
            transform: scale(1.1);
        }

        .centered-buttons {
            display: flex;
            flex-direction: column;
            /* Stack buttons vertically */
            gap: 10px;
            /* Space between buttons */
            align-items: center;
            /* Center horizontally */
            margin-top: 10px;
        }

        .centered-buttons a {
            color: black;
            /* Set link color to black */
        }

        .centered-buttons .btn {
            width: 100%;
            /* Make buttons take full width */
            max-width: 300px;
            /* Set a max width */
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center min-vh-100 align-items-center">
        <div class="row">
            @if (session('error'))
                <div class="alert alert-danger " id="errorMessage">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success" id="successMessage">
                    {{ session('success') }}
                </div>
            @endif

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const successMessage = document.getElementById('successMessage');
                    if (successMessage) {
                        setTimeout(function() {
                            successMessage.style.display = 'none';
                        }, 2000);
                    }

                    const errorMessage = document.getElementById('errorMessage');
                    if (errorMessage) {
                        setTimeout(function() {
                            errorMessage.style.display = 'none';
                        }, 2000);
                    }
                });
            </script>

            <form action="{{ route('auth.check') }}" method="post" class="fixed-width-alert">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" required>
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" required>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

            <div class="centered-buttons">
                <a href="{{ route('users.create') }}">
                    <button type="button" class="btn btn-secondary">Create new account</button>
                </a>
                <a href="{{ route('user.password.change') }}">Forget my password?</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>
