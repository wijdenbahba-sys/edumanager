<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'amount', 'month', 'status', 'payment_date'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}