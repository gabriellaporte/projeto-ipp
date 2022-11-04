<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Address;
use App\Models\Family;
use App\Models\NotificationSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Função responsável por mostrar as configurações de perfil
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showAccountSettings()
    {
        $user = auth()->user();
        $roles = Role::orderBy('id', 'desc')->get();
        $addresses = Address::where('user_id', auth()->user()->id)->get();
        $families = Family::orderBy('name', 'asc')->get();

        return view('content.account.account-settings', ['roles' => $roles, 'addresses' => $addresses, 'user' => $user, 'families' => $families]);
    }

    /**
     * Função responsável por mostrar as configurações de notificações
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showNotificationSettings()
    {
        $notificationSettings = NotificationSetting::where('user_id', auth()->user()->id)->get();

        return view('content.account.notification-settings', ['notSettings' => $notificationSettings]);
    }
}
