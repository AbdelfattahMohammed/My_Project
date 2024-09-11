<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #343a40;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            font-size: 18px;
            color: #007bff;
            text-decoration: none;
            margin-bottom: 20px;
        }

        .back-link i {
            font-size: 20px;
            margin-right: 8px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
        }

        .profile-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
        }

        .profile-header h1 {
            margin: 0;
            font-size: 32px;
            color: #212529;
            font-weight: 700;
        }

        .profile-header p {
            margin: 0;
            font-size: 18px;
            color: #6c757d;
        }

        .profile-body {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #dee2e6;
        }

        .profile-body h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #212529;
            font-weight: 700;
            border-bottom: 3px solid #007bff;
            padding-bottom: 10px;
        }

        .profile-body p {
            font-size: 18px;
            line-height: 1.8;
            color: #495057;
            margin-bottom: 15px;
        }

        .profile-body a {
            /* color: #007bff; */
            text-decoration: none;
            font-weight: 500;
        }

        .profile-body a:hover {
            text-decoration: underline;
        }

        .company-logo {
            width: 160px;
            height: auto;
            border-radius: 8px;
        }
    </style>
</head>

<body>

    @if (session('success'))
        <div class="alert alert-success" id="successMessage">
            {{ session('success') }}
        </div>
    @endif

    <script>
        // Hide the success message after 2 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 2000); // 2000 milliseconds = 2 seconds
            }
        });
    </script>


    <a href="{{ url()->previous() }}" class="back-link">
        <i class="bi bi-arrow-left"></i> Back
    </a>
    <div class="container mt-5">
        <div class="profile-header">
            <div class="d-flex align-items-center">
                @if ($user->profile_picture)
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}">
                @else
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQu4TUtAk_tgrdgaKzCjHKehGKvBynfcxd9GA&s"
                        alt="Default Profile Image">
                @endif
                <div class="ms-3">
                    <h1>{{ $user->name }}</h1>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                </div>
            </div>
        </div>
        <div class="profile-body">
            <h2>About Me</h2>
            <p><strong>Company Name:</strong> {{ $employer->company_name }}</p>
            <p><strong>Company Logo:</strong></p>
            @if ($employer->company_logo)
                <img src="{{ asset('storage/' . $employer->company_logo) }}" alt="{{ $employer->company_name }}"
                    class="company-logo">
            @else
                <p>No logo available.</p>
            @endif
            <p><strong>Company Description:</strong> {{ $employer->company_description }}</p>
            <p><strong>Website:</strong>
                <a href="{{ strpos($employer->website, 'http') === 0 ? $employer->website : 'http://' . $employer->website }}"
                    target="_blank">View Website</a>
            </p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
