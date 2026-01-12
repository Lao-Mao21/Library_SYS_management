<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', [BookController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

//Categories Routes - CRUD operations
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit'); //for the form
    Route::get('/categories/trashed_categories', [CategoryController::class, 'trashed'])->name('categories.trashed'); //recycle route
    Route::patch('/categories/{category}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::post('/categories/{category}/delete', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::delete('/categories/{category}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.force-delete');
});

//Books Routes - CRUD operations
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update'); //for update
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit'); //for the form
    Route::get('/books/trashed_books', [BookController::class, 'trashed'])->name('books.trashed'); //recycle route
    Route::patch('/books/{book}/restore', [BookController::class, 'restore'])->name('books.restore');
    Route::post('/books/{book}/delete', [BookController::class, 'destroy'])->name('books.destroy'); 
    Route::delete('/books/{book}/force-delete', [BookController::class, 'forceDelete'])->name('books.force-delete');
    Route::get('/books/export', [BookController::class, 'exportPDF'])->name('books.export'); //exportpdf
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
