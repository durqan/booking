<?php

namespace Database\Seeders;

use App\Models\Bookings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings =
            [
                1 => [
                    1 => [
                        '2025-10-16' => [
                            '13:00',
                            '16:00'
                        ],
                        '2025-10-17' => [
                            '10:00',
                            '11:00',
                            '13:00',
                            '18:00'
                        ]
                    ],
                    2 => [
                        '2025-10-16' => [
                            '16:00'
                        ]
                    ]
                ],
                2 => [
                    3 => [
                        '2025-10-16' => [
                            '10:00',
                            '11:30',
                            '18:30'
                        ],
                    ],
                    4 => [
                        '2025-10-17' => [
                            '14:00'
                        ]
                    ]
                ]
            ];

        foreach ($bookings as $service_id => $booking) {
            foreach ($booking as $service_price_id => $date_times) {
                foreach ($date_times as $date => $times) {
                    foreach ($times as $time) {
                        Bookings::insert(['service_id' => $service_id, 'service_price_id' => $service_price_id, 'date_time' => date('Y-m-d H:i', strtotime($date . ' ' . $time))]);
                    }
                }
            }
        }
    }
}
