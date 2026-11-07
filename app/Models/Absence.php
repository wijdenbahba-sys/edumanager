<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model {
    protected $fillable = ['student_id', 'course_id', 'date', 'justifiee'];

    public function student() {
        return $this->belongsTo(Student::class);
    }
}