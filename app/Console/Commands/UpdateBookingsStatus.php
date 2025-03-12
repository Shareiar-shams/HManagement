<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User\Book;
use App\Models\Admin\Product;
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

        $books = Book::where('order_status', 'booked')
            ->where('checkoutDate', '<', $today)
            ->get(); // Get records first

        // Update order_status for those records
        Book::where('order_status', 'booked')
            ->where('checkoutDate', '<', $today)
            ->update(['order_status' => 'checkout']);

        // Now, update the associated rooms
        foreach ($books as $book) {
            $room = Product::where('id', $book->product_id)->where('booked',1)->first();
            if ($room) {
                $room->booked = 0;
                $room->save();
            }
        }

        $this->info('Booking statuses updated successfully.');
    }

}
