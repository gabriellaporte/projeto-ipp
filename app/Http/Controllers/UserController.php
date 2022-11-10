<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Address;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Edita o perfil de um usuário ($id) vindo pela pela requisição ($request)
     *
     * @param ProfileRequest $request | Requisição via POST
     * @param $id | O ID do usuário a ser editado, se for null, considera-se que o usuário está editando a si mesmo (sessão auth)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(ProfileRequest $request, $id = null)
    {
        $user = User::find($id) ?? auth()->user();

        $user->email = $request->emailAddress;
        $user->mobile_phone = $request->mobilePhone;
        $user->house_phone = $request->housePhone;
        $user->birth_date = Carbon::createFromFormat('d/m/Y', $request->birthDate)->format('Y-m-d');
        $user->name = $request->userName;

        $user->enrollment_origin = $request->enrollmentOrigin ?? $user->enrollment_origin;

        if (!is_null($request->enrollmentDate)) {
            $user->enrollment_date = Carbon::createFromFormat('d/m/Y', $request->enrollmentDate)->format('Y-m-d');
        } else {
            $user->enrollment_date = null;
        }

        $user->gender = $request->gender ?? $user->gender;

        if (!is_null($request->roles)) {
            $user->syncRoles($request->roles);
        }

        if (!is_null($request->profilePicture)) {
            $storeFile = $request->profilePicture->store('img/avatars');

            $user->profile_picture = $storeFile;
        }

        if(!is_null($request->family)) {
            if($request->family == 0) { // Remover
                $user->family_id = null;
            } else {
                $user->family_id = $request->family;
            }
        }

        $user->save();

        return redirect()
            ->back()
            ->withSuccess(is_null($id) ? 'As informações do seu perfil foram atualizadas com sucesso!' : 'As informações do perfil de ' . $user->getShortName() . ' foram atualizadas com sucesso!');
    }
}
