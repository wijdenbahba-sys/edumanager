<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        // On récupère les étudiants avec leur utilisateur et leur classe
        $students = Student::with(['user', 'classRoom'])->paginate(10);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $classes = ClassRoom::all();
        return view('students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'date_naissance' => 'required|date',
            'class_id' => 'required|exists:classes,id',
        ]);

        // 1. Créer l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password123'), // mot de passe par défaut
        ]);

        // 2. Créer le profil étudiant
        Student::create([
            'user_id' => $user->id,
            'class_id' => $request->class_id,
            'date_naissance' => $request->date_naissance,
        ]);

        return redirect()->route('students.index')->with('success', 'Étudiant ajouté avec succès !');
    }

    public function destroy(Student $student)
    {
        $student->user->delete(); // Supprime l'utilisateur (et l'étudiant par cascade)
        return redirect()->route('students.index')->with('success', 'Étudiant supprimé !');
    }
        public function show(Student $student)
    {
        // On charge les notes de l'étudiant avec le nom du cours
        $student->load(['user', 'classRoom', 'grades.course']);
        $courses = \App\Models\Course::all(); // Pour le menu déroulant d'ajout de note
        
        return view('students.show', compact('student', 'courses'));
    }

    public function addGrade(Request $request, Student $student)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'note' => 'required|numeric|min:0|max:20',
            'type' => 'required|string',
        ]);

        \App\Models\Grade::create([
            'student_id' => $student->id,
            'course_id' => $request->course_id,
            'note' => $request->note,
            'type' => $request->type,
            'date' => now(),
        ]);

        return redirect()->back()->with('success', 'Note ajoutée avec succès !');
    }
}