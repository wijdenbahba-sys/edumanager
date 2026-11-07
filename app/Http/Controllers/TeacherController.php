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
}