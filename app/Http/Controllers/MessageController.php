<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // El page mte3 el chat (liste mte3 les contacts)
           public function index()
    {
        $authId = Auth::id();

        // 1. Njibou les IDs mte3 les users elli 3andna m3ahom messages
        $contactIds = Message::where('sender_id', $authId)->pluck('receiver_id')
            ->merge(Message::where('receiver_id', $authId)->pluck('sender_id'))
            ->unique();

        // 2. Njibou les users hedhom m3a ekher message (kima WhatsApp)
        $contacts = User::whereIn('id', $contactIds)->get()->map(function ($user) use ($authId) {
            $lastMessage = Message::where(function($q) use ($user, $authId) {
                $q->where('sender_id', $authId)->where('receiver_id', $user->id);
            })->orWhere(function($q) use ($user, $authId) {
                $q->where('sender_id', $user->id)->where('receiver_id', $authId);
            })->latest()->first();

            $user->last_message = $lastMessage ? $lastMessage->content : 'Aucun message';
            $user->last_message_time = $lastMessage ? $lastMessage->created_at->diffForHumans() : '';
            return $user;
        });

        // 3. Njibou les users lkol bch n7ottouhom fil "Nouveau message"
        $allUsers = User::where('id', '!=', $authId)->get();

        return view('messages.index', compact('contacts', 'allUsers'));
    }

    // El chat m3a user mo3ayan
       public function chat(User $user)
    {
        // Hna njibou les messages bin el user elli connecté w el user elli m3ah
        $messages = Message::where(function($q) use ($user) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $user->id);
        })->orWhere(function($q) use ($user) {
            $q->where('sender_id', $user->id)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        // N7ottouhom m9riyin (5ater el user 7el el chat)
        Message::where('sender_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->update(['is_read' => true]);
       
        return view('messages.chat', compact('user', 'messages'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate(['content' => 'required|string']);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'content' => $request->input('content'), // Wala $request->content
        ]);

        return redirect()->route('messages.chat', $user->id);
    }
}