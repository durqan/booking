<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

Route::get('/', [BookingController::class, 'booking']);
Route::post('/get_available_slots', [BookingController::class, 'get_available_slots']);
Route::post('/to_book', [BookingController::class, 'to_book']);
