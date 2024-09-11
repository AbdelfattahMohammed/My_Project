<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Body Styling */
        body {
            background: linear-gradient(to bottom right, #007bff, #6c757d);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        /* Form Container Styling */
        .container {
            width: 500px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: box-shadow 0.3s ease-in-out;
        }

        /* Container Hover Effect */
        .container:hover {
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        }

        /* Headline Styling */
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2rem;
            color: #343a40;
        }

        /* Form Input Styling */
        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* Form Input Focus Effect */
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.25);
        }

        /* Button Styling */
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        /* Button Hover Effect */
        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        /* Error Message Styling */
        .text-danger {
            font-size: 0.875rem;
            margin-top: 5px;
        }

    </style>
</head>

<body>
    <div class="container">
        <h1>Change Password</h1>
        <form action="{{ route('employer.password.update') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" class="form-control">
                @if ($errors->has('current_password'))
                    <span class="text-danger">{{ $errors->first('current_password') }}</span>
                @endif
            </div>

            <div class="form-group mb-3">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" class="form-control">
                @if ($errors->has('new_password'))
                    <span class="text-danger">{{ $errors->first('new_password') }}</span>
                @endif
            </div>

            <div class="form-group mb-4">
                <label for="new_password_confirmation">Confirm New Password</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary w-100">Change Password</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
