<?php

namespace App\Http\Controllers; // Corrected namespace

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        // We need to calculate available copies manually since it's an accessor
        $allBooks = Book::withCount(['loans' => fn ($query) => $query->whereNull('returned_date')])->get();
        $availableBooks = $allBooks->sum(fn ($book) => $book->quantity - $book->loans_count);
        $borrowedBooks = Loan::whereNull('returned_date')->count();

        // Fetch distinct values for the sidebar, limited for performance
        $authors = Book::select('author')->distinct()->orderBy('author')->limit(20)->pluck('author');
        $publishers = Book::select('publisher')->distinct()->orderBy('publisher')->limit(20)->pluck('publisher');
        $genres = Book::select('genre')->distinct()->orderBy('genre')->limit(20)->pluck('genre');

        // Fetch the current user's active loans
        $userLoans = Loan::where('user_id', Auth::id())
            ->whereNull('returned_date')
            ->with('book')->latest('borrowed_date')->get();

        return view('dashboard', compact('totalBooks', 'availableBooks', 'borrowedBooks', 'authors', 'publishers', 'genres', 'userLoans'));
    }
}
