<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;


Route::get('admin/login', [LoginController::class, 'showAdminLogin'])->name('admin.login');

Route::post('/admin/login', [LoginController::class, 'adminLogin'])->name('admin.login.submit');

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/all-venues', [VenueController::class, 'allVenues'])->name('admin.venues');
    Route::get('admin/all-events', [EventController::class, 'index'])->name('admin.events');
});




//Route::get('admin/dashboard', [LoginController::class, 'showAdminDashboard'])->name('admin.dashboard.page');


//Route::get('admin/all-venues', [VenueController::class, 'allVenues'])->name('admin.venues');

Route::post('admin/create-venue', [VenueController::class, 'createVenue'])->name('venues.create');

Route::put('admin/venues/update/{id}', [VenueController::class, 'updateVenue'])->name('venues.update');

Route::get('admin/venues/delete/{id}', [VenueController::class, 'deleteVenue'])->name('venues.delete');

//Route::get('admin/all-events', [EventController::class, 'index'])->name('admin.events');

Route::post('admin/create-event', [EventController::class, 'createEvent'])->name('events.create');

Route::put('admin/events/update/{id}', [EventController::class, 'updateEvent'])->name('events.update');

Route::get('admin/events/delete/{id}', [EventController::class, 'deleteEvent'])->name('events.delete');