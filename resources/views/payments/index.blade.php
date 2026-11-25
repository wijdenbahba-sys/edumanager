@extends('layouts.admin')

@section('title', 'Gestion des Paiements')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">💰 Gestion des Paiements</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulaire mte3 l'ajout (Ghir l'admin) -->
    @if(Auth::user()->hasRole('admin'))
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-700 mb-3">Ajouter un paiement</h2>
        <form action="{{ route('payments.store') }}" method="POST" class="flex flex-wrap gap-3 items-end">
            @csrf
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm text-gray-600 mb-1">Étudiant</label>
                <select name="student_id" class="w-full border rounded px-3 py-2" required>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-40">
                <label class="block text-sm text-gray-600 mb-1">Mois</label>
                <select name="month" class="w-full border rounded px-3 py-2" required>
                    <option value="Janvier">Janvier</option>
                    <option value="Février">Février</option>
                    <option value="Mars">Mars</option>
                    <option value="Avril">Avril</option>
                    <option value="Mai">Mai</option>
                    <option value="Juin">Juin</option>
                </select>
            </div>
            <div class="w-32">
                <label class="block text-sm text-gray-600 mb-1">Montant (DT)</label>
                <input type="number" name="amount" class="w-full border rounded px-3 py-2" required>
            </div>
            <!-- Zidna had el champ mte3 Statut -->
            <div class="w-40">
                <label class="block text-sm text-gray-600 mb-1">Statut</label>
                <select name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="non_paye">Non payé</option>
                    <option value="paye">Payé</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded h-10">
                Ajouter
            </button>
        </form>
    </div>
    @endif

    <!-- Tableau mte3 les paiements -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-4">Étudiant</th>
                    <th class="py-3 px-4">Mois</th>
                    <th class="py-3 px-4">Montant</th>
                    <th class="py-3 px-4">Statut</th>
                    <th class="py-3 px-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse($payments as $payment)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="py-3 px-4 font-medium">{{ $payment->student->user->name }}</td>
                        <td class="py-3 px-4">{{ $payment->month }}</td>
                        <td class="py-3 px-4 font-bold text-gray-800">{{ $payment->amount }} DT</td>
                        <td class="py-3 px-4">
                            @if($payment->status === 'paye')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">Payé</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">Non payé</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center">
                            @if(Auth::user()->hasRole('admin'))
                                @if($payment->status === 'non_paye')
                                    <form action="{{ route('payments.pay', $payment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-2 py-1 rounded text-xs font-bold">Marquer payé</button>
                                    </form>
                                @endif
                                <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');" class="inline ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline text-xs font-bold">Supprimer</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">Aucun paiement enregistré.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection