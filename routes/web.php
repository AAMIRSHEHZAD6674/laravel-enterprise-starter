<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ActivityLogController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])
    ->name('activity-logs.index');
});


Route::middleware('auth')->group(function () {

    Route::prefix('users')->name('users.')->group(function () {

        Route::get('/trash', [UserController::class, 'trash'])
            ->name('trash');

        Route::put('/restore/{id}', [UserController::class, 'restore'])
            ->name('restore');

        Route::delete('/force-delete/{id}', [UserController::class, 'forceDelete'])
            ->name('forceDelete');

    });

    Route::patch(
            'users/{user}/toggle-status',
            [UserController::class, 'toggleStatus']
        )->name('users.toggleStatus');

    Route::resource('users', UserController::class)
        ->except('show');

});

require __DIR__.'/auth.php';
