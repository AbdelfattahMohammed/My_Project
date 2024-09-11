<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .btn-custom {
            background-color: #28a745;
            /* Updated color */
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
            background-color: #218838;
            /* Updated color */
            transform: scale(1.02);
        }

        .btn-custom:focus,
        .btn-custom:active {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.5);
            /* Updated shadow color */
        }

        .btn-cancel {
            background-color: #fd7e14;
            /* Updated color */
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

        .btn-cancel:hover {
            background-color: #e36c0a;
            /* Updated color */
            transform: scale(1.02);
        }

        .btn-cancel:focus,
        .btn-cancel:active {
            box-shadow: 0 0 0 0.2rem rgba(253, 126, 20, 0.5);
            /* Updated shadow color */
        }

        .contact-info strong {
            color: #007bff;
        }

        .image-preview-container {
            position: relative;
            width: 120px;
            height: 120px;
            margin-bottom: 15px;
        }

        .image-preview {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
        }

        .custom-file-input {
            display: none;
        }

        .custom-file-label {
            display: inline-block;
            width: 100%;
            text-align: center;
            cursor: pointer;
            background-color: #007bff;
            color: #ffffff;
            border-radius: 50%;
            padding: 5px;
            margin-top: -35px;
            position: absolute;
            bottom: 0;
            left: 0;
            font-size: 14px;
            font-weight: bold;
        }
    </style>

</head>

<body>

    @if ($errors->any())
        <div class="alert alert-danger mt-4">
            <strong>There were some problems with your input:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container mt-5">
        <a href="{{ url()->previous() }}" class="back-link">
            <i class="bi bi-arrow-left"></i> Back
        </a>

        <div class="profile-header">
            <div class="d-flex align-items-center">
                <div class="image-preview-container">
                    @if ($user->profile_picture)
                        <img id="imagePreview" src="{{ asset('storage/' . $user->profile_picture) }}"
                            alt="{{ htmlspecialchars($user->name) }}" class="image-preview">
                    @else
                        <img id="imagePreview"
                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQu4TUtAk_tgrdgaKzCjHKehGKvBynfcxd9GA&s"
                            alt="Default Profile Image" class="image-preview">
                    @endif
                    <label for="profile_picture" class="custom-file-label">Change</label>
                </div>
                <div class="ms-4">
                    <h1>{{ htmlspecialchars($user->name) }}</h1>
                    <p><strong>Email:</strong> {{ htmlspecialchars($user->email) }}</p>
                </div>
            </div>
        </div>

        <!-- Form to edit user information -->
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="profile-body">
                <h2>Edit Information</h2>

                <!-- Profile Picture Field -->
                <div class="form-group">
                    <input type="file" id="profile_picture" name="profile_picture" class="custom-file-input">
                </div>

                <!-- Name Field -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control"
                        value="{{ old('name', $user->name) }}">
                </div>

                <!-- Resume Field -->
                <div class="form-group">
                    <label for="resume">Resume</label>
                    <input type="file" id="resume" name="resume" class="form-control"
                        value="{{ old('resume', $candidate->resume ?? '') }}">
                </div>

                <!-- Skills Field -->
                <div class="form-group">
                    <label for="skills">Skills</label>
                    <input type="text" id="skills" name="skills" class="form-control"
                        value="{{ old('skills', $candidate->skills) }}">
                </div>

                <!-- Experience Level Field -->
                <div class="form-group">
                    <label for="experience_level">Experience Level</label>
                    <input type="text" id="experience_level" name="experience_level" class="form-control"
                        value="{{ old('experience_level', $candidate->experience_level) }}">
                </div>

                <!-- Location Field -->
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" class="form-control"
                        value="{{ old('location', $candidate->location) }}">
                </div>

                <!-- Contact Info Field -->
                <div class="form-group">
                    <label for="contact_info">Contact Info</label>
                    <textarea id="contact_info" name="contact_info" class="form-control">{{ old('contact_info', $candidate->contact_info) }}</textarea>
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="d-flex justify-content-between mb-5 mt-2">
                    <button type="submit" class="btn btn-custom mt-3">Save Changes</button>
                    <a href="{{ route('portfolio', Auth::user()->id) }}" class="btn btn-cancel mt-3">Cancel</a>
                    <a href="{{ route('candidate.password.change') }}" class="btn btn-primary mt-3 ms-3">Change
                        Password</a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Image Preview Script -->
    <script>
        document.getElementById('profile_picture').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        });
    </script>
</body>

</html>
