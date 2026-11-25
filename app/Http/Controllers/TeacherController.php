<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->paginate(10);
        return view('teachers.index', compact('teachers'));
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->user->delete(); // Supprime l'utilisateur et le prof par cascade
        return redirect()->route('teachers.index')->with('success', 'Enseignant supprimé !');
    }
        public function create()
    {
        return view('teachers.create');
    }
        public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $teacher->user_id,
            'matiere_principale' => 'required|string',
        ]);

        // Nbadlou el user (nom w email)
        $teacher->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Nbadlou el matiere
        $teacher->update([
            'matiere_principale' => $request->matiere_principale,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Enseignant mis à jour avec succès.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'matiere_principale' => 'required|string',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        
        $user->assignRole('teacher');

        \App\Models\Teacher::create([
            'user_id' => $user->id,
            'matiere_principale' => $request->matiere_principale,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Enseignant ajouté.');
    }

    public function show(Teacher $teacher)
    {
        return view('teachers.show', compact('teacher'));
    }

  
    
}