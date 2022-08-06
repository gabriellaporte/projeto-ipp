<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Address;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AccountController extends Controller
{
  public function __construct() {
    $this->middleware('auth');
  }

  public function showAccountSettings() {
    $user = auth()->user();
    $roles = Role::orderBy('id', 'desc')->get();
    $addresses = Address::where('user_id', auth()->user()->id)->get();

    return view('content.account.account-settings', ['roles' => $roles, 'addresses' => $addresses, 'user' => $user]);
  }

  public function showNotificationSettings() {
    $user = auth()->user();

    return view('content.account.notification-settings', ['user' => $user]);
  }

}
