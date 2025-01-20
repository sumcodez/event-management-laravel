<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home.home');
})->name('home.page');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/events', function () {
    return view('users.events');
})->middleware(['auth', 'verified'])->name('events.all');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/events', [EventController::class, 'allEvents_user'])->name('events.all');

    Route::get('/events/{event_id}', [AttendeeController::class, 'show'])->name('events.show');

    Route::post('/events/register/{event_id}', [AttendeeController::class, 'register'])->name('events.register');

    Route::get('/my-registrations', [EventController::class, 'showRegisteredEvents'])->name('events.my-registrations');

    Route::get('/profile', [UserController::class, 'edit'])->name('profile.manage');

    Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');

    Route::post('/profile/pic_update', [UserController::class, 'update_profile_pic'])->name('profile.update_pic');

    Route::get('/profile/deactivate', [UserController::class, 'deactivate_user'])->name('profile.deactivate');

});

Route::get('/chart-data', [ChartController::class, 'getChartData']);

Route::get('/bar-chart-data', [ChartController::class, 'getBarChartData']);

//Route::get('/events', [EventController::class, 'allEvents_user'])->name('events.all');

//Route::get('/events/{event_id}', [AttendeeController::class, 'show'])->name('events.show');

//Route::post('/events/register/{event_id}', [AttendeeController::class, 'register'])->name('events.register');


require __DIR__.'/auth.php';

require __DIR__.'/admin.php';
