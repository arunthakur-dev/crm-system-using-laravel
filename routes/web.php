<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\DashboardController;

Route::middleware('auth')->group(function () {
    Route::delete('/logout', [SessionController::class, 'destroy']);

    Route::get('/', action: [DashboardController::class, 'index'])->name('dashboard');

    // Companies
    Route::resource('companies', CompanyController::class);
    // Extra routes for association
    Route::post('/companies/{company}/add-contacts', [CompanyController::class, 'addContacts'])
        ->name('companies.add.contacts');

    Route::post('/companies/{company}/add-deals', [CompanyController::class, 'addDeals'])
        ->name('companies.add.deals');

        
    // Contacts
    Route::resource('contacts', ContactController::class);

    // Extra routes for association
    Route::post('/contacts/{contact}/add-deal', [ContactController::class, 'addDeals'])
        ->name('contacts.add.deals');

    Route::post('/contacts/{contact}/add-companies', [ContactController::class, 'addCompanies'])
        ->name('contacts.add.companies');


    // Deals
    Route::resource('deals', DealController::class);

    // Extra routes for association
    Route::post('/deals/{deal}/add-contacts', [DealController::class, 'addContacts'])
        ->name('deals.add.contacts');

    Route::post('/deals/{deal}/add-companies', [DealController::class, 'addCompanies'])
        ->name('deals.add.companies');

});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisterUserController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
});



