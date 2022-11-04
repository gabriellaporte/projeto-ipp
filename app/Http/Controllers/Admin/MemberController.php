<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProfileRequest;
use App\Models\Address;
use App\Models\Family;
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
        $families = Family::orderBy('name', 'asc')->get();

        return view('content.admin.user')
            ->with('users', $users)
            ->with('families', $families);
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
        $families = Family::orderBy('name', 'asc')->get();

        if (is_null($user)) {
            return redirect()
                ->back()
                ->withErrors('Não foi possível encontrar este usuário.');
        }

        return view('content.account.account-settings', ['user' => $user, 'roles' => $roles, 'addresses' => $addresses, 'families' => $families]);
    }

    /**
     * Cria um novo usuário com base nos dados enviados
     *
     * @param ProfileRequest $request   |   Dados enviados e validados
     * @return mixed
     */
    public function store(ProfileRequest $request) {
        $user = new User;

        $user = User::create([
            'name' => $request->userName,
            'email' => $request->emailAddress,
            'password' => Hash::make(Str::random(6)),
            'mobile_phone' => $request->mobilePhone,
            'house_phone' => $request->housePhone,
            'birth_date' => Carbon::createFromFormat('d/m/Y', $request->birthDate)->format('Y-m-d'),
            'enrollment_origin' => $request->enrollmentOrigin,
            'enrollment_date' => !is_null($request->enrollmentDate) ? Carbon::createFromFormat('d/m/Y', $request->enrollmentDate)->format('Y-m-d') : null,
            'gender' => $request->gender,
            'family_id' => $request->family
        ]);

        if(!is_null($request->profilePicture))
        {
            $storeFile = $request->profilePicture->store('img/avatars');
            $user->profile_picture = $storeFile;
        }

        return redirect()
            ->back()
            ->withSuccess('Você criou o usuário ' . $user->getShortName() . ' com sucesso. Você pode editá-lo agora!');
    }

    /**
     * Deleta um usuário pelo ID (soft delete)
     *
     * @param $id   |   ID do usuário
     * @return \Illuminate\Http\RedirectResponse
     */
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
