<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookLoanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('books', BookController::class);
    Route::resource('users', UserController::class);
    
    // Rotas de empréstimos
    Route::get('/loans', [BookLoanController::class, 'index'])->name('loans.index');
    Route::post('/loans', [BookLoanController::class, 'store'])->name('loans.store');
    Route::get('/loans/{loan}', [BookLoanController::class, 'show'])->name('loans.show');
    Route::patch('/loans/{loan}/return', [BookLoanController::class, 'returnBook'])->name('loans.return');
    Route::patch('/loans/{loan}/renew', [BookLoanController::class, 'renew'])->name('loans.renew');
    Route::get('/loans/overdue/list', [BookLoanController::class, 'overdue'])->name('loans.overdue');
    Route::patch('/loans/update-overdue-status', [BookLoanController::class, 'updateOverdueStatus'])->name('loans.updateOverdueStatus');
});

require __DIR__.'/auth.php';
