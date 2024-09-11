<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light grey background for a clean look */
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 900px;
        }

        .btn-custom {
            background-color: #007bff; /* Bootstrap primary color */
            color: #ffffff;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s, transform 0.2s;
            text-decoration: none;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .btn-custom:focus,
        .btn-custom:active {
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
        }

        h1 {
            color: #343a40; /* Dark grey for headings */
        }

        .alert-success {
            background-color: #d4edda; /* Light green background for success message */
            color: #155724; /* Dark green text */
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

        .table {
            background-color: #ffffff; /* White background for the table */
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .table thead {
            background-color: #007bff; /* Bootstrap primary color for header */
            color: #ffffff;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2; /* Alternating row color */
        }

        .table tbody tr:hover {
            background-color: #e9ecef; /* Slightly darker on hover */
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-primary:focus,
        .btn-primary:active {
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <a href="{{ route('portfolio',Auth::user()->id) }}" class="btn btn-custom">Back to Profile</a>
        <h1 class="mt-4">My Applications</h1>

        @if (session('success'))
            <div class="alert alert-success" id="successMessage">
                {{ session('success') }}
            </div>
        @endif

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Job Title</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applications as $application)
                    <tr>
                        <td>{{ $application->id }}</td>
                        <td>{{ $application->posting->title }}</td>
                        <td>
                            @if(!$application->status)
                                Not Reviewed
                            @else
                                {{ $application->status }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('applications.edit', $application->id) }}" class="btn btn-primary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hide the success message after 2 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 2000);
            }
        });
    </script>
</body>

</html>
