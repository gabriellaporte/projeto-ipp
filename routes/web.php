<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$controller_path = 'App\Http\Controllers';

// Index
Route::get('/', [HomeController::class, 'index'])->name('index');

// Autenticação
Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login-authentication');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/recuperar-senha', [AuthController::class, 'showRecoverPasswordPage'])->name('recover-password');

// Minha Conta
Route::group(['middleware' => 'auth', 'prefix' => 'minha-conta', 'as' => 'account.'], function () {
    Route::get('/', [AccountController::class, 'showAccountSettings'])->name('settings');
    Route::get('/notificacoes/config', [AccountController::class, 'showNotificationSettings'])->name('notifications.settings');
});

// Membros

Route::get('/aniversarios', [UserController::class, 'showBirthdays'])->name('birthdays');

// Admin
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/membros', [MemberController::class, 'showMembers'])->name('users');
    Route::post('/membros/store', [MemberController::class, 'store'])->name('users.store');
    Route::get('/membros/delete/{id}', [MemberController::class, 'delete'])->name('users.delete');
    Route::get('/membro/{id}', [MemberController::class, 'showEditUser'])->name('user.show');
});

// Usuário
Route::post('/usuario/edit/{id?}', [UserController::class, 'edit'])->name('user.edit');

// Endereços
Route::post('/addresses/sync/{id?}', [AddressController::class, 'syncAddresses'])->name('addresses.sync');
Route::get('/addresses/flush/{id?}', [AddressController::class, 'deleteAddresses'])->name('addresses.flush');
Route::get('/addresses/{id}/destroy', [AddressController::class, 'destroy'])->name('addresses.delete');

// Notificações
Route::post('/notificacoes/sync/', [NotificationController::class, 'syncNotifications'])->name('notifications.sync');
