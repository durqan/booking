<?php

namespace App\Http\Controllers;


use App\Jobs\ToBookJob;
use App\Models\Bookings;
use App\Models\Services;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function booking()
    {
        $services = Services::with(['prices', 'bookings'])->get();

        return Inertia::render('Booking', [
            'services' => $services
        ]);
    }

    public function get_available_slots(Request $request)
    {
        $service_id = $request->service_id;
        $price_id = $request->price_id;
        $date = $request->date;

        $start_date = date('Y-m-d 00:00:00', strtotime($date));
        $end_date = date('Y-m-d 23:59:59', strtotime($date));

        $bookings = Bookings::select('date_time')
            ->where('service_id', $service_id)
            ->where('service_price_id', $price_id)
            ->whereBetween('date_time', [$start_date, $end_date])
            ->get();

        $json = [];

        foreach ($bookings as $booking) {
            $json[] = date('H:i', strtotime($booking->date_time));
        }

        return response()->json($json);
    }

    public function to_book(Request $request)
    {
        $date = $request->date;
        $time = $request->time;
        $date_time = date('Y-m-d H:i', strtotime($date . ' ' . $time));

        $slot_is_busy = Bookings::where([
            'service_id' => $request->service_id,
            'service_price_id' => $request->price_id,
            'date_time' => $date_time
        ])->first();

        if(!empty($slot_is_busy))
            return response('Слот занят', 422);

        ToBookJob::dispatch([
            'service_id' => $request->service_id,
            'service_price_id' => $request->service_id,
            'date_time' => $date_time,
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return response('success', 200);
    }
}
