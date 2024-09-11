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

        /* Custom class for image preview container */
        .custom-image-preview {
            width: 150px;
            height: 150px;
            border: 2px solid #007bff;
            border-radius: 10px;
            background-size: cover;
            background-position: center center;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #ccc;
            cursor: pointer;
        }

        /* Custom class for hiding the input */
        .custom-hidden-input {
            display: none;
        }

        /* Custom class for image inside the preview */
        .custom-image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
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

        <div class="profile-header">
            <div class="d-flex align-items-center">
                <div class="image-preview-container">
                    @if (Auth::user()->profile_picture)
                        <img id="imagePreview" src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                            alt="{{ htmlspecialchars(Auth::user()->name) }}" class="image-preview">
                    @else
                        <img id="imagePreview"
                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQu4TUtAk_tgrdgaKzCjHKehGKvBynfcxd9GA&s"
                            alt="Default Profile Image" class="image-preview">
                    @endif
                    <label for="profile_picture" class="custom-file-label">Change</label>
                </div>
                <div class="ms-4">
                    <h1>{{ htmlspecialchars(Auth::user()->name) }}</h1>
                    <p><strong>Email:</strong> {{ htmlspecialchars(Auth::user()->email) }}</p>
                </div>
            </div>
        </div>

        <!-- Form to edit user information -->
        <form action="{{ route('employer.update', Auth::user()->employer->id) }}" method="POST"
            enctype="multipart/form-data">
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
                        value="{{ old('name', Auth::user()->name) }}">
                </div>

                <!-- Resume Field -->
                <div class="form-group">
                    <label for="company_name">Company Name</label>
                    <input type="text" id="company_name" name="company_name" class="form-control"
                        value="{{ old('company_name', Auth::user()->employer->company_name ?? '') }}">
                </div>

                <div class="container mt-5">
                    <div class="form-group">
                        <label for="companyLogo" class="form-label">Company Logo</label>
                        <div class="custom-image-preview" id="image-Preview"
                            onclick="document.getElementById('companyLogo').click();">
                            <span>Click to upload</span>
                        </div>
                        <input type="file" class="form-control custom-hidden-input" id="companyLogo"
                            name="company_logo" accept="image/*" onchange="previewImage(event)">
                    </div>
                </div>

                <!-- Experience Level Field -->
                <div class="form-group">
                    <label for="company_description">Company Description</label>
                    <input type="text" id="company_description" name="company_description" class="form-control"
                        value="{{ old('company_description', Auth::user()->employer->company_description) }}">
                </div>

                <!-- Location Field -->
                <div class="form-group">
                    <label for="website">Website Link ( Your Organization )</label>
                    <input type="text" id="website" name="website" class="form-control"
                        value="{{ old('website', Auth::user()->employer->website) }}">
                </div>

                <div class="form-group">
                    <label for="contact_info">Contact Info</label>
                    <textarea id="contact_info" name="contact_info" rows="2" class="form-control">{{ old('contact_info', Auth::user()->employer->contact_info) }}</textarea>
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="d-flex justify-content-between mb-5 mt-2">
                    <button type="submit" class="btn btn-custom mt-3">Save Changes</button>
                    <a href="{{ route('portfolio', Auth::user()->id) }}" class="btn btn-cancel mt-3">Cancel</a>
                    <a href="{{ route('employer.password.change') }}" class="btn btn-primary mt-3 ms-3">Change
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const existingImageUrl =
            '{{ Storage::url(Auth::user()->employer->company_logo) }}'; // Generate URL for storage path
            const preview = document.getElementById('image-Preview');

            if (existingImageUrl && existingImageUrl !== 'null') { // Check if URL is valid
                preview.style.backgroundImage = `url(${existingImageUrl})`;
                preview.querySelector('span').style.display = 'none';
            } else {
                preview.style.backgroundImage = '';
                preview.querySelector('span').style.display = 'block';
            }
        });

        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('image-Preview');
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.style.backgroundImage = `url(${e.target.result})`;
                    preview.querySelector('span').style.display = 'none';
                }
                reader.readAsDataURL(file);
            } else {
                // Handle case where no file is selected
                preview.style.backgroundImage = '';
                preview.querySelector('span').style.display = 'block';
            }
        }
    </script>

</body>

</html>
