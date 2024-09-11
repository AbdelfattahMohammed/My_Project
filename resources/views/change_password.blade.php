<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .fixed-width-alert {
            width: 450px; /* Increased width */
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 30px; /* Adjusted padding */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .form-label,
        .form-text {
            color: #333;
        }

        .btn-primary {
            background-color: #0072ff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .alert {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center min-vh-100 align-items-center">
        <div class="row">
            <div class="col-md-12">
                @if (session('error'))
                    <div class="alert alert-danger fixed-width-alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success fixed-width-alert">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('user.password.update') }}" method="post" class="fixed-width-alert">
                    @csrf

                    <!-- Email Input -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}"
                            required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Current Password -->
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control" id="current_password"
                            required>
                        @error('current_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control" id="new_password" required>
                        @error('new_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Confirm New Password -->
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control"
                            id="new_password_confirmation" required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100">Change Password</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
