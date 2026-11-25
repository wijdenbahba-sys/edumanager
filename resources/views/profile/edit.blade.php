@extends('layouts.admin')

@section('title', 'Mon Profil')

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Modifier mon profil</h2>

        @if(session('status') === 'profile-updated')
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">Profil mis à jour avec succès !</div>
        @endif

        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('patch')

            <!-- Photo -->
            <div class="flex items-center gap-4">
                @if($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo" class="w-16 h-16 rounded-full object-cover">
                @else
                    <div class="w-16 h-16 rounded-full bg-blue-600 text-white flex items-center justify-center text-xl font-bold">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Photo de profil</label>
                    <input type="file" name="photo" class="text-sm">
                </div>
            </div>

            <!-- Nom -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nom complet</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Enregistrer les modifications
            </button>
        </form>

        <!-- Section mte3 el Mot de passe -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <h3 class="text-lg font-bold text-gray-700 mb-4">Changer le mot de passe</h3>
            @include('profile.partials.update-password-form')
        </div>
    </div>
@endsection