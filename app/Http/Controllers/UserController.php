<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Address;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
  public function __construct()
  {
    $this->middleware('officer')->except('edit');
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

    if(is_null($user)) {
      return redirect()
        ->back()
        ->withErrors('Não foi possível encontrar este usuário.');
    }

    return view('content.account.account-settings', ['user' => $user, 'roles' => $roles, 'addresses' => $addresses]);
  }

  /**
   * Edita o perfil de um usuário ($id) vindo pela pela requisição ($request)
   *
   * @param ProfileRequest $request | Requisição via POST
   * @param $id | O ID do usuário a ser editado
   * @return \Illuminate\Http\RedirectResponse
   */
  public function edit(ProfileRequest $request, $id = null) {
    $user = User::find($id) ?? auth()->user();

    $user->email = $request->emailAddress;
    $user->mobile_phone = $request->mobilePhone;
    $user->house_phone = $request->housePhone;
    $user->birth_date = Carbon::createFromFormat('d/m/Y', $request->birthDate)->format('y-m-d');
    $user->name = $request->userName;

    $user->enrollment_origin = $request->enrollmentOrigin ?? $user->enrollment_origin;


    if(!is_null($request->enrollmentDate)) {
      $user->enrollment_date = Carbon::createFromFormat('d/m/Y', $request->enrollmentDate)->format('y-m-d');
    } else {
      $user->enrollment_date = null;
    }

    $user->gender = $request->gender ?? $user->gender;

    if(!is_null($request->roles)) {
      $user->syncRoles($request->roles);
    }

    if(!is_null($request->profilePicture)) {
      $storeFile = $request->profilePicture->store('img/avatars');

      $user->profile_picture = $storeFile;
    }

    $user->save();

    return redirect()
      ->back()
      ->withSuccess(is_null($id) ? 'As informações do seu perfil foram atualizadas com sucesso!' : 'As informações do perfil de ' . $user->getShortName() .' foram atualizadas com sucesso!');
  }

}
