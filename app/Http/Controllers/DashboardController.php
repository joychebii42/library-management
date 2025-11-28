<?php

namespace App\Http\Controllers; // Corrected namespace

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Console\Commands\CalculatePenalties;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        // We need to calculate available copies manually since it's an accessor
        $allBooks = Book::withCount(['loans' => fn ($query) => $query->whereNull('returned_at')])->get();
        $availableBooks = $allBooks->sum(fn ($book) => $book->quantity - $book->loans_count);
        $borrowedBooks = Loan::whereNull('returned_at')->count();

        // Fetch distinct values for the sidebar, limited for performance
        $authors = Book::select('author')->distinct()->orderBy('author')->limit(20)->pluck('author');
        $publishers = Book::select('publisher')->distinct()->orderBy('publisher')->limit(20)->pluck('publisher');
        $genres = Book::select('genre')->distinct()->orderBy('genre')->limit(20)->pluck('genre');

        // Fetch the current user's active loans
        $userLoans = Loan::where('user_id', Auth::id())
            ->whereNull('returned_at')
            ->with('book')->latest('loaned_at')->get();

        // Calculate penalties for overdue books
        foreach ($userLoans as $loan) {
            if (Carbon::now()->isAfter($loan->due_date) && $loan->penalty_status !== 'paid') {
                $overdueDays = abs($loan->due_date->startOfDay()->diffInDays(Carbon::now()->startOfDay()));
                $loan->penalty_amount = $overdueDays * CalculatePenalties::PENALTY_RATE_PER_DAY;
                $loan->penalty_status = 'unpaid';
                // Don't save here - just calculate for display
            }
        }

        return view('dashboard', compact('totalBooks', 'availableBooks', 'borrowedBooks', 'authors', 'publishers', 'genres', 'userLoans'));
    }
}
