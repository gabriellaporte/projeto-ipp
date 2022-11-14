<?php

use App\Http\Controllers\Account\AccountSettingController;
use App\Http\Controllers\Account\NotificationSettingController;
use App\Http\Controllers\Account\NotificationController;
use App\Http\Controllers\Account\UserAddressController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\BirthdayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Models\Address;
use App\Models\Notification;
use Illuminate\Support\Facades\Route;

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

// Página inicial
Route::get('/', [HomeController::class, 'index'])->name('index');

// Pesquisa
Route::group(['middleware' => 'auth', 'prefix' => 'pesquisa', 'as' => 'search.'], function () {
    Route::get('/membros', [SearchController::class, 'searchUsers'])->name('members');
    Route::get('/enderecos', [SearchController::class, 'searchAddresses'])->middleware('officer')->name('addresses');
    Route::view('/enderecos/mapa', 'content.search.address_full_view')->middleware('officer')->name('addresses.map');
});

// Minha Conta
Route::group(['middleware' => 'auth', 'prefix' => 'minha-conta', 'as' => 'account.'], function () {
    Route::get('/', [AccountSettingController::class, 'edit'])->name('settings.edit');
    Route::put('/update/{user}', [AccountSettingController::class, 'update'])->name('settings.update');

    // Notificações
    Route::group(['prefix' => 'notificacoes', 'as' => 'notifications.'], function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/read/{notification}', [NotificationController::class, 'read'])->name('read')
            ->missing(function($request) {
                $response['status'] = 400;
                $response['message'] = 'Notificação inválida. Tente novamente.';

                return response()->json($response);
            });

        // Configuração
        Route::get('/configuracao', [NotificationSettingController::class, 'edit'])->name('config.edit');
        Route::post('/configuracao/update/', [NotificationSettingController::class, 'update'])->name('config.update');
    });

    // Endereços
    Route::group(['prefix' => 'enderecos', 'as' => 'addresses.'], function () {
        Route::post('/sync/', [UserAddressController::class, 'sync'])->name('sync');
        Route::delete('/flush/', [UserAddressController::class, 'flush'])->name('flush');
        Route::get('/destroy/{address}', [UserAddressController::class, 'destroy'])->name('destroy');
    });
});

// Endereços
Route::post('/addresses/sync/{id?}', [AddressController::class, 'syncAddresses'])->name('addresses.sync');
Route::get('/addresses/flush/{id?}', [AddressController::class, 'deleteAddresses'])->name('addresses.flush');
Route::get('/addresses/{id}/destroy', [AddressController::class, 'destroy'])->name('addresses.delete');
Route::get('/addresses/bairros/{city?}', [AddressController::class, 'getExistingAreas'])->name('addresses.areas.get');


// Membros
Route::group(['middleware' => 'auth'], function () {
    Route::get('/aniversarios', [BirthdayController::class, 'index'])->name('birthdays');
});

// Admin
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/membros', [MemberController::class, 'showMembers'])->name('users');
    Route::post('/membros/store', [MemberController::class, 'store'])->name('users.store');
    Route::get('/membros/delete/{id}', [MemberController::class, 'delete'])->name('users.delete');
    Route::get('/membro/{id}', [MemberController::class, 'showEditUser'])->name('user.show');

    Route::get('/notificacoes', [AdminNotificationController::class, 'showNotifications'])->name('notifications');
    Route::post('/notificacoes/store', [AdminNotificationController::class, 'storeNotification'])->name('notifications.store');
    Route::post('/notificacoes/edit', [AdminNotificationController::class, 'editNotification'])->name('notifications.edit');
    Route::get('/notificacoes/delete/{id}', [AdminNotificationController::class, 'deleteNotification'])->name('notifications.delete');

    Route::get('/familias', [FamilyController::class, 'showFamilies'])->name('families');
    Route::post('/familias/store', [FamilyController::class, 'storeFamily'])->name('families.store');
    Route::post('/familias/edit', [FamilyController::class, 'editFamily'])->name('families.edit');
    Route::get('/familias/delete/{id}', [FamilyController::class, 'deleteFamily'])->name('families.delete');
});

// Usuário
Route::post('/usuario/edit/{id?}', [UserController::class, 'edit'])->name('user.edit');

// Autenticação
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login-authentication');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/recuperar-senha', [AuthController::class, 'showRecoverPasswordPage'])->name('recover-password');
