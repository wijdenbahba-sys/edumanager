<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('student.user')->latest()->get();
        $students = Student::with('user')->get();
        return view('payments.index', compact('payments', 'students'));
    }

        public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'month' => 'required|string',
            'status' => 'required|in:paye,non_paye', // Zidna hadhi
        ]);

        Payment::create([
            'student_id' => $request->student_id,
            'amount' => $request->amount,
            'month' => $request->month,
            'status' => $request->status, // Bdelna hadhi bch te5dem b el choix
            'payment_date' => $request->status === 'paye' ? now() : null, // Ila paye, na7tou date
        ]);

        return redirect()->route('payments.index')->with('success', 'Paiement ajouté avec succès.');
    }

    public function markAsPaid(Payment $payment)
    {
        $payment->update([
            'status' => 'paye',
            'payment_date' => now(),
        ]);
        return redirect()->back()->with('success', 'Paiement marqué comme payé.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Paiement supprimé.');
    }
}