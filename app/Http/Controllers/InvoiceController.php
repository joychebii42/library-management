<?php

namespace App\Http\Controllers;

use App\Models\Invoice; // Assuming you have an Invoice model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all invoices, or filter by authenticated user if applicable
        $invoices = Invoice::where('user_id', Auth::id())->latest()->paginate(10);

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('invoices.create');
    }

    /**
     * Store a newly created invoice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'invoice_number' => 'required|string|max:255|unique:invoices,invoice_number',
            'amount' => 'required|numeric|min:0',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'status' => 'required|string|in:pending,paid,overdue',
        ]);

        $invoice = Auth::user()->invoices()->create($validatedData);

        return redirect()->route('invoices.show', $invoice)->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified invoice.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\View\View
     */
    public function show(Invoice $invoice)
    {
        // Ensure the authenticated user owns this invoice
        if ($invoice->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('invoices.show', compact('invoice'));
    }
}