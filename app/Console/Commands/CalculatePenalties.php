<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\OverdueBookReminder;

class CalculatePenalties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'penalties:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate penalties for overdue books';

    // Define penalty rate, e.g., $1 per day
    const PENALTY_RATE_PER_DAY = 1.00;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Calculating penalties for overdue books...');

        $overdueLoans = Loan::where('due_date', '<', Carbon::today())
                            ->whereNull('returned_at')
                            ->with(['user', 'book']) // Eager load relationships
                            ->get();

        foreach ($overdueLoans as $loan) {
            $overdueDays = Carbon::today()->diffInDays($loan->due_date);
            $newPenalty = $overdueDays * self::PENALTY_RATE_PER_DAY;

            // Only update the record and send an email if the penalty amount has changed.
            // This prevents sending emails every day for the same overdue book.
            if ($loan->penalty_amount != $newPenalty || $loan->penalty_status !== 'unpaid') {
                $loan->penalty_amount = $newPenalty;
                $loan->penalty_status = 'unpaid';
                Mail::to($loan->user)->queue(new OverdueBookReminder($loan));
                $loan->save();
            }
        }

        $this->info('Finished calculating penalties. ' . $overdueLoans->count() . ' loans updated.');

        return 0;
    }
}
