<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User\Book;
use Carbon\Carbon;

class UpdateBookingsStatus extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'bookings:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update booking status from booked to checkout if checkoutDate is passed.';


    /**
     * Execute the console command.
     */

    public function handle()
    {
        $today = Carbon::today();

        Book::where('order_status', 'booked')
            ->where('checkoutDate', '<', $today)
            ->update(['order_status' => 'checkout']);

        $this->info('Booking statuses updated successfully.');
    }

}
