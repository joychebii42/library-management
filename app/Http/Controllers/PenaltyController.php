<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Penalty;
use App\Http\Resources\PenaltyResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenaltyController extends Controller
{
    /**
     * Display a listing of users with overdue books.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all overdue book loans that have not been returned yet.
        // We also get the user and book information.
        // The number of days overdue is calculated as well.
        $overdueLoans = Loan::with(['user', 'book'])
            ->whereNull('returned_at')
            ->where('due_date', '<', now())
            ->select(
                'loans.*',
                DB::raw('DATEDIFF(now(), due_date) as days_overdue')
            )
            ->orderBy('days_overdue', 'desc')
            ->get();

        return view('penalties.index', compact('overdueLoans'));
    }

    /**
     * Display a listing of the resource for API.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function apiIndex()
    {
        $penalties = Penalty::with('loan.user', 'loan.book')->get();

        return PenaltyResource::collection($penalties);
    }
}