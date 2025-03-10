<?php

declare(strict_types=1);

use App\Http\Controllers\BestSellersListController;
use Illuminate\Support\Facades\Route;

Route::get('/books/best-sellers', BestSellersListController::class)
    ->name('api.books.best-sellers');
