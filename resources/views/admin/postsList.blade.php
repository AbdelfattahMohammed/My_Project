<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Postings</title>
    <style>
        body {
            background: linear-gradient(to right, #74ebd5, #acb6e5);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            margin: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-md-4 {
            width: calc(33.333% - 20px);
            margin: 10px;
        }

        .card {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #343a40;
            margin-bottom: 15px;
        }

        .card-text {
            font-size: 14px;
            color: #495057;
            margin-bottom: 20px;
        }

        .card-footer {
            background-color: #f1f3f5;
            border-top: 1px solid #dee2e6;
            padding: 10px;
            text-align: right;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
            border: none;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .d-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        @media (max-width: 768px) {
            .col-md-4 {
                width: calc(50% - 20px);
            }
        }

        @media (max-width: 576px) {
            .col-md-4 {
                width: 100%;
                margin: 10px 0;
            }
        }

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
            z-index: 1000000;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .home-button:hover {
            background-color: #218838;
            color: #ffffff;
            transform: scale(1.15);
        }
    </style>
</head>
<body>

    <a href="{{ route('admin.index') }}" class="home-button">
        Home
    </a>

    <div class="container">
        <div class="row">
            @foreach($posts as $post)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text"><strong>Description:</strong>{{ Str::limit($post->description, 100) }}</p>
                        <p><strong>Location:</strong> {{ $post->location }}</p>
                        <p><strong>Salary Range:</strong> {{ $post->salary_range }}</p>
                    </div>
                    <div class="card-footer">
                        <!-- Accept and Refuse buttons -->
                        <div class="d-flex">
                            <form action="{{ route('admin.posts.accept', $post->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">Accept</button>
                            </form>

                            <form action="{{ route('admin.posts.refuse', $post->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger">Refuse</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</body>
</html>
