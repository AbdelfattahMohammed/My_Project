<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with {{ $user->name }}</title>
    <style>
        /* Container Styles */
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

        /* Back Arrow */
        .back-arrow {
            position: absolute;
            top: 5px;
            left: 10px;
            font-size: 24px;
            text-decoration: none;
            color: #333;
        }

        .back-arrow:hover {
            color: #74ebd5;
        }

        /* User List (index) */
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

        /* Chat Page (show) */
        .chat-container {
            width: 100%;
            max-width: 600px;
        }

        .chat-header {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .chat-user-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }

        .chat-user-name {
            font-size: 1.5rem;
            color: #333;
            font-weight: bold;
        }

        .messages {
            margin-bottom: 20px;
            max-height: 400px;
            overflow-y: auto;
        }

        .message-incoming {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            text-align: left;
        }

        .message-outgoing {
            background-color: #d1e7dd;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            text-align: right;
        }

        .chat-form {
            display: flex;
            gap: 10px;
        }

        .chat-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .chat-send-btn {
            padding: 10px 20px;
            background-color: #74ebd5;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .chat-send-btn:hover {
            background-color: #66d9c2;
        }
    </style>
</head>

<body>
    <div class="container chat-container">
        <!-- Back to chat index arrow -->
        <a href="{{ route('chat.index') }}" class="back-arrow">&larr;</a>

        <div class="chat-header">
            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQu4TUtAk_tgrdgaKzCjHKehGKvBynfcxd9GA&s' }}" alt="{{ $user->name }}" class="chat-user-img">
            <h3 class="chat-user-name">{{ $user->name }}</h3>
        </div>

        <div class="messages">
            @foreach ($messages as $message)
                <p class="{{ $message->sender_id == Auth::id() ? 'message-outgoing' : 'message-incoming' }}">
                    <strong>{{ $message->sender_id == Auth::id() ? 'You' : $user->name }}:</strong>
                    {{ $message->message }}
                </p>
            @endforeach
        </div>

        <!-- Form to send a new message -->
        <form action="{{ route('chat.send', $user->id) }}" method="POST" class="chat-form">
            @csrf
            <input type="text" name="message" placeholder="Type a message" class="chat-input">
            <button type="submit" class="chat-send-btn">Send</button>
        </form>
    </div>
</body>

</html>
