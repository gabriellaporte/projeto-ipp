<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\API\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/addresses/{userID?}', [APIController::class, 'getUserAddresses'])->name('api.addresses');
Route::get('/notification/{id}', [APIController::class, 'getNotification'])->name('api.notification');
Route::get('/family/{id}', [APIController::class, 'getFamily'])->name('api.family');
Route::get('/category/{category}', [APIController::class, 'getCategoryInfo'])->name('api.category');
