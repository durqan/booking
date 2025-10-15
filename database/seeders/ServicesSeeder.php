<?php

namespace Database\Seeders;

use App\Models\Services;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services =
            [
                [
                    'name' => 'Поездка на квадроцикле',
                ],
                [
                    'name' => 'Тур на эндуро',
                ]
            ];

        Services::insert($services);
    }
}
