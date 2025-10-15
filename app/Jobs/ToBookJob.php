<?php

namespace App\Jobs;

use App\Models\Bookings;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class ToBookJob implements ShouldQueue
{
    use Queueable;

    private array $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();

        try {
            $user = new User();
            $user->name = $this->data['name'];
            $user->phone = $this->data['phone'];
            $user->save();

            $booking = new Bookings();
            $booking->service_id = $this->data['service_id'];
            $booking->service_price_id = $this->data['price_id'];
            $booking->date_time = $this->data['date_time'];
            $booking->user_id = $user->id;
            $booking->save();

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
        }
    }
}
