<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Applications - Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            margin-bottom: 20px;
        }
        .table th, .table td {
            text-align: center;
        }
        .no-results {
            text-align: center;
            padding: 20px;
        }
        .btn-back {
            background-color: #6c757d;
            border: none;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
        .user-name{
            text-decoration: none;
            color: black;
        }
        .user-name:hover{
            color: black;
        }
    </style>
</head>

<body>
    {{-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Job Portal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('applications.index') }}">Applications</a>
                </li>
                <!-- Add other navigation links here -->
            </ul>
        </div>
    </nav> --}}

    <div class="container mt-5">
        <h2 class="mb-4">Search Results</h2>

        @if (count($applications) > 0)
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Resume</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                        <tr>
                            <td><!-- Dropdown -->
                                <div class="dropdown">
                                    <a class="user-name" class="user-name" href="#" role="button"
                                        id="dropdownMenuLink" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <b>{{ $application['name'] }}</b>
                                    </a>
                                    @php
                                        $app=App\Models\Application::find($application['id']);
                                    @endphp
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <!-- Link to portfolio -->
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.portfolio', $app->candidate->user->id) }}">
                                                View Portfolio
                                            </a>
                                        </li>
                                        <!-- Link to send a message -->
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('chat.show', $app->candidate->user->id) }}">
                                                Send a Message
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>{{ $application['email'] }}</td>
                            <td>{{ $application['phone'] }}</td>
                            <td><a href="{{ asset('storage/' . $application['resume']) }}" target="_blank">View Resume</a></td>
                            <td>
                                <a href="{{ url()->previous() }}" class="btn btn-back">Back</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-results">
                <h4>No applications found matching your search criteria.</h4>
                <a href="{{ url()->previous() }}" class="btn btn-back">Go Back</a>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
