<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 60px;
            /* Ensure space for fixed header */
        }

        .user-info img {
            border: 2px solid #007bff;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            margin-right: 10px;
        }

        .card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            margin-bottom: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #343a40;
        }

        .card-text {
            font-size: 16px;
            color: #495057;
        }

        .card-footer {
            background-color: #f1f3f5;
            border-top: 1px solid #dee2e6;
            padding: 10px;
        }

        .btn {
            border-radius: 25px;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            margin-right: 5px;
        }

        .btn:hover {
            opacity: 0.8;
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

        .btn-success,
        .btn-danger {
            padding: 8px 16px;
        }

        .comment-section {
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
            background-color: #f9f9f9;
        }

        .comment-input {
            border-radius: 25px;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1);
            padding: 12px 20px;
            font-size: 16px;
        }

        .post-comment-button {
            border-radius: 25px;
            margin-top: 10px;
        }

        .comments-list {
            margin-top: 20px;
        }

        .comment {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            background-color: #ffffff;
        }

        .comment img {
            border-radius: 50%;
            margin-right: 15px;
            border: 1px solid #dee2e6;
        }

        .comment p {
            margin: 0;
            font-size: 16px;
            color: #343a40;
        }

        .share-options {
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
            background-color: #f9f9f9;
        }

        .share-options button {
            font-size: 14px;
        }

        .table thead {
            background-color: #343a40;
            color: #fff;
        }

        .table th,
        .table td {
            vertical-align: middle;
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

        .container {
            padding: 30px;
            max-width: 900px;
            margin: auto;

        }

        .user-name {
            color: black;
        }

        .user-name:hover {
            color: black;
        }

        @media (max-width: 768px) {
            .navbar-nav {
                flex-direction: column;
            }

            .navbar-nav .nav-item {
                margin: 10px 0;
            }
        }

        a {
            cursor: pointer;
            text-decoration: none;
        }

        .custom-dropdown-menu {
            display: none;
        }
    </style>
</head>

<body>

    <div class="container">

        <section class="mb-4">
            @if (!$post)
                <p>No postings available at the moment.</p>
            @else
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- User Info -->
                        <div class="user-info d-flex align-items-center mb-3">
                            <!-- Profile Image and Name -->
                            <div class="d-flex align-items-center">
                                <div class="dropdown">
                                    <a href="#" class="d-flex align-items-center text-dark" id="profileDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        @if ($post->employer->user->profile_picture)
                                            <img src="{{ asset('storage/' . $post->employer->user->profile_picture) }}"
                                                alt="{{ $post->employer->user->name }}" class="navbar-profile-img">
                                        @else
                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQu4TUtAk_tgrdgaKzCjHKehGKvBynfcxd9GA&s"
                                                alt="Default Profile Image" class="navbar-profile-img">
                                        @endif
                                        <strong class="ml-2">{{ $post->employer->user->name }}</strong>
                                    </a>
                                    <p class="mb-0 text-muted ml-5"
                                        style="font-size: 0.875rem; margin-left:50px; margin-top:-10px;">
                                        {{ $post->posted_at->diffForHumans() }}
                                    </p>
                                    <!-- Dropdown Menu -->
                                    <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                                        <li><a class="dropdown-item"
                                                href="{{ route('admin.portfolio', $post->employer->user->id) }}">View
                                                Profile</a></li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('chat.show', $post->employer->user->id) }}">Send a
                                                Message</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text"><strong>Location:</strong> {{ $post->location }}</p>
                        <p class="card-text"><strong>Salary Range:</strong> {{ $post->salary_range }}</p>
                        <p class="card-text"><strong>Description:</strong> {{ $post->description }}</p>
                        <p class="card-text"><strong>Responsibilities:</strong> {{ $post->responsibilities }}</p>
                        <p class="card-text"><strong>Required Skills:</strong> {{ $post->required_skills }}</p>
                        <p class="card-text"><strong>Qualifications:</strong> {{ $post->qualifications }}</p>
                        <p class="card-text"><strong>Work Type:</strong> {{ $post->work_type }}</p>
                        <p class="card-text"><strong>Benefits:</strong> {{ $post->benefits }}</p>
                        @if ($post->image)
                            <div class="card-footer p-0">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Company Image" class="img-fluid"
                                    style="width: 100%;">
                            </div>
                        @endif
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <button class="btn btn-light like-button" data-posting-id="{{ $post->id }}">
                            <span
                                class="like-count">{{ $post->postActions->where('action_type', 'like')->count() }}</span>
                            Like
                        </button>
                        <button class="btn btn-light comment-button"
                            data-posting-id="{{ $post->id }}">Comment</button>
                        <button class="btn btn-light share-button" data-posting-id="{{ $post->id }}">Share</button>
                    </div>
                    <div class="comment-section" style="display: none;">
                        <textarea class="comment-input form-control" placeholder="Write your comment..."></textarea>
                        <button class="btn btn-primary post-comment-button" data-posting-id="{{ $post->id }}">Post
                            Comment</button>
                        <div class="comments-list">
                            @foreach ($post->postActions->where('action_type', 'comment') as $comment)
                                <div class="comment d-flex align-items-start mt-3">
                                    <div class="user-info d-flex align-items-center mb-3">
                                        <div class="dropdown">
                                            <a href="#" class="d-flex align-items-center text-dark "
                                                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
            @endif

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

            <div class="container mt-4">
                <!-- Toggle Button -->
                <button class="btn btn-primary" id="toggleButton">
                    View all applications
                </button>

                <!-- Dropdown Menu -->
                <div class="custom-dropdown-menu" id="dropdownMenu">
                    <div class="container mt-5">
                        <form action="{{ route('application.search',$post->id) }}" method="GET">
                            <div class="input-group mb-4">
                                <input id="search-input" type="text" name="query" class="form-control"
                                    placeholder="Search postings..." aria-label="Search postings">
                                <button class="btn btn-outline-secondary" type="submit">Search</button>
                            </div>
                        </form>

                        <h2 class="mb-4">Job Applications</h2>
                        {{-- @dd($applications) --}}
                        @if ($applications)
                            <table class="table table-bordered table-hover text-center">
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
                                            <td>
                                                <!-- Dropdown -->
                                                <div class="dropdown">
                                                    <a class="user-name" href="#" role="button"
                                                        id="dropdownMenuLink" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <b>{{ $application->candidate->user->name }}</b>
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <!-- Link to portfolio -->
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.portfolio', $application->candidate->user->id) }}">
                                                                View Portfolio
                                                            </a>
                                                        </li>
                                                        <!-- Link to send a message -->
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('chat.show', $application->candidate->user->id) }}">
                                                                Send a Message
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td>{{ $application->email }}</td>
                                            <td>{{ $application->phone }}</td>
                                            <td><a href="{{ asset('storage/' . $application->resume) }}"
                                                    target="_blank">View Resume</a></td>
                                            <td>
                                                <form action="{{ route('applications.accept', $application->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Accept</button>
                                                </form>

                                                <form action="{{ route('applications.refuse', $application->id) }}"
                                                    method="POST" style="display:inline;">
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
                    </div>
                </div>
            </div>


        </section>
        <a href="{{ route('employer.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Home
        </a>


    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('toggleButton').addEventListener('click', function() {
            var dropdownMenu = document.getElementById('dropdownMenu');
            if (dropdownMenu.style.display === 'none' || dropdownMenu.style.display === '') {
                dropdownMenu.style.display = 'block';
            } else {
                dropdownMenu.style.display = 'none';
            }
        });
    </script>

    <script>
        var routeBase = @json(route('admin.portfolio', Auth::user()->id));
        var chat = @json(route('chat.show', Auth::user()->id));
        var image = @json(Auth::user()->profile_picture
                ? asset('storage/' . Auth::user()->profile_picture)
                : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQu4TUtAk_tgrdgaKzCjHKehGKvBynfcxd9GA&s');
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Like button functionality
            document.querySelectorAll('.like-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    const postId = this.dataset.postingId;
                    const likeCount = this.querySelector('.like-count');

                    fetch('/like', {
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
                            } else {
                                this.classList.remove('btn-active');
                            }
                            likeCount.textContent = data.like_count;
                        });
                });
            });

            // Comment button functionality
            document.querySelectorAll('.comment-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    const postId = this.dataset.postingId;
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

                    fetch('/comment', {
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
                        .then(response => response.json())
                        .then(data => {
                            console.log('Data received:', data);

                            const commentsList = this.closest('.comment-section').querySelector(
                                '.comments-list');
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
                    const postId = this.dataset.postingId;
                    const shareOptions = this.closest('.card').querySelector('.share-options');
                    shareOptions.style.display = shareOptions.style.display === 'none' ? 'flex' :
                        'none';
                });
            });
        });

        // Function to handle sharing
        function share(platform) {
            const postUrl = window.location.href; // Replace with your post URL
            const postTitle = document.title;

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

            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    </script>

</body>

</html>
