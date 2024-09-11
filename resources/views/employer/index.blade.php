<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-store" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <title>Job Postings</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}
    <style>
        /* General Body Styling */
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 60px;
            /* Ensure space for fixed header */
        }

        /* Navbar Styling */



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

        .dropdown-menu .dropdown-item {
            display: flex;
            align-items: start;
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
            text-decoration: none;
            overflow: inherit;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #f1f3f5;
            color: inherit;
            /* Keep text color consistent */
        }

        .dropdown-menu .dropdown-item .text-muted {
            font-size: 0.75rem;
            margin-top: 5px;
        }

        /* .notification-read a,
        .notification-unread a {
            color: inherit;
            text-decoration: none;
        }

        .notification-read a:hover,
        .notification-unread a:hover {
            text-decoration: underline;
            color: inherit;
        }

        .notification-read small,
        .notification-unread small {
            color: #6c757d;
        } */

        .notification-read {
            color: #6c757d;
            font-weight: normal;
        }

        .notification-unread {
            color: #000;
            font-weight: bold;
        }

        .position-relative .badge {
            top: -10px;
            right: -10px;
            font-size: 0.75rem;
        }



        /* Card Styling */
        .card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            margin-bottom: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: #333;
        }

        .card-text {
            font-size: 16px;
            color: #555;
        }

        .card-footer {
            background-color: #f9f9f9;
            border-top: 1px solid #e0e0e0;
            padding: 10px;
        }

        /* Buttons Styling */
        .btn {
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 16px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-light {
            color: #007bff;
            border-color: #007bff;
        }

        .btn-light:hover {
            background-color: #007bff;
            color: #ffffff;
        }

        .btn-active {
            background-color: #007bff;
            color: #ffffff;
        }

        /* Comment Section Styling */
        .comment-section {
            border-top: 1px solid #e0e0e0;
            padding-top: 20px;
            background-color: #f9f9f9;
        }

        .comment-input {
            border-radius: 20px;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }

        .post-comment-button {
            border-radius: 20px;
            margin-top: 10px;
        }

        /* Comment List Styling */
        .comments-list {
            margin-top: 10px;
        }

        .comment {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            background-color: #ffffff;
        }

        .comment img {
            border: 1px solid #e0e0e0;
            margin-right: 10px;
        }

        .comment p {
            margin: 0;
            font-size: 15px;
            color: #333;
        }

        /* Share Options Styling */
        .share-options {
            border-top: 1px solid #e0e0e0;
            padding-top: 10px;
            background-color: #f9f9f9;
        }

        .share-options button {
            font-size: 14px;
        }

        #search_input {
            border-radius: 0 25px 25px 0 !important;
        }

        /* Container Styling */
        .container {
            padding: 30px;
            max-width: 800px;
            margin: auto;
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .navbar-nav {
                flex-direction: column;
            }

            .navbar-nav .nav-item {
                margin: 10px 0;
            }
        }
    </style>
</head>

<body>
    <header id="header" class="my-4">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <!-- Profile Image and Email -->
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    @if (Auth::user()->profile_picture)
                        <img id="profileImage" src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                            class="navbar-profile-img dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" alt="Profile Image">
                    @else
                        <img id="profileImage"
                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQu4TUtAk_tgrdgaKzCjHKehGKvBynfcxd9GA&s"
                            class="navbar-profile-img dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" alt="Profile Image">
                    @endif

                    <div class="dropdown-menu" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="{{ route('portfolio', Auth::user()->id) }}">View Profile</a>
                        <a class="dropdown-item" href="{{ route('chat.index') }}">My Chat</a> <!-- New Chat Link -->
                        <a href="#" class="dropdown-item" id="logout-link">Logout</a>
                    </div>
                </div>

                <span class="ml-2">{{ Auth::user()->email }}</span>
            </div>

            <!-- Navbar items -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employer.index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="posts" href="{{ route('employer.show', Auth::user()->id) }}">Your
                            Posts</a>
                    </li>
                </ul>
            </div>

            <!-- Search Bar -->
            <form action="{{ route('posting.ss') }}" method="GET" class="mx-3">
                <div class="input-group">
                    <input id="search-input" type="text" name="query" class="form-control"
                        placeholder="Search postings..." aria-label="Search postings">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" id="search_input" type="submit">Search</button>
                    </div>
                </div>
            </form>

            <!-- Notification Bell with Dropdown -->
            <div class="dropdown mx-3">
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
                            $notificationType = $data['type'] ?? ''; // Notification type
                            $url = $data['url'] ?? '#'; // Default URL if not set
                            $message = $data['message'] ?? 'No message available'; // Default message if not set
                            $applicationId = $data['application_id'] ?? null; // Application ID if applicable
                            $postId = $data['post_id'] ?? null; // Application ID if applicable
                            $application = $applicationId ? \App\Models\Application::find($applicationId) : null; // Find application if ID is present
                        @endphp

                        @if (in_array($notificationType, ['job_acceptance', 'like', 'comment', 'share']))
                            <!-- Notification related to job acceptance -->
                            <li class="dropdown-item {{ $readClass }}" data-id="{{ $notification->id }}">
                                <div class="d-flex">
                                    <i class="fas fa-info-circle me-2"></i> <!-- Icon for notification -->
                                    <div>
                                        <a
                                            href="{{ route('employer.acceptance', ['jobId' => $postId, 'notificationId' => $notification->id]) }}">
                                            {!! $message !!}
                                        </a>
                                        <small
                                            class="d-block text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </li>
                        @elseif ($notificationType == 'application_sended' && $application)
                            <!-- Notification related to application updates -->
                            <li class="dropdown-item {{ $readClass }}" data-id="{{ $notification->id }}">
                                <div class="d-flex">
                                    <i class="fas fa-info-circle me-2"></i> <!-- Icon for notification -->
                                    <div>
                                        <a
                                            href="{{ route('posting.open', ['jobId' => $application->posting->id, 'notificationId' => $notification->id]) }}">
                                            {!! $message !!}
                                        </a>
                                        <small
                                            class="d-block text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </li>
                        @else
                            <!-- Default case or unknown notification type -->
                            <li class="dropdown-item {{ $readClass }}" data-id="{{ $notification->id }}">
                                <div class="d-flex">
                                    <i class="fas fa-info-circle me-2"></i> <!-- Icon for notification -->
                                    <div>
                                        <a href="{{ $url }}">
                                            {!! $message !!}
                                        </a>
                                        <small
                                            class="d-block text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </li>
                        @endif

                    @empty
                        <li><a class="dropdown-item">No notifications</a></li>
                    @endforelse
                </ul>
            </div>


            <!-- Create Post Button -->
            <a href="{{ route('posting.create') }}" class="btn btn-primary">Create Post</a>
        </nav>
    </header>

    <div class="container content">
        <!-- Job Listings -->
        <section class="mb-4">
            @if ($jobPostings->isEmpty())
                <p>No job postings available at the moment.</p>
            @else
                @foreach ($jobPostings as $job)
                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- User Info -->
                            <div class="user-info d-flex align-items-center mb-3">
                                <!-- Profile Image and Name -->
                                <div class="d-flex align-items-center">
                                    <div class="dropdown">
                                        <a href="#" class="d-flex align-items-center text-dark"
                                            id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            @if ($job->employer->user->profile_picture)
                                                <img src="{{ asset('storage/' . $job->employer->user->profile_picture) }}"
                                                    alt="{{ $job->employer->user->name }}"
                                                    class="navbar-profile-img">
                                            @else
                                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQu4TUtAk_tgrdgaKzCjHKehGKvBynfcxd9GA&s"
                                                    alt="Default Profile Image" class="navbar-profile-img">
                                            @endif
                                            <strong class="ml-2">{{ $job->employer->user->name }}</strong>
                                        </a>
                                        <p class="mb-0 text-muted ml-5"
                                            style="font-size: 0.875rem; margin-left:50px; margin-top:-10px;">
                                            {{ $job->posted_at->diffForHumans() }}
                                        </p>
                                        <!-- Dropdown Menu -->
                                        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('admin.portfolio', $job->employer->user->id) }}">View
                                                    Profile</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('chat.show', $job->employer->user->id) }}">Send a
                                                    Message</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <h5 class="card-title">{{ $job->title }}</h5>
                            <p class="card-text"><strong>Location:</strong> {{ $job->location }}</p>
                            <p class="card-text"><strong>Salary Range:</strong> {{ $job->salary_range }}</p>
                            <p class="card-text"><strong>Description:</strong> {{ $job->description }}</p>
                            <p class="card-text"><strong>Responsibilities:</strong> {{ $job->responsibilities }}</p>
                            <p class="card-text"><strong>Required Skills:</strong> {{ $job->required_skills }}</p>
                            <p class="card-text"><strong>Qualifications:</strong> {{ $job->qualifications }}</p>
                            <p class="card-text"><strong>Work Type:</strong> {{ $job->work_type }}</p>
                            <p class="card-text"><strong>Benefits:</strong> {{ $job->benefits }}</p>
                            @if ($job->image)
                                <div class="card-footer p-0">
                                    <img src="{{ asset('storage/' . $job->image) }}" alt="Company Image"
                                        class="img-fluid" style="width: 100%;">
                                </div>
                            @endif
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <button class="btn btn-light like-button" data-posting-id="{{ $job->id }}">
                                <span
                                    class="like-count">{{ $job->postActions->where('action_type', 'like')->count() }}</span>
                                Like
                            </button>
                            <button class="btn btn-light comment-button"
                                data-posting-id="{{ $job->id }}">Comment</button>
                            <button class="btn btn-light share-button"
                                data-posting-id="{{ $job->id }}">Share</button>
                        </div>
                        <div class="comment-section" style="display: none;">
                            <textarea class="comment-input form-control" placeholder="Write your comment..."></textarea>
                            <button class="btn btn-primary post-comment-button"
                                data-posting-id="{{ $job->id }}">Post Comment</button>
                            <div class="comments-list">
                                @foreach ($job->postActions->where('action_type', 'comment') as $comment)
                                    <div class="comment d-flex align-items-start mt-3">
                                        <div class="user-info d-flex align-items-center mb-3">
                                            <div class="dropdown">
                                                <a href="#" class="d-flex align-items-center text-dark"
                                                    id="profileDropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <img src="{{ $comment->user->profile_picture ? asset('storage/' . $comment->user->profile_picture) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQu4TUtAk_tgrdgaKzCjHKehGKvBynfcxd9GA&s' }}"
                                                        alt="{{ $comment->user->name }}" class="rounded-circle me-3"
                                                        style="width: 40px; height: 40px;">
                                                    <strong class="ml-2">{{ $comment->user->name }}</strong>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('admin.portfolio', $comment->user->id) }}">View
                                                            Profile</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('chat.show', $comment->user->id) }}">Send a
                                                            Message</a></li>
                                                    @if (Auth::user()->id == $comment->user->id)
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('admin.delete.comment', $comment->id) }}">Delete
                                                                a comment</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        <div>
                                            <br>
                                            <p class="mb-1">{{ $comment->comment_text }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="share-options justify-content-between mb-2" style="display: none;">
                            <button class="btn btn-outline-primary" onclick="share('facebook')">Facebook</button>
                            <button class="btn btn-outline-primary" onclick="share('twitter')">Twitter</button>
                            <button class="btn btn-outline-primary" onclick="share('linkedin')">LinkedIn</button>
                            <button class="btn btn-outline-primary" onclick="share('email')">Email</button>
                        </div>
                    </div>
                @endforeach
            @endif
        </section>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script> --}}



    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('employer.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>


    <script>
        var routeBase = @json(route('admin.portfolio', Auth::user()->id));
        var chat = @json(route('chat.show', Auth::user()->id));
        var image = @json(Auth::user()->profile_picture
                ? asset('storage/' . Auth::user()->profile_picture)
                : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQu4TUtAk_tgrdgaKzCjHKehGKvBynfcxd9GA&s');
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Logout link handler
            document.getElementById('logout-link').addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default anchor behavior
                document.getElementById('logout-form').submit(); // Submit the logout form
            });

            // Like button functionality
            document.querySelectorAll('.like-button').forEach(function(button) {
                const postId = button.dataset.postingId;

                // Restore the like state from localStorage
                const isLiked = localStorage.getItem(`post-liked-${postId}`) === 'true';
                if (isLiked) {
                    button.classList.add('btn-active');
                }

                button.addEventListener('click', function() {
                    const likeCount = this.querySelector('.like-count');

                    fetch(`/like`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-Token': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                posting_id: postId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'liked') {
                                this.classList.add('btn-active');
                                localStorage.setItem(`post-liked-${postId}`, 'true');
                            } else {
                                this.classList.remove('btn-active');
                                localStorage.setItem(`post-liked-${postId}`, 'false');
                            }
                            likeCount.textContent = data.like_count;
                        });
                });
            });

            // Comment button functionality
            document.querySelectorAll('.comment-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    const commentSection = this.closest('.card').querySelector('.comment-section');
                    commentSection.style.display = commentSection.style.display === 'none' ?
                        'block' : 'none';
                });
            });

            // Post comment button functionality
            document.querySelectorAll('.post-comment-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    const postId = this.dataset.postingId;
                    const commentInput = this.closest('.comment-section').querySelector(
                        '.comment-input');
                    const commentText = commentInput.value.trim(); // Trim whitespace

                    if (commentText === '') {
                        // Don't proceed if the comment text is empty
                        return;
                    }

                    // Debugging
                    console.log('Posting comment:', {
                        posting_id: postId,
                        comment_text: commentText
                    });

                    fetch(`/comment`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-Token': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                posting_id: postId,
                                comment_text: commentText
                            })
                        })
                        .then(response => {
                            console.log('Fetch response:', response);
                            return response.json();
                        })
                        .then(data => {
                            console.log('Data received:', data);

                            const commentsList = this.closest('.comment-section').querySelector(
                                '.comments-list');
                            var deleteUrl = `/admin/delete/${data.comment_id}/comment`;
                            commentsList.insertAdjacentHTML('beforeend', `
                                <div class="comment d-flex align-items-start mt-3">
                                    <div class="user-info d-flex align-items-center mb-3">
                                        <div class="dropdown">
                                            <a href="#" class="d-flex align-items-center text-dark" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <img src="${image}" alt="${data.user_name}" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                                                <strong class="ml-2">${data.user_name}</strong>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                                                <li><a class="dropdown-item" href="${routeBase}">View Profile</a></li>
                                                <li><a class="dropdown-item" href="${chat}">Send a Message</a></li>
                                                <li><a class="dropdown-item" href="${deleteUrl}">Delete a comment</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <br>
                                        <p class="mb-1">${data.comment_text}</p>
                                    </div>
                                </div>
                        `);

                            // Clear the comment input field
                            commentInput.value = '';
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });

            // Share button functionality
            document.querySelectorAll('.share-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    const shareOptions = this.closest('.card').querySelector('.share-options');
                    shareOptions.style.display = shareOptions.style.display === 'none' ? 'flex' :
                        'none';
                });
            });
        });

        // Function to handle sharing
        function share(platform) {
            const postUrl = window.location.href; // The URL to share
            const postTitle = document.title; // The title to share

            let shareUrl = '';

            switch (platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(postUrl)}`;
                    break;
                case 'twitter':
                    shareUrl =
                        `https://twitter.com/intent/tweet?url=${encodeURIComponent(postUrl)}&text=${encodeURIComponent(postTitle)}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(postUrl)}`;
                    break;
                case 'email':
                    shareUrl = `mailto:?subject=${encodeURIComponent(postTitle)}&body=${encodeURIComponent(postUrl)}`;
                    break;
            }

            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
            }
        }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('header');
            const scrollOffset = 150;

            function checkScroll() {
                if (window.scrollY >= scrollOffset) {
                    header.classList.add('navbar-fixed');
                } else {
                    header.classList.remove('navbar-fixed');
                }
            }

            // Check on scroll
            window.addEventListener('scroll', checkScroll);

            // Check on load in case the page is already scrolled
            checkScroll();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Logout link handler
            document.getElementById('logout-link').addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default anchor behavior
                document.getElementById('logout-form').submit(); // Submit the logout form
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function markAsRead(notificationId) {
                fetch(`/notifications/${notificationId}/read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            read: true
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateNotificationCount();
                            // Update the notification item class
                            const notificationItem = document.querySelector(
                                `.dropdown-item[data-id="${notificationId}"]`);
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

</body>

</html>
