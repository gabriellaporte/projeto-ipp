<?php

use App\Http\Controllers\Account\AccountSettingController;
use App\Http\Controllers\Account\NotificationSettingController;
use App\Http\Controllers\Account\NotificationController;
use App\Http\Controllers\Account\UserAddressController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\TitheController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\BirthdayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Notifications\AdminNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

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
        Route::patch('/read/{notification}', [NotificationController::class, 'read'])->name('read')
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

// Membros
Route::group(['middleware' => 'auth'], function () {
    Route::get('/aniversarios', [BirthdayController::class, 'index'])->name('birthdays');
});

// Admin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'officer'], function () {
    Route::get('/membros', [MemberController::class, 'index'])->name('members.index');
    Route::get('/membros/{user}', [MemberController::class, 'edit'])->name('members.edit');
    Route::put('/membros/update/{user}', [MemberController::class, 'update'])->name('members.update');
    Route::post('/membros/store', [MemberController::class, 'store'])->name('members.store');
    Route::delete('/membros/delete/{user}', [MemberController::class, 'delete'])->name('members.delete');

    Route::get('/familias', [FamilyController::class, 'index'])->name('families.index');
    Route::post('/familias/store', [FamilyController::class, 'store'])->name('families.store');
    Route::put('/familias/update/{family}', [FamilyController::class, 'update'])->name('families.update');
    Route::delete('/familias/delete/{family}', [FamilyController::class, 'delete'])->name('families.delete');

    Route::get('/notificacoes', [AdminNotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notificacoes/store', [AdminNotificationController::class, 'store'])->name('notifications.store');
    Route::patch('/notificacoes/update/{notification}', [AdminNotificationController::class, 'update'])->name('notifications.update');
    Route::delete('/notificacoes/delete/{notification}', [AdminNotificationController::class, 'delete'])->name('notifications.delete');

    Route::get('/dizimos', [TitheController::class, 'index'])->name('tithes.index');
});

// Endereços
Route::get('/addresses/bairros/{city?}', [AddressController::class, 'getExistingAreas'])->name('addresses.areas.get');

// Usuário
Route::post('/usuario/edit/{id?}', [UserController::class, 'edit'])->name('user.edit');

// Autenticação
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login-authentication');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/recuperar-senha', [AuthController::class, 'showRecoverPasswordPage'])->name('recover-password');
