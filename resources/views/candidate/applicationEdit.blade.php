<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 800px;
        }

        .btn-custom {
            background-color: #007bff;
            color: #ffffff;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 500;
            text-align: center;
            display: inline-block;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            transform: scale(1.02);
        }

        .btn-custom:focus,
        .btn-custom:active {
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-weight: 600;
            color: #495057;
        }

        .form-control {
            border-radius: 8px;
            border-color: #ced4da;
            padding: 12px 15px;
            font-size: 16px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }

        .text-danger {
            color: #dc3545;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 1.5rem;
        }

        .alert-success a {
            color: #155724;
            text-decoration: underline;
        }

        .alert-success a:hover {
            color: #0c5460;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <a href="{{ route('applications.index') }}" class="btn btn-custom">Back to Applications</a>
        <h1 class="mt-4 mb-4">Edit Application</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('applications.update', $application->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mt-3">
                <label for="resume">Resume</label>
                <input type="file" id="resume" name="resume" class="form-control">
                @if ($errors->has('resume'))
                    <span class="text-danger">{{ $errors->first('resume') }}</span>
                @endif
                @if ($application->resume)
                    <a href="{{ asset('storage/' . $application->resume) }}" target="_blank" class="d-block mt-2">View Current Resume</a>
                @endif
            </div>

            <div class="form-group mt-3">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $application->email) }}">
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $application->phone) }}">
                @if ($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Application</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
