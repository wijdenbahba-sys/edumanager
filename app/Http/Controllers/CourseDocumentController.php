<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseDocumentController extends Controller
{
       public function index()
    {
        // Njibou les cours m3a el prof w el documents mte3hom
        $courses = Course::with(['teacher.user', 'documents'])->get();
        return view('documents.index', compact('courses'));
    }

    public function create()
    {
        // Ghir l'admin w l'prof ynejjem yzid document
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('teacher')) {
            abort(403, 'Action non autorisée.');
        }
        $courses = Course::all();
        return view('documents.create', compact('courses'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('teacher')) {
            abort(403);
        }

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:cours,tp,td,examen',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:5120',
        ]);

        // N7ottou el fichier fil dossier storage/app/public/documents
        $path = $request->file('file')->store('documents', 'public');

        CourseDocument::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'type' => $request->type,
            'file_path' => $path,
        ]);

        return redirect()->route('documents.index')->with('success', 'Document ajouté avec succès.');
    }

    public function destroy(CourseDocument $document)
    {
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('teacher')) {
            abort(403);
        }
        $document->delete();
        return redirect()->route('documents.index')->with('success', 'Document supprimé.');
    }
        public function show(Course $course)
    {
        $documents = $course->documents;
        return view('documents.show', compact('course', 'documents'));
    }
}