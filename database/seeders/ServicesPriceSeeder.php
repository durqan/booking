<?php

namespace Database\Seeders;

use App\Models\Bookings;
use App\Models\ServicesPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services_price =
            [
                1 => [
                    [
                        'name' => '30',
                        'price' => '500'
                    ],
                    [
                        'name' => '60',
                        'price' => '1000'
                    ]
                ],
                2 => [
                    [
                        'name' => '60',
                        'price' => '1500'
                    ],
                    [
                        'name' => '120',
                        'price' => '3000'
                    ]
                ]
            ];

        foreach ($services_price as $service_id => $prices) {
            foreach ($prices as $price) {
                ServicesPrice::insert(['service_id' => $service_id, 'name' => $price['name'], 'price' => $price['price']]);
            }
        }
    }
}
