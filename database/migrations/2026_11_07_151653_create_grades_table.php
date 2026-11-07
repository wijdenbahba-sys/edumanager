<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->decimal('note', 5, 2); // ex: 15.50
            $table->string('type')->default('devoir'); // devoir, examen
            $table->date('date');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('grades');
    }
};