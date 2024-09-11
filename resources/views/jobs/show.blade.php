


























































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

        .jobs-comment-button {
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
            margin-right: 10px;
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
            @if (!$jobs)
                <p>No jobsings available at the moment.</p>
            @else

                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- User Info -->
                            <div class="user-info d-flex align-items-center mb-3">
                                <a class="d-flex align-items-center text-dark"
                                    href="{{ route('portfolio', $jobs->employer->user->id) }}">
                                    @if ($jobs->employer->user->profile_picture)
                                        <img src="{{ asset('storage/' . $jobs->employer->user->profile_picture) }}"
                                            alt="{{ $jobs->employer->user->name }}" class="navbar-profile-img">
                                    @else
                                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQu4TUtAk_tgrdgaKzCjHKehGKvBynfcxd9GA&s"
                                            alt="Default Profile Image" class="navbar-profile-img">
                                    @endif
                                </a>
                                <div>
                                    <a class="d-flex align-items-center text-dark"
                                        href="{{ route('portfolio', $jobs->employer->user->id) }}">
                                        <strong>{{ $jobs->employer->user->name }}</strong>
                                    </a>
                                    <p class="mb-0 text-muted">
                                        @php
                                            $jobsedAt = \Carbon\Carbon::parse($jobs->jobsed_at);
                                            $now = \Carbon\Carbon::now();
                                            $diffInHours = $jobsedAt->diffInHours($now);
                                        @endphp
                                        @if ($diffInHours < 24)
                                            {{ $jobsedAt->format('h:i A') }}
                                            <!-- Display time if within the last 24 hours -->
                                        @else
                                            {{ $jobsedAt->format('M d, Y') }}
                                            <!-- Display date if older than 24 hours -->
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <h5 class="card-title">{{ $jobs->title }}</h5>
                            <p class="card-text"><strong>Company:</strong>
                                {{ $jobs->employer->company_name ?? 'Not Assigned' }}</p>
                            <p class="card-text"><strong>Location:</strong> {{ $jobs->location }}</p>
                            <p class="card-text"><strong>Salary Range:</strong> {{ $jobs->salary_range }}</p>
                            <p class="card-text"><strong>Description:</strong> {{ $jobs->description }}</p>


                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button"
                                    id="applicationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Application
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="applicationDropdown"
                                    style=" text-align: center; background-color: rgb(207, 200, 200)">
                                    <li>

                                        @if ($errors->any())
                                            <script>
                                                let errorMessages = '';
                                                @foreach ($errors->all() as $error)
                                                    errorMessages += "{{ $error }}\n";
                                                @endforeach
                                                alert(errorMessages);
                                            </script>
                                        @endif
                                        <form action="{{ route('application.store', $jobs->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="resume" class="form-label">Your CV OR Resume </label>
                                                <input type="file" class="form-control" id="resume"
                                                    name="resume">
                                            </div>
                                            <div class="mb-3">
                                                <label for="contactInfo" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="contactInfo"
                                                    name="email" placeholder="Your email">
                                            </div>
                                            <div class="mb-3">
                                                <label for="contactInfo" class="form-label">Mobile Phone</label>
                                                <input type="text" class="form-control" id="contactInfo"
                                                    name="phone" placeholder="Your mobile phone">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>





                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <button class="btn btn-light like-button" data-jobsing-id="{{ $jobs->id }}">
                                <span
                                    class="like-count">{{ $jobs->jobsActions->where('action_type', 'like')->count() }}</span>
                                Like
                            </button>
                            <button class="btn btn-light comment-button"
                                data-jobsing-id="{{ $jobs->id }}">Comment</button>
                            <button class="btn btn-light share-button"
                                data-jobsing-id="{{ $jobs->id }}">Share</button>
                        </div>
                        <div class="comment-section" style="display: none;">
                            <textarea class="comment-input form-control" placeholder="Write your comment..."></textarea>
                            <button class="btn btn-primary jobs-comment-button"
                                data-jobsing-id="{{ $jobs->id }}">Post Comment</button>
                            <div class="comments-list">
                                @foreach ($jobs->jobsActions->where('action_type', 'comment') as $comment)
                                    <div class="comment d-flex align-items-start mt-3">
                                        <a class="d-flex align-items-center text-dark"
                                            href="{{ route('admin.portfolio', $comment->user->id) }}">
                                            <img src="{{ $comment->user->profile_picture ? asset('storage/' . $comment->user->profile_picture) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQu4TUtAk_tgrdgaKzCjHKehGKvBynfcxd9GA&s' }}"
                                                alt="{{ $comment->user->name }}" class="rounded-circle me-3"
                                                style="width: 40px; height: 40px;">
                                            <strong>{{ $comment->user->name }}</strong>
                                        </a>
                                        <div>
                                            <br>
                                            <p class="mb-1">{{ $comment->comment_text }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="share-options justify-content-between ml-4 mb-2" style="display: none;">
                            <button class="btn btn-outline-primary" onclick="share('facebook')">Facebook</button>
                            <button class="btn btn-outline-primary" onclick="share('twitter')">Twitter</button>
                            <button class="btn btn-outline-primary" onclick="share('linkedin')">LinkedIn</button>
                            <button class="btn btn-outline-primary" onclick="share('email')">Email</button>
                        </div>
                    </div>
            @endif

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('toggleButton').addEventListener('click', function () {
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
                    const jobsId = this.dataset.jobsingId;
                    const likeCount = this.querySelector('.like-count');

                    fetch('/like', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-Token': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                jobsing_id: jobsId
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
                    const jobsId = this.dataset.jobsingId;
                    const commentSection = this.closest('.card').querySelector('.comment-section');
                    commentSection.style.display = commentSection.style.display === 'none' ?
                        'block' : 'none';
                });
            });

            // Post comment button functionality
            document.querySelectorAll('.jobs-comment-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    const jobsId = this.dataset.jobsingId;
                    const commentInput = this.closest('.comment-section').querySelector(
                        '.comment-input');
                    const commentText = commentInput.value.trim(); // Trim whitespace

                    if (commentText === '') {
                        // Don't proceed if the comment text is empty
                        return;
                    }

                    // Debugging
                    console.log('Posting comment:', {
                        jobsing_id: jobsId,
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
                                jobsing_id: jobsId,
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
                                            <a href="#" class="d-flex align-items-center text-dark dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
                    const jobsId = this.dataset.jobsingId;
                    const shareOptions = this.closest('.card').querySelector('.share-options');
                    shareOptions.style.display = shareOptions.style.display === 'none' ? 'flex' :
                        'none';
                });
            });
        });

        // Function to handle sharing
        function share(platform) {
            const jobsUrl = window.location.href; // Replace with your jobs URL
            const jobsTitle = document.title;

            let shareUrl = '';

            switch (platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(jobsUrl)}`;
                    break;
                case 'twitter':
                    shareUrl =
                        `https://twitter.com/intent/tweet?url=${encodeURIComponent(jobsUrl)}&text=${encodeURIComponent(jobsTitle)}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(jobsUrl)}`;
                    break;
                case 'email':
                    shareUrl = `mailto:?subject=${encodeURIComponent(jobsTitle)}&body=${encodeURIComponent(jobsUrl)}`;
                    break;
            }

            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    </script>

</body>

</html>
