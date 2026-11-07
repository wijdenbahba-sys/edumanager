<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
       public function index(Request $request)
    {
        // On commence la requête avec les relations
        $query = Student::with(['user', 'classRoom']);

        // Si on a tapé quelque chose dans la recherche
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Si on a sélectionné une classe dans le menu déroulant
        if ($request->has('class_id') && $request->class_id != '') {
            $query->where('class_id', $request->class_id);
        }

        $students = $query->paginate(10);
        
        // On récupère toutes les classes pour le menu déroulant
        $classes = \App\Models\ClassRoom::all();

        return view('students.index', compact('students', 'classes'));
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
        public function downloadBulletin(Student $student)
    {
        // On charge l'étudiant avec toutes ses relations
        $student->load(['user', 'classRoom', 'grades.course']);
        
        // On calcule sa moyenne générale
        $average = $student->grades->avg('note') ?? 0;

        // On génère le PDF avec la vue 'students.bulletin'
        $pdf = Pdf::loadView('students.bulletin', compact('student', 'average'));

        // On télécharge le fichier
        return $pdf->download('bulletin_' . str_replace(' ', '_', $student->user->name) . '.pdf');
    }
}