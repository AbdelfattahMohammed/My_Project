<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #74ebd5, #acb6e5);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            position: relative;
        }

        /* Arrow to Auth Index */
        .arrow-auth-index {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .arrow-auth-index a {
            text-decoration: none;
            font-size: 24px;
            color: #333;
        }

        .arrow-auth-index a:hover {
            color: #74ebd5;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .user-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .user-item {
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .user-item a {
            display: flex;
            align-items: center;
            text-decoration: none;
            width: 100%;
        }

        .user-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            transition: transform 0.3s ease;
        }

        .user-name {
            font-size: 1.1rem;
            color: #333;
            font-weight: bold;
        }

        .user-item:hover {
            background-color: #f0f0f0;
        }

        .user-item:hover .user-img {
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Arrow for Auth Index -->
        <div class="arrow-auth-index">
            <a href="{{ route('auth.index') }}">&#8592;</a> <!-- Arrow pointing left -->
        </div>

        <h2>{{ Auth::user()->name }} Chat</h2>
        <ul class="user-list">
            @foreach($users as $user)
            <li class="user-item">
                <a href="{{ route('chat.show', $user->id) }}">
                    <img  src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQu4TUtAk_tgrdgaKzCjHKehGKvBynfcxd9GA&s' }}" alt="{{ $user->name }}" class="user-img">
                    <span class="user-name">{{ $user->name }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</body>

</html>
