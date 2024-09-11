


















































































<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notification Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 60px;
            /* Ensure space for fixed header */
        }

        header {
            position: sticky;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
            z-index: 1000;
        }

        .navbar {
            padding: 0;
            border-radius: 20px;
        }

        .navbar-nav {
            flex-direction: row;
            justify-content: center;
        }

        .navbar-nav .nav-item {
            margin: 0 20px;
            font-size: 16px;
            font-weight: 500;
        }

        .navbar-nav .nav-link {
            color: #495057;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #007bff;
        }

        .navbar-profile-img {
            border: 2px solid #007bff;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            margin-right: 10px;
        }

        .dropdown-menu {
            width: 300px;
            max-height: 400px;
            overflow-y: auto;
            background-color: #ffffff;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .dropdown-menu.show {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .dropdown-menu a:hover {
            background-color: #f1f3f5;
        }

        /* Notification Bell Badge */
        .position-relative .badge {
            top: -10px;
            right: -10px;
            font-size: 0.75rem;
        }

        .dropdown-menu .dropdown-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #f1f3f5;
        }

        .dropdown-menu .dropdown-item .text-muted {
            font-size: 0.75rem;
            margin-top: 5px;
        }

        .container {
            max-width: 800px;
            margin-top: 40px;
        }

        .card {
            border-radius: 8px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .card-header {
            background-color: #007bff;
            color: #ffffff;
            font-weight: bold;
            border-bottom: 1px solid #007bff;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .card-body {
            padding: 20px;
            background-color: #ffffff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-primary:focus,
        .btn-primary.focus {
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
        }

        /* Page transition */
        .fade-in {
            opacity: 0;
            transition: opacity 0.5s ease-in;
        }

        .fade-in.show {
            opacity: 1;
        }
        .notification-read {
            color: #6c757d;
            font-weight: normal;
        }

        .notification-unread {
            color: #000;
            font-weight: bold;
        }
    </style>
</head>

<body class="fade-in">
    <header id="header" class="my-4">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <!-- Profile Image and Email -->
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    @if (Auth::user()->profile_picture)
                        <img id="profileImage" src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                            class="navbar-profile-img dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                            alt="Profile Image">
                    @else
                        <img id="profileImage"
                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQu4TUtAk_tgrdgaKzCjHKehGKvBynfcxd9GA&s"
                            class="navbar-profile-img dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                            alt="Profile Image">
                    @endif

                    <ul class="dropdown-menu" aria-labelledby="profileImage">
                        <li><a class="dropdown-item" href="{{ route('portfolio', Auth::user()->id) }}">View Profile</a>
                        </li>
                        <li><a href="#" class="dropdown-item" id="logout-link">Logout</a></li>
                    </ul>
                </div>

                <span class="ms-2">{{ Auth::user()->email }}</span>
            </div>

            <!-- Navbar items -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a id="home" class="nav-link" href="{{ route('employer.index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="posts" href="{{ route('employer.show', Auth::user()->id) }}">Your Posts</a>
                    </li>
                </ul>
            </div>

            <!-- Search Form -->
            <form action="{{ route('candidate.search') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input id="search-input" type="text" name="query" class="form-control"
                        placeholder="Search postings..." aria-label="Search postings">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>

            <!-- Notification Bell with Dropdown -->
            <div class="dropdown ms-3">
                <button class="btn btn-link p-0 position-relative" type="button" id="notificationDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell fs-5"></i>
                    @if ($unreadCount > 0)
                        <span class="position-absolute top-0 translate-middle badge rounded-pill bg-danger">
                            {{ $unreadCount }}
                        </span>
                    @else
                        <span class="position-absolute top-0 translate-middle badge rounded-pill bg-danger d-none">
                            0
                        </span>
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                    @forelse ($notifications as $notification)
                        @php
                            $data = is_array($notification->data)
                                ? $notification->data
                                : json_decode($notification->data, true);
                            $readClass = $notification->read_at ? 'notification-read' : 'notification-unread';
                        @endphp
                        <li>
                            <a class="dropdown-item d-flex align-items-center {{ $readClass }}"
                                href="{{ route('notifications.employer', $notification->id) }}"
                                data-id="{{ $notification->id }}">
                                <div class="me-2">
                                    <i class="fas fa-info-circle"></i> <!-- Icon for notification -->
                                </div>
                                <div>
                                    {{ $data['message'] ?? 'No message available' }}
                                    <small class="d-block text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li><a class="dropdown-item">No notifications</a></li>
                    @endforelse
                </ul>
            </div>
        </nav>
    </header>

    <div class="container mt-4">
        <h1 class="mb-4">Notification Details</h1>

        <div class="card">
            <div class="card-header">
                Notification
            </div>
            <div class="card-body">
                <p><strong>Message:</strong> {!! $data['message'] ?? 'No message available'  !!}</p>
                <p><strong>Received At:</strong> {{ $notification->created_at->format('d M Y, H:i:s') }}</p>
            </div>
        </div>

        <a href="{{ route('candidate.index') }}" class="btn btn-primary mt-3">Back</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

    <script>
        // Add fade-in effect to body
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('show');
        });

        // Add event listener for marking notifications as read
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function markAsRead(notificationId) {
                fetch(`/notifications/${notificationId}/read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ read: true })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateNotificationCount();
                            // Update the notification item class
                            const notificationItem = document.querySelector(`.dropdown-item[data-id="${notificationId}"]`);
                            if (notificationItem) {
                                notificationItem.classList.remove('notification-unread');
                                notificationItem.classList.add('notification-read');
                            }
                        } else {
                            console.error('Error marking notification as read.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            function updateNotificationCount() {
                fetch('/notifications/count')
                    .then(response => response.json())
                    .then(data => {
                        const badge = document.querySelector('#notificationDropdown .badge');
                        if (data.count > 0) {
                            badge.textContent = data.count;
                            badge.classList.remove('d-none');
                        } else {
                            badge.textContent = '0';
                            badge.classList.add('d-none');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Attach click event listeners to notification links
            document.querySelectorAll('.dropdown-item').forEach(item => {
                item.addEventListener('click', function(event) {
                    const notificationId = this.getAttribute('data-id');
                    if (notificationId) {
                        markAsRead(notificationId);
                    }
                });
            });

            // Initial load of notification count
            updateNotificationCount();
        });
    </script>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('employer.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Logout link handler
            document.getElementById('logout-link').addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default anchor behavior
                document.getElementById('logout-form').submit(); // Submit the logout form
            });
        });
    </script>

</body>

</html>
