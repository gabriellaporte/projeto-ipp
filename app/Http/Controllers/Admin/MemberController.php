<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProfileRequest;
use App\Models\Address;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;

class MemberController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Visualiza todos os membros da igreja
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showMembers()
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters('name')
            ->allowedSorts('name')
            ->orderBy('name', 'asc')
            ->paginate(10);

        return view('content.admin.user')
            ->with('users', $users);
    }

    /**
     * Mostra o perfil de um usuário pronto para edição, semelhante à ação de AccountController/index
     *
     * @param $id | ID do usuário que será editado
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showEditUser($id)
    {
        $user = User::find($id);
        $roles = Role::orderBy('id', 'desc')->get();
        $addresses = Address::where('user_id', $user->id)->get();

        if (is_null($user)) {
            return redirect()
                ->back()
                ->withErrors('Não foi possível encontrar este usuário.');
        }

        return view('content.account.account-settings', ['user' => $user, 'roles' => $roles, 'addresses' => $addresses]);
    }

    public function store(ProfileRequest $request) {
        $user = new User;

        $user->email = $request->emailAddress;
        $user->password = Hash::make(Str::random(6));
        $user->mobile_phone = $request->mobilePhone;
        $user->house_phone = $request->housePhone;
        $user->birth_date = Carbon::createFromFormat('d/m/Y', $request->birthDate)->format('y-m-d');
        $user->name = $request->userName;

        $user->enrollment_origin = $request->enrollmentOrigin ?? $user->enrollment_origin;

        if (!is_null($request->enrollmentDate)) {
            $user->enrollment_date = Carbon::createFromFormat('d/m/Y', $request->enrollmentDate)->format('y-m-d');
        } else {
            $user->enrollment_date = null;
        }

        $user->gender = $request->gender ?? $user->gender;

        if (!is_null($request->profilePicture)) {
            $storeFile = $request->profilePicture->store('img/avatars');

            $user->profile_picture = $storeFile;
        }

        $user->save();

        $user->assignRole('Membro');

        return redirect()
            ->back()
            ->withSuccess('Você criou o usuário ' . $user->getShortName() . ' com sucesso. Você pode editá-lo agora!');
    }

    public function delete($id) {
        $user = User::find($id);

        if(is_null($user)) {
            return redirect()
                ->back()
                ->withErrors('Não foi possível encontrar este usuário. Tente novamente.');
        }

        if(auth()->user()->id == $id) {
            return redirect()
                ->back()
                ->withErrors('Você não pode deletar a sua própria conta.');
        }

        $user->delete();

        return redirect()
            ->back()
            ->withSuccess('Você deletou o usuário ' . $user->name . ' com sucesso!');
    }
}
