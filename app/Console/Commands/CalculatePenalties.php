<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Loan;
use App\Models\Penalty;
use Carbon\Carbon;

class CalculatePenalties extends Command
{
    public const PENALTY_RATE_PER_DAY = 50.00;

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
    protected $description = 'Calculate and create penalties for overdue books';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Calculating penalties for overdue loans...');

        // Get all active, overdue loans that haven't been penalized today
        $overdueLoans = Loan::where('status', 'borrowed')
            ->where('due_date', '<', Carbon::now())
            ->get();

        foreach ($overdueLoans as $loan) {
            $today = Carbon::today();
            $penaltyExists = Penalty::where('loan_id', $loan->id)->whereDate('created_at', $today)->exists();

            if (!$penaltyExists) {
                Penalty::create([
                    'loan_id' => $loan->id,
                    'amount' => self::PENALTY_RATE_PER_DAY,
                    'status' => 'pending',
                ]);
            }
        }

        $this->info('Penalty calculation complete.');
        return Command::SUCCESS;
    }
}