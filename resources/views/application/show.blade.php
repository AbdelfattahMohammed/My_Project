


























































































<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Applications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .table thead {
            background-color: #343a40;
            color: #fff;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn {
            margin-right: 5px;
        }

        .btn-success,
        .btn-danger {
            padding: 8px 16px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group input {
            border-radius: 0.25rem 0 0 0.25rem;
        }

        .input-group button {
            border-radius: 0 0.25rem 0.25rem 0;
        }

        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }

        .btn-back {
            background-color: #6c757d;
            border: none;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }

        .back-button-container {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <form action="{{ route('application.search') }}" method="GET">
            <div class="input-group mb-4">
                <input id="search-input" type="text" name="query" class="form-control"
                    placeholder="Search postings..." aria-label="Search postings">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form>

        <h2 class="mb-4">Job Applications</h2>
        {{-- @dd($applications) --}}
        @if ($applications)
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Applicant Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Resume</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                        <tr>
                            <td>{{ $application->candidate->user->name }}</td>
                            <td>{{ $application->email }}</td>
                            <td>{{ $application->phone }}</td>
                            <td><a href="{{ asset('storage/' . $application->resume) }}" target="_blank">View Resume</a>
                            </td>
                            <td>
                                <!-- In your Blade view (e.g., job_applications.blade.php) -->
                                <form action="{{ route('applications.accept', $application->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Accept</button>
                                </form>

                                <form action="{{ route('applications.refuse', $application->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Refuse</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No applications found matching your search criteria.</p>
        @endif

        <div class="back-button-container">
            <a href="{{ route('employer.index') }}" class="btn btn-back">Back</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
