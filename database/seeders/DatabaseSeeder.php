<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Grade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer un Admin (c'est ton compte actuel, on ne le touche pas)
        
        // 2. Créer 3 Classes
        $c1 = ClassRoom::create(['nom' => '1ère A', 'niveau' => '1ère']);
        $c2 = ClassRoom::create(['nom' => '2ème B', 'niveau' => '2ème']);
        $c3 = ClassRoom::create(['nom' => 'Terminale C', 'niveau' => 'Terminale']);

        // 3. Créer 3 Enseignants
        $t1 = Teacher::create(['user_id' => User::factory()->create(['name' => 'Prof. Ahmed', 'email' => 'ahmed@test.com', 'password' => Hash::make('password')])->id, 'matiere_principale' => 'Mathématiques']);
        $t2 = Teacher::create(['user_id' => User::factory()->create(['name' => 'Prof. Sarah', 'email' => 'sarah@test.com', 'password' => Hash::make('password')])->id, 'matiere_principale' => 'Physique']);
        $t3 = Teacher::create(['user_id' => User::factory()->create(['name' => 'Prof. Karim', 'email' => 'karim@test.com', 'password' => Hash::make('password')])->id, 'matiere_principale' => 'Informatique']);

        // 4. Créer 3 Cours
        $course1 = Course::create(['nom' => 'Mathématiques Avancées', 'teacher_id' => $t1->id, 'class_id' => $c1->id]);
        $course2 = Course::create(['nom' => 'Physique Quantique', 'teacher_id' => $t2->id, 'class_id' => $c2->id]);
        $course3 = Course::create(['nom' => 'Développement Web', 'teacher_id' => $t3->id, 'class_id' => $c3->id]);

        // 5. Créer 15 Étudiants
        for ($i = 1; $i <= 15; $i++) {
            $user = User::factory()->create([
                'name' => 'Étudiant ' . $i,
                'email' => 'etudiant' . $i . '@test.com',
                'password' => Hash::make('password')
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'class_id' => rand($c1->id, $c3->id), // Assigner à une classe au hasard
                'date_naissance' => now()->subYears(rand(16, 20))->format('Y-m-d')
            ]);

            // Inscrire l'étudiant à un cours
            $student->courses()->attach(rand($course1->id, $course3->id));

            // Lui donner 2 notes
            Grade::create(['student_id' => $student->id, 'course_id' => $course1->id, 'note' => rand(8, 20), 'type' => 'devoir', 'date' => now()]);
            Grade::create(['student_id' => $student->id, 'course_id' => $course2->id, 'note' => rand(8, 20), 'type' => 'examen', 'date' => now()]);
        }
    }
}