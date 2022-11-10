<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountSettingsRequest;
use App\Models\Address;
use App\Models\Family;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AccountSettingController extends Controller
{
    public function edit(): View
    {
        $roles = Role::orderBy('id', 'desc')->get();
        $addresses = Address::where('user_id', auth()->user()->id)->get();
        $families = Family::orderBy('name', 'asc')->get();

        return view('content.account.account-settings', ['roles' => $roles, 'addresses' => $addresses, 'families' => $families]);
    }

    public function update(AccountSettingsRequest $request, User $user): RedirectResponse
    {
        $user->update($request->except('_method', '_token'));

        if($request->roles) {
            $user->syncRoles($request->roles);
        }

        return back()->withSuccess('Você editou o seu perfil com sucesso');
    }
}
