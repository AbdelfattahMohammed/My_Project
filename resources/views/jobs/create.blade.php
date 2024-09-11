<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create New Post</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .image-input {
            display: block;
            width: 100%;
            height: 200px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
        }

        .image-input input[type="file"] {
            display: none;
        }

        /* .image-preview {
            display: none;
        } */

        .image-upload-button {
            display: block;
            margin-top: 10px;
            text-align: center;
        }

        .btn-upload {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            border: none;
        }

        .btn-upload:hover {
            background-color: #0056b3;
        }

        .form-container {
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #f9f9f9;
            margin-top: 30px;
        }

        .form-row {
            margin-bottom: 15px;
        }

        .submit-buttons {
            margin-top: 20px;
        }

        .submit-buttons button {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container my-4">
        <h1 class="mb-4 text-center">Create a New Post</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="form-container">
            <form action="{{ route('posting.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Row 1 -->
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" class="form-control" required>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="responsibilities">Responsibilities</label>
                        <textarea id="responsibilities" name="responsibilities" class="form-control" rows="2" required></textarea>
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="required_skills">Required Skills</label>
                        <textarea id="required_skills" name="required_skills" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="qualifications">Qualifications</label>
                        <textarea id="qualifications" name="qualifications" class="form-control" rows="2" required></textarea>
                    </div>
                </div>

                <!-- Row 4 -->
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="salary_range">Salary Range</label>
                        <input type="number" id="salary_range" name="salary_range" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="benefits">Benefits</label>
                        <textarea id="benefits" name="benefits" class="form-control" rows="2" required></textarea>
                    </div>
                </div>

                <!-- Row 5 -->
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="work_type">Work Type</label>
                        <select id="work_type" name="work_type" class="form-control" required>
                            <option value="" disabled selected>Select Work Type</option>
                            <option value="on-site">Onsite</option>
                            <option value="remote">Remote</option>
                            <option value="hybrid">Hybrid</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="application_deadline">Application Deadline</label>
                        <input type="date" id="application_deadline" name="application_deadline" class="form-control" required>
                    </div>
                </div>

                <!-- Image Upload Input -->
                <div class="form-row">
                    <div class="col-md-12">
                        <label for="image">Job Image</label>
                        <div class="image-input" id="imageInput"></div>
                        <div class="image-upload-button">
                            <label for="image" class="btn-upload">Click to choose an image</label>
                            <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror d-none" onchange="previewImage(event)">
                        </div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="submit-buttons text-center">
                    <button type="submit" class="btn btn-primary">Create Post</button>
                    <a class="btn btn-danger" href="{{ url()->previous() }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Image Preview JavaScript -->
    <script>
        function previewImage(event) {
            const input = event.target;
            const reader = new FileReader();
            reader.onload = function() {
                const imageInput = document.getElementById('imageInput');
                imageInput.style.backgroundImage = `url(${reader.result})`;
            }
            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</body>

</html>
