<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LoanController extends Controller
{
    /**
     * Create a new loan for a book.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function borrow(Request $request, Book $book)
    {
        // Check if there are available copies
        if ($book->available_copies <= 0) {
            return back()->with('error', 'No available copies of this book to borrow.');
        }

        // Check if the user has any unpaid penalties
        $unpaidPenalties = Loan::where('user_id', Auth::id())
            ->where('penalty_status', 'unpaid')
            ->where('penalty_amount', '>', 0)
            ->exists();

        if ($unpaidPenalties) {
            return back()->with('error', 'You cannot borrow new books until you have paid all outstanding penalties.');
        }

        // Check if the user already has an active loan for this book
        $activeLoan = Loan::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->whereNull('returned_at')
            ->exists();

        if ($activeLoan) {
            return back()->with('error', 'You have already borrowed this book and not returned it yet.');
        }

        try {
            DB::transaction(function () use ($book) {
                // Create the loan record
                Loan::create([
                    'user_id' => Auth::id(),
                    'book_id' => $book->id,
                    'loaned_at' => Carbon::now(),
                    'due_date' => Carbon::now()->addDays(14), // 14-day loan period
                ]);
            });
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            return back()->with('error', 'An error occurred while trying to borrow the book. Please try again.');
        }

        return back()->with('success', 'You have successfully borrowed "' . $book->title . '".');
    }

    /**
     * Mark a loan as returned.
     *
     * @param  \Illuminate\Http\Request  $request 
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function returnBook(Request $request, Loan $loan)
    {
        // Authorization check: ensure the loan belongs to the authenticated user
        if ($loan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::transaction(function () use ($loan, $request) {
                $returnTimestamp = Carbon::now();
                $loan->returned_at = $returnTimestamp;

                // Finalize penalty if the book is returned late and the penalty isn't already paid
                if ($returnTimestamp->isAfter($loan->due_date) && $loan->penalty_status !== 'paid') {
                    // Use startOfDay() to count full days overdue
                    // Note: diffInDays calculates the difference, so we use abs() and ensure positive value
                    $overdueDays = abs($loan->due_date->startOfDay()->diffInDays($returnTimestamp->startOfDay()));
                    $loan->penalty_amount = $overdueDays * config('library.penalty_rate_ksh', 50); // Using config for Ksh rate
                    $loan->penalty_status = 'unpaid';
                }

                $loan->save();
            });
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while returning the book. Please try again.');
        }

        return back()->with('success', 'You have successfully returned "' . $loan->book->title . '".');
    }
}