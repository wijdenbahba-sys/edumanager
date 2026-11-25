<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassRoom;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Absence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $teacherRole = Role::create(['name' => 'teacher']);
        $studentRole = Role::create(['name' => 'student']);

        // 1. Admin
        $admin = User::create(['name' => 'Admin Principal', 'email' => 'admin@edumanager.com', 'password' => Hash::make('password')]);
        $admin->assignRole('admin');

        // 2. Classes
        $class1 = ClassRoom::create(['nom' => '1ère A', 'niveau' => '1ère']);
        $class2 = ClassRoom::create(['nom' => '2ème B', 'niveau' => '2ème']);
        $class3 = ClassRoom::create(['nom' => '3ème C', 'niveau' => '3ème']);

        // 3. Teachers (5)
        $teachers = [];
        $matieres = ['Mathématiques', 'Physique', 'Français', 'Anglais', 'Histoire'];
        foreach ($matieres as $index => $matiere) {
            $user = User::create(['name' => 'Prof ' . $matiere, 'email' => 'prof' . $index . '@edumanager.com', 'password' => Hash::make('password')]);
            $user->assignRole('teacher');
            $teachers[] = Teacher::create(['user_id' => $user->id, 'matiere_principale' => $matiere]);
        }

        // 4. Courses
        $courses = [];
        foreach ($teachers as $index => $teacher) {
            $courses[] = Course::create(['nom' => $matieres[$index], 'teacher_id' => $teacher->id, 'class_id' => $class1->id]);
        }

        // 5. Students (10)
        $students = [];
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create(['name' => 'Etudiant ' . $i, 'email' => 'etudiant' . $i . '@edumanager.com', 'password' => Hash::make('password')]);
            $user->assignRole('student');
            $students[] = Student::create(['user_id' => $user->id, 'class_id' => $class1->id, 'date_naissance' => '2005-01-0' . ($i % 9 + 1)]);
        }

        // 6. Grades & Absences (Bch el Dashboard y3ammar)
        foreach ($students as $student) {
            foreach ($courses as $course) {
                // Des notes
                Grade::create(['student_id' => $student->id, 'course_id' => $course->id, 'note' => rand(10, 20), 'type' => 'devoir', 'date' => now()]);
                // Des absences
                if (rand(0, 1)) {
                    Absence::create(['student_id' => $student->id, 'course_id' => $course->id, 'date' => now(), 'justifiee' => rand(0, 1)]);
                }
            }
        }
    }
}