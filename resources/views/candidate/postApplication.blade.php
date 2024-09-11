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
            background: linear-gradient(to right, #74ebd5, #acb6e5);
            /* Linear gradient background */
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
            background-color: #e0f7fa;
            /* Soft teal matching the gradient */
            margin-bottom: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #004d73;
            /* Darker shade from the gradient */
        }

        .card-text {
            font-size: 16px;
            color: #006580;
            /* Slightly darker text */
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
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-primary {
            background-color: #009688;
            /* Teal matching the gradient */
            border-color: #00796b;
            /* Darker teal for border */
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: #00796b;
            /* Darker teal on hover */
            border-color: #004d40;
            /* Deep teal for hover effect */
        }

        .btn-light {
            color: #00796b;
            border-color: #00796b;
        }

        .btn-light:hover {
            background-color: #00796b;
            color: #ffffff;
        }

        .btn-success {
            background-color: #43a047;
            /* Slightly brighter green to complement teal */
            border-color: #2e7d32;
            color: #ffffff;
        }

        .btn-danger {
            background-color: #e57373;
            /* Soft red to contrast with the teal */
            border-color: #d32f2f;
            color: #ffffff;
        }

        .btn:hover {
            opacity: 0.8;
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
            background-color: #009688;
            color: white;
            margin-top: 10px;
        }

        .post-comment-button:hover {
            background-color: #00796b;
        }

        .share-options button {
            background-color: #009688;
            color: #ffffff;
        }

        .share-options button:hover {
            background-color: #00796b;
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

        /* Home Button */
        .home-button {
            position: fixed;
            top: 10px;
            left: 20px;
            background-color: #28a745;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .home-button:hover {
            background-color: #218838;
            color: #ffffff;
            transform: scale(1.15);
        }
    </style>
</head>

<body>

    <a href="{{ route('candidate.index') }}" class="home-button">
        Home
    </a>

    <div class="container">

        <section class="mb-4">
            @if (!$post)
                <p>No job postings available at the moment.</p>
            @else
                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- User Info -->
                            <div class="user-info d-flex align-items-center mb-3">
                                <!-- Profile Image and Name -->
                                <div class="d-flex align-items-center">
                                    <div class="dropdown">
                                        <a href="#" class="d-flex align-items-center text-dark"
                                            id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            @if ($post->employer->user->profile_picture)
                                                <img src="{{ asset('storage/' . $post->employer->user->profile_picture) }}"
                                                    alt="{{ $post->employer->user->name }}"
                                                    class="navbar-profile-img">
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
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button"
                                    id="applicationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Application
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="applicationDropdown"
                                    style="text-align: center; background-color: rgb(207, 200, 200)">
                                    <li>
                                        @php
                                            $deadline = \Carbon\Carbon::parse($post->application_deadline);
                                            $deadlineAddOneDay = $deadline->addDay();
                                        @endphp

                                        @if (now()->greaterThan($deadlineAddOneDay))
                                            <!-- Application deadline passed message -->
                                            <p class="text-danger">Application Deadline Passed</p>
                                        @else
                                            <!-- Application form -->
                                            @if ($errors->any())
                                                <script>
                                                    let errorMessages = '';
                                                    @foreach ($errors->all() as $error)
                                                        errorMessages += "{{ $error }}\n";
                                                    @endforeach
                                                    alert(errorMessages);
                                                </script>
                                            @endif
                                            <form action="{{ route('application.store', $post->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="resume" class="form-label">Your CV OR Resume</label>
                                                    <input type="file" class="form-control" id="resume"
                                                        name="resume">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email"
                                                        value="{{ Auth::user()->email }}" name="email"
                                                        placeholder="Your email">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Mobile Phone</label>
                                                    <input type="text" class="form-control" id="phone"
                                                        name="phone" placeholder="Your mobile phone">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            <p class="card-text"><strong>Application Deadline:
                                </strong>{{ $post->application_deadline }}</p>
                            @if ($post->image)
                                <div class="card-footer p-0">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Company Image"
                                        class="img-fluid" style="width: 100%;">
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
                            <button class="btn btn-light share-button"
                                data-posting-id="{{ $post->id }}">Share</button>
                        </div>
                        <div class="comment-section" style="display: none;">
                            <textarea class="comment-input form-control" placeholder="Write your comment..."></textarea>
                            <button class="btn btn-primary post-comment-button"
                                data-posting-id="{{ $post->id }}">Post Comment</button>
                            <div class="comments-list">
                                @foreach ($post->postActions->where('action_type', 'comment') as $comment)
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
            @endif
        </section>
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
                            var deleteUrl = `/admin/delete/${data.comment_id}/comment`;
                            commentsList.insertAdjacentHTML('beforeend', `
                                <div class="comment d-flex align-items-start mt-3">
                                    <div class="user-info d-flex align-items-center mb-3">
                                        <div class="dropdown">
                                            <a href="#" class="d-flex align-items-center text-dark " id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
