<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\CourseDocumentController;
use App\Http\Controllers\ScheduleController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // Statistiques de base
    $totalStudents = \App\Models\Student::count();
    $totalTeachers = \App\Models\Teacher::count();
    $totalCourses = \App\Models\Course::count();
    $totalAbsences = \App\Models\Absence::count();
    
    // Moyennes et notes
    $averageGrade = \App\Models\Grade::avg('note') ?? 0;
    $totalGrades = \App\Models\Grade::count();
    
    // Dernières absences
    $recentAbsences = \App\Models\Absence::with(['student.user', 'course'])->latest()->take(5)->get();
    
    // Taux de réussite (notes >= 10)
    $passedGrades = \App\Models\Grade::where('note', '>=', 10)->count();
    $successRate = $totalGrades > 0 ? round(($passedGrades / $totalGrades) * 100, 1) : 0;

    // Variables mte3 el Graphique (Chart.js)
    $courses = \App\Models\Course::with('grades')->get();
    $chartLabels = $courses->pluck('nom');
    $chartData = $courses->map(function ($course) {
        return $course->grades->avg('note') ?? 0;
    });

    return view('dashboard', compact(
        'totalStudents', 
        'totalTeachers', 
        'totalCourses', 
        'totalAbsences',
        'averageGrade',
        'totalGrades',
        'recentAbsences',
        'successRate',
        'chartLabels',
        'chartData'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'verified'])->group(function () {
    // Routes mte3 el ressources
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('absences', AbsenceController::class);
    Route::resource('grades', GradeController::class);
    Route::resource('classes', ClassRoomController::class);
Route::resource('grades', GradeController::class);
    // Routes spéciales
    Route::get('/students/{student}/bulletin', [StudentController::class, 'bulletin'])->name('students.bulletin');
        Route::get('students/{student}/absences', [StudentController::class, 'absences'])->name('students.absences');

});
// Zid hadhom ta7t les routes mte3 students wala f ay blasa fi l'groupe mte3 auth
Route::get('students/{student}/absences', [App\Http\Controllers\StudentController::class, 'absences'])->name('students.absences');
Route::get('students/{student}/bulletin/download', [App\Http\Controllers\StudentController::class, 'downloadBulletin'])->name('students.bulletin.download');

Route::post('students/{student}/grades', [App\Http\Controllers\StudentController::class, 'addGrade'])->name('students.addGrade');
Route::post('students/{student}/absences', [App\Http\Controllers\StudentController::class, 'addAbsence'])->name('students.addAbsence');

// El routes mte3 el Admin (kol chay)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('teachers', TeacherController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('classes', ClassRoomController::class);
    // El Admin ynejjem yna7i étudiants w yzidhom
    Route::delete('students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
});

// El routes mte3 el Admin w el Prof
Route::middleware(['auth', 'role:admin,teacher'])->group(function () {
    Route::resource('students', StudentController::class)->except(['destroy']);
    Route::resource('absences', AbsenceController::class);
    Route::resource('grades', GradeController::class);
    Route::get('students/{student}/bulletin', [StudentController::class, 'bulletin'])->name('students.bulletin');
    Route::get('students/{student}/bulletin/download', [StudentController::class, 'downloadBulletin'])->name('students.bulletin.download');
    Route::post('students/{student}/absences', [StudentController::class, 'addAbsence'])->name('students.addAbsence');
    Route::post('students/{student}/grades', [StudentController::class, 'addGrade'])->name('students.addGrade');
});

// El routes mte3 el Etudiant (ghir elli ykhoussou)
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/my-profile', [StudentController::class, 'myProfile'])->name('students.myProfile');
});
Route::get('/notifications', function () {
    $notifications = auth()->user()->notifications;
    auth()->user()->unreadNotifications->markAsRead(); // N7ottouhom m9riyin
    return view('notifications.index', compact('notifications'));
})->middleware('auth')->name('notifications.index');
use App\Http\Controllers\MessageController;

Route::middleware('auth')->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'chat'])->name('messages.chat');
    Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');
    Route::resource('documents', CourseDocumentController::class);  

    });
Route::get('/messages/new', function (\Illuminate\Http\Request $request) {
    if ($request->has('user_id')) {
        return redirect()->route('messages.chat', $request->user_id);
    }
    return redirect()->route('messages.index');
})->middleware('auth')->name('messages.create');

Route::resource('schedules', ScheduleController::class)->only(['index', 'store', 'destroy']);
use App\Http\Controllers\PaymentController;

Route::middleware('auth')->group(function () {
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::post('/payments/{payment}/pay', [PaymentController::class, 'markAsPaid'])->name('payments.pay');
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
});
Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');
use App\Http\Controllers\ExportController;

Route::get('/export/students', [ExportController::class, 'students'])->name('export.students');
Route::get('/export/grades', [ExportController::class, 'grades'])->name('export.grades');



require __DIR__.'/auth.php';

