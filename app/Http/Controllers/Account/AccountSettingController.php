<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Family;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AccountSettingController extends Controller
{
    public function index(): View
    {
        $roles = Role::orderBy('id', 'desc')->get();
        $addresses = Address::where('user_id', auth()->user()->id)->get();
        $families = Family::orderBy('name', 'asc')->get();

        return view('content.account.account-settings', ['roles' => $roles, 'addresses' => $addresses, 'user' => auth()->user(), 'families' => $families]);
    }
}
