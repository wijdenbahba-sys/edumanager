@extends('layouts.admin')

@section('title', 'Chat avec ' . $user->name)

@section('content')
    <style>
        .chat-container { max-width: 700px; margin: 0 auto; background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); display: flex; flex-direction: column; height: 75vh; overflow: hidden; }
        .chat-header { padding: 15px 20px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 15px; background: #f9fafb; }
        .chat-header a { text-decoration: none; color: #2563eb; font-size: 20px; font-weight: bold; }
        .avatar { width: 40px; height: 40px; border-radius: 50%; background: #2563eb; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px; }
        .chat-messages { flex: 1; padding: 20px; overflow-y: auto; background: #f3f4f6; display: flex; flex-direction: column; gap: 10px; }
        .message { max-width: 75%; padding: 10px 15px; border-radius: 15px; font-size: 15px; line-height: 1.4; }
        .message.sent { background: #2563eb; color: white; align-self: flex-end; border-bottom-right-radius: 2px; }
        .message.received { background: white; color: #1f2937; align-self: flex-start; border: 1px solid #e5e7eb; border-bottom-left-radius: 2px; }
        .chat-input { padding: 15px 20px; border-top: 1px solid #e5e7eb; display: flex; gap: 10px; background: white; }
        .chat-input input { flex: 1; padding: 12px 15px; border: 1px solid #d1d5db; border-radius: 8px; outline: none; font-size: 15px; }
        .chat-input input:focus { border-color: #2563eb; }
        .chat-input button { background: #2563eb; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: bold; cursor: pointer; transition: background 0.2s; }
        .chat-input button:hover { background: #1d4ed8; }
    </style>

    <div class="chat-container">
        <!-- Header -->
        <div class="chat-header">
            <a href="{{ route('messages.index') }}">←</a>
            <div class="avatar">{{ substr($user->name, 0, 1) }}</div>
            <h2 style="margin: 0; font-size: 18px; color: #1f2937;">{{ $user->name }}</h2>
        </div>

        <!-- Messages -->
        <div class="chat-messages">
            @forelse($messages as $message)
                <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
                    {{ $message->content }}
                </div>
            @empty
                <div style="text-align: center; color: #6b7280; margin-top: 20px;">Aucun message pour le moment. Commencez la conversation !</div>
            @endforelse
        </div>

        <!-- Input -->
        <form action="{{ route('messages.store', $user->id) }}" method="POST" class="chat-input">
            @csrf
            <input type="text" name="content" placeholder="Écrivez un message..." required autocomplete="off">
            <button type="submit">Envoyer</button>
        </form>
    </div>
@endsection