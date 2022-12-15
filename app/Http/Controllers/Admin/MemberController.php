<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountSettingsRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Address;
use App\Models\Family;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpKernel\Profiler\Profile;

class MemberController extends Controller
{
    public function index(): View
    {
        $users = QueryBuilder::for(User::class)->allowedFilters('name')
            ->allowedSorts('name')
            ->orderBy('name')
            ->paginate(10);
        $families = Family::orderBy('name', 'asc')->get();

        return view('content.admin.members')->with('users', $users)
            ->with('families', $families);
    }

    public function edit(User $user): View
    {
        $roles = Role::orderBy('id', 'desc')->get();
        $addresses = Address::where('user_id', $user->id)->get();
        $families = Family::orderBy('name', 'asc')->get();

        return view('content.account.account-settings',
            ['editing' => true, 'user' => $user, 'roles' => $roles, 'addresses' => $addresses, 'families' => $families]
        );
    }

    public function update(AccountSettingsRequest $request, User $user): RedirectResponse
    {
        $user->update($request->except('_method', '_token', 'profile_picture'));

        if($request->profile_picture) {
            $user->update(['profile_picture' => $request->profile_picture->store('img/avatars')]);
        }

        if($request->roles) {
            $user->syncRoles($request->roles);
        }

        return back()->withSuccess('Você editou o perfil de ' . $user->getShortName() . ' com sucesso');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = User::create($request->except('_method', '_token', 'profile_picture'));

        if($request->profile_picture) {
            $user->update(['profile_picture' => $request->profile_picture->store('img/avatars')]);
        }

        return back()->withSuccess('Você adicionou um novo usuário com sucesso');
    }

    public function delete(User $user): RedirectResponse
    {
        if(auth()->user()->id == $user->id) {
            return back()->withErrors('Você não pode deletar a sua própria conta.');
        }

        $user->delete();

        return back()->withSuccess('Você deletou o usuário ' . $user->name . ' com sucesso!');
    }
}
