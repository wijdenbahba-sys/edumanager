<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});
Route::get('/dashboard', function () {
    $totalStudents = \App\Models\Student::count();
    $totalTeachers = \App\Models\Teacher::count();
    $totalCourses = \App\Models\Course::count();
    
    // Calcul de la moyenne générale de l'école
    $averageGrade = \App\Models\Grade::avg('note') ?? 0;
    
    // On prépare les données pour le graphique (Moyenne par cours)
    $courses = \App\Models\Course::all();
    $chartLabels = [];
    $chartData = [];
    foreach($courses as $c) {
        $chartLabels[] = $c->nom;
        $chartData[] = round(\App\Models\Grade::where('course_id', $c->id)->avg('note') ?? 0, 2);
    }
    
    return view('dashboard', compact('totalStudents', 'totalTeachers', 'totalCourses', 'averageGrade', 'chartLabels', 'chartData'));
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::resource('students', \App\Http\Controllers\StudentController::class)->middleware('auth');
Route::post('/students/{student}/grades', [\App\Http\Controllers\StudentController::class, 'addGrade'])->name('students.addGrade')->middleware('auth');
Route::get('/students/{student}/bulletin', [\App\Http\Controllers\StudentController::class, 'downloadBulletin'])->name('students.bulletin')->middleware('auth');
require __DIR__.'/auth.php';