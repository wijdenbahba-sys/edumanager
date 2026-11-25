@extends('layouts.admin')

@section('title', 'Messagerie')

@section('content')
    <style>
        .msg-container { max-width: 700px; margin: 0 auto; background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow: hidden; }
        .msg-header { padding: 20px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; background: #f9fafb; }
        .msg-header h2 { margin: 0; font-size: 20px; color: #1f2937; }
        .btn-new { background: #2563eb; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-weight: bold; }
        .contact-list { list-style: none; margin: 0; padding: 0; }
        .contact-item { display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; border-bottom: 1px solid #f3f4f6; text-decoration: none; color: inherit; transition: background 0.2s; }
        .contact-item:hover { background: #f8fafc; }
        .contact-info { display: flex; align-items: center; gap: 15px; }
        .avatar { width: 45px; height: 45px; border-radius: 50%; background: #2563eb; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px; flex-shrink: 0; }
        .contact-text p { margin: 0; }
        .contact-name { font-weight: bold; color: #1f2937; font-size: 16px; }
        .contact-role { font-size: 13px; color: #6b7280; }
        .last-msg { font-size: 14px; color: #4b5563; margin-top: 3px; }
        
        /* Modal "Nouveau Message" */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999; justify-content: center; align-items: center; }
        .modal-box { background: white; padding: 30px; border-radius: 12px; max-width: 400px; width: 100%; text-align: center; }
        .modal-box select { width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 16px; }
        .modal-box button { width: 100%; padding: 12px; background: #2563eb; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; }
    </style>

    <div class="msg-container">
        <div class="msg-header">
            <h2>💬 Discussions</h2>
            <a href="#" class="btn-new" onclick="document.getElementById('newMessageModal').style.display='flex'; return false;">+ Nouveau message</a>
        </div>

        <ul class="contact-list">
            @forelse($contacts as $contact)
                <a href="{{ route('messages.chat', $contact->id) }}" class="contact-item">
                    <div class="contact-info">
                        <div class="avatar">{{ substr($contact->name, 0, 1) }}</div>
                        <div class="contact-text">
                            <p class="contact-name">{{ $contact->name }}</p>
                            <p class="last-msg">{{ $contact->last_message }}</p>
                        </div>
                    </div>
                    <span class="contact-role">{{ $contact->last_message_time }}</span>
                </a>
            @empty
                <li style="padding: 30px; text-align: center; color: #6b7280;">Aucune discussion pour le moment. Cliquez sur "Nouveau message" pour commencer.</li>
            @endforelse
        </ul>
    </div>

    <!-- Modal "Nouveau message" -->
    <div id="newMessageModal" class="modal-overlay">
        <div class="modal-box">
            <h3 style="margin-top:0; color:#1f2937;">Nouveau message</h3>
            <form action="{{ route('messages.create') }}" method="GET"> <!-- Hna bech nbadlouha l route jdida -->
                <select name="user_id" required>
                    <option value="">Choisir un destinataire...</option>
                    @foreach($allUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->getRoleNames()->first() }})</option>
                    @endforeach
                </select>
                <button type="submit">Discuter</button>
                <button type="button" onclick="document.getElementById('newMessageModal').style.display='none';" style="background: #e5e7eb; color: #4b5563; margin-top: 10px;">Annuler</button>
            </form>
        </div>
    </div>
@endsection