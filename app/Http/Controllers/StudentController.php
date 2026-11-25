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
        $grades = $student->grades()->with('course')->get();
        $average = $grades->avg('note') ?? 0;
        $classes = \App\Models\ClassRoom::all();
        $courses = \App\Models\Course::all(); // <-- Hna zedna hadhi
        
        return view('students.show', compact('student', 'grades', 'average', 'classes', 'courses'));
    }

       public function addAbsence(Request $request, Student $student)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|date',
            'justifiee' => 'nullable|boolean',
        ]);
          
        $student->absences()->create([
            'course_id' => $request->course_id,
            'date' => $request->date,
            'justifiee' => $request->has('justifiee') ? 1 : 0,
        ]);
      // Zidna hadhi bch yjih notification
        $student->user->notify(new \App\Notifications\NewGradeNotification(
            'Une nouvelle note a été ajoutée en ' . $request->course_id
        ));
        return redirect()->back()->with('success', 'Absence ajoutée avec succès.');
    }
          

    
       

        public function bulletin(Student $student)
    {
        $grades = $student->grades()->with('course')->get();
        
        // N7seb el moyenne (average) hna
        $average = $grades->avg('note') ?? 0; 

        return view('students.bulletin', compact('student', 'grades', 'average'));
    }
      public function downloadBulletin(Student $student)
    {
        $grades = $student->grades()->with('course')->get();
        $average = $grades->avg('note') ?? 0;

        // N7adher el HTML elli bech ykoun fil PDF
        $html = view('students.bulletin_pdf', compact('student', 'grades', 'average'))->render();

        // Nesta3mlou DomPDF bch nsayrou PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
        
        // N7adherou esm el fichier
        $fileName = 'bulletin_' . str_replace(' ', '_', $student->user->name) . '.pdf';

        // N-téléchargiw el fichier
        return $pdf->download($fileName);
    }
        public function addGrade(Request $request, Student $student)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'note' => 'required|numeric|min:0|max:20',
            'type' => 'required|string',
        ]);
                
        $student->grades()->create([
            'course_id' => $request->course_id,
            'note' => $request->note,
            'type' => $request->type,
            'date' => now(), // Wala tzid date mn formulaire
        ]);
        // Zidna hadhi bch yjih notification
        $student->user->notify(new \App\Notifications\NewGradeNotification(
            'Une nouvelle note a été ajoutée en ' . $request->course_id
        ));

        return redirect()->back()->with('success', 'Note ajoutée avec succès.');
    }
            public function myProfile()
    {
        $student = auth()->user()->student;
        if (!$student) {
            abort(404, 'Profil étudiant non trouvé.');
        }
        $grades = $student->grades()->with('course')->get();
        $average = $grades->avg('note') ?? 0;
        
        // Zidna hadhi bch el formulaire mte3 el notes y5dem (7atta ila ma yest7a9'hech l'etudiant)
        $courses = \App\Models\Course::all(); 

        return view('students.show', compact('student', 'grades', 'average', 'courses'));
    }
        public function absences(Student $student)
    {
        // N7emmiw: l'étudiant ychouf ghir les absences mte3ou
        if (auth()->user()->hasRole('student') && auth()->user()->student->id !== $student->id) {
            abort(403, 'Vous ne pouvez voir que vos propres absences.');
        }

        $absences = $student->absences()->with('course')->get();
        $courses = \App\Models\Course::all();
        return view('students.absences', compact('student', 'absences', 'courses'));
    }
        public function edit(Student $student)
    {
        $classes = \App\Models\ClassRoom::all();
        return view('students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'class_id' => 'required|exists:classes,id',
            'date_naissance' => 'nullable|date',
        ]);

        $student->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $student->update([
            'class_id' => $request->class_id,
            'date_naissance' => $request->date_naissance,
        ]);

        return redirect()->route('students.index')->with('success', 'Étudiant mis à jour.');
    }
}