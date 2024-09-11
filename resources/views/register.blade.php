<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(135deg, #a8edea, #fed6e3);
            /* Beautiful gradient background */
            animation: backgroundAnimation 15s ease infinite;
            color: #333;
            /* Text color */
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @keyframes backgroundAnimation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 100%;
            max-width: 500px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .container:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.3);
        }

        .btn-primary {
            background-color: #6c63ff;
            border-color: #6c63ff;
            transition: background-color 0.3s, border-color 0.3s;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #4b47c2;
            border-color: #4b47c2;
        }

        .custom-file-upload {
            border: 1px solid #6c63ff;
            background-color: #f1f1f1;
            color: #333;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .custom-file-upload:hover {
            background-color: #6c63ff;
            color: #fff;
            border-color: #6c63ff;
        }

        .custom-file-upload img {
            border-radius: 50%;
            width: 100px;
            transition: transform 0.3s ease;
        }

        .custom-file-upload img:hover {
            transform: scale(1.1);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select,
        textarea {
            border-radius: 4px;
            border: 1px solid #6c63ff;
            padding: 10px;
            margin-bottom: 10px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus,
        textarea:focus {
            border-color: #4b47c2;
            box-shadow: 0 0 5px rgba(75, 71, 194, 0.5);
        }

        label {
            font-weight: bold;
            color: #6c63ff;
        }

        .alert-danger {
            background-color: #ffdddd;
            border-color: #f5c2c7;
            color: #842029;
        }
    </style>
</head>

<body>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container d-flex justify-content-center min-vh-100 align-items-center mt-3">
        <div class="row">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" required>
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" aria-label="Role select" name="role" id="role" required>
                        <option hidden value="">Select your role</option>
                        <option value="employer">Employer</option>
                        <option value="candidate" selected>Candidate</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <!-- Common fields -->
                <div class="mb-3">
                    <label for="profile_picture" class="form-label">Profile Picture</label>
                    <label class="custom-file-upload">
                        <img id="imagePreview" src="" alt="Profile Picture" style="display: none;">
                        <input type="file" name="profile_picture" class="custom-file-input" id="profile_picture">
                        Upload Image
                    </label>
                </div>
                <div class="mb-3">
                    <label for="contact_info" class="form-label">Contact Information</label>
                    <textarea name="contact_info" class="form-control" id="contact_info" rows="3"
                        placeholder="Enter your contact information"></textarea>
                </div>

                <!-- Candidate fields -->
                <div id="candidate-fields" class="d-none">
                    <div class="mb-3">
                        <label for="resume" class="form-label">Resume</label>
                        <input type="file" name="resume" class="form-control" id="resume">
                    </div>
                    <div class="mb-3">
                        <label for="skills" class="form-label">Skills</label>
                        <input type="text" name="skills" class="form-control" id="skills">
                    </div>
                    <div class="mb-3">
                        <label for="experience_level" class="form-label">Experience Level</label>
                        <input type="text" name="experience_level" class="form-control" id="experience_level">
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" id="location">
                    </div>
                </div>

                <!-- Employer fields -->
                <div id="employer-fields" class="d-none">
                    <div class="mb-3">
                        <label for="employer_code" class="form-label">Employer Code</label>
                        <input type="password" name="employer_code" class="form-control" id="employer_code">
                    </div>
                    <div class="mb-3">
                        <label for="company_name" class="form-label">Company Name</label>
                        <input type="text" name="company_name" class="form-control" id="company_name">
                    </div>
                    <div class="mb-3">
                        <label for="company_logo" class="form-label">Company Logo</label>
                        <input type="file" name="company_logo" class="form-control" id="company_logo">
                    </div>
                    <div class="mb-3">
                        <label for="company_description" class="form-label">Company Description</label>
                        <textarea name="company_description" class="form-control" id="company_description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="website" class="form-label">Website</label>
                        <input type="text" name="website" class="form-control" id="website">
                    </div>
                </div>

                <!-- Admin fields -->
                <div id="admin-fields" class="d-none">
                    <div class="mb-3">
                        <label for="admin_code" class="form-label">Admin Code</label>
                        <input type="password" name="admin_code" class="form-control" id="admin_code">
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" id="admin-location">
                    </div>
                </div>
                <div class="d-flex justify-content-center mb-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script>
        document.getElementById('role').addEventListener('change', function() {
            var role = this.value;
            var candidateFields = document.getElementById('candidate-fields');
            var employerFields = document.getElementById('employer-fields');
            var adminFields = document.getElementById('admin-fields');

            // Hide all fields initially
            candidateFields.classList.add('d-none');
            employerFields.classList.add('d-none');
            adminFields.classList.add('d-none');

            // Show fields based on role
            if (role === 'candidate') {
                candidateFields.classList.remove('d-none');
            } else if (role === 'employer') {
                employerFields.classList.remove('d-none');
            } else if (role === 'admin') {
                adminFields.classList.remove('d-none');
            }
        });

        // Image preview for profile picture
        document.getElementById('profile_picture').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            const imagePreview = document.getElementById('imagePreview');

            if (file) {
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '';
                imagePreview.style.display = 'none';
            }
        });
    </script>
</body>

</html>
