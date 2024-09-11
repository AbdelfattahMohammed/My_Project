<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Job Posting</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .btn-primary {
            background-color: #1877f2;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #165eab;
            transform: translateY(-2px);
        }

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

        /* .image-input-label {
            display: block;
            text-align: center;
            font-size: 1.2rem;
            color: #888;
            line-height: 200px;
            cursor: pointer;
        } */

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
        }

        .image-upload-button {
            display: block;
            margin-top: 10px;
            text-align: center;
        }

        .form-row {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container my-4">
        <h1 class="mb-4 d-flex align-items-center justify-content-center">Edit Job Posting</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="form-container">
            <form action="{{ route('posting.update', $job->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Row 1 -->
                <div class="form-row mb-3">
                    <div class="col-md-6">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $job->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="salary_range">Salary</label>
                        <input type="text" id="salary_range" name="salary_range"
                            class="form-control @error('salary_range') is-invalid @enderror"
                            value="{{ old('salary_range', $job->salary_range) }}">
                        @error('salary_range')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="form-row mb-3">
                    <div class="col-md-6">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                            rows='2' required>{{ old('description', $job->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="benefits">Benefits</label>
                        <textarea id="benefits" name="benefits" class="form-control @error('benefits') is-invalid @enderror" rows='2'>{{ old('benefits', $job->benefits) }}</textarea>
                        @error('benefits')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="form-row mb-3">
                    <div class="col-md-6">
                        <label for="responsibilities">Responsibilities</label>
                        <textarea id="responsibilities" name="responsibilities"
                            class="form-control @error('responsibilities') is-invalid @enderror" rows='2' required>{{ old('responsibilities', $job->responsibilities) }}</textarea>
                        @error('responsibilities')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location"
                            class="form-control @error('location') is-invalid @enderror"
                            value="{{ old('location', $job->location) }}" required>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Row 4 -->
                <div class="form-row mb-3">
                    <div class="col-md-6">
                        <label for="required_skills">Required Skills</label>
                        <textarea id="required_skills" name="required_skills"
                            class="form-control @error('required_skills') is-invalid @enderror" rows='2' required>{{ old('required_skills', $job->required_skills) }}</textarea>
                        @error('required_skills')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="qualifications">Qualifications</label>
                        <textarea id="qualifications" name="qualifications" class="form-control @error('qualifications') is-invalid @enderror"
                            rows='2' required>{{ old('qualifications', $job->qualifications) }}</textarea>
                        @error('qualifications')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Row 5 -->
                <div class="form-row mb-3">
                    <div class="col-md-6">
                        <label for="work_type">Work Type</label>
                        <select id="work_type" name="work_type"
                            class="form-control @error('work_type') is-invalid @enderror" required>
                            <option value="remote"
                                {{ old('work_type', $job->work_type) == 'remote' ? 'selected' : '' }}>
                                Remote</option>
                            <option value="on-site"
                                {{ old('work_type', $job->work_type) == 'on-site' ? 'selected' : '' }}>
                                On-Site</option>
                            <option value="hybrid"
                                {{ old('work_type', $job->work_type) == 'hybrid' ? 'selected' : '' }}>
                                Hybrid</option>
                        </select>
                        @error('work_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="application_deadline">Application Deadline</label>
                        <input type="date" id="application_deadline" name="application_deadline"
                            class="form-control @error('application_deadline') is-invalid @enderror"
                            value="{{ old('application_deadline', $job->application_deadline) }}" required>
                        @error('application_deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Image Upload Input -->
                <div class="form-row mb-3">
                    <div class="col-md-12">
                        <label for="image">Job Image</label>
                        <div class="image-input" id="imageInput" style="background-image: url('{{ asset('storage/'.$job->image) }}');">
                        </div>
                        <div class="image-upload-button">
                            <label for="image" class="btn-upload" >Click to choose an image</label>
                            <input type="file" id="image" name="image"
                                class="form-control @error('image') is-invalid @enderror d-none"
                                onchange="previewImage(event)">
                        </div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-between text-center mt-3">
                    <button type="submit" class="btn btn-primary ">Update Job Posting</button>
                    <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
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
                // imageInput.querySelector('.image-input-label').style.display = 'none';
            }
            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>
