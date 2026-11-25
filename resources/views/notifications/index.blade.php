@extends('layouts.admin')

@section('title', 'Notifications')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Toutes les notifications</h2>
        <ul class="space-y-4">
            @forelse($notifications as $notification)
                <li class="p-4 rounded-lg bg-gray-50 border-l-4 {{ $notification->read_at ? 'border-gray-300' : 'border-blue-500' }}">
                    <p class="text-gray-800">{{ $notification->data['message'] }}</p>
                    <span class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                </li>
            @empty
                <li class="text-center text-gray-500">Aucune notification pour le moment.</li>
            @endforelse
        </ul>
    </div>
@endsection