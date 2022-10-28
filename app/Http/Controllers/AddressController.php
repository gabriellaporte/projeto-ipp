<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Sincroniza todos endereços ($request) de um usuário ($id)
     *
     * @param AddressRequest $request | Requisição via POST (idealmente uma array de arrays)
     * @param $id | ID do usuário. Se for null, pega o usuário atual autenticado
     * @return \Illuminate\Http\RedirectResponse
     */
    public function syncAddresses(AddressRequest $request, $id = null)
    {
        $user = User::find($id) ?? auth()->user();

        if (!CanEditUser($id)) {
            return redirect()
                ->back()
                ->withErrors('Você não tem permissão para editar os endereços deste usuário.')
                ->withInput();
        }

        $addressesCount = count($request->niceName);

        if (!$addressesCount) {
            return redirect()
                ->back()
                ->withErrors('Oops! Houve um erro, tente novamente.')
                ->withInput();
        }

        $user->addresses()->delete();

        for ($i = 0; $i < $addressesCount; $i++) {
            $address = new Address;

            $address->user_id = $user->id;
            $address->nice_name = $request->niceName[$i];
            $address->address = $request->address[$i];
            $address->house_number = $request->houseNumber[$i];
            $address->address_complement = $request->addressComplement[$i];
            $address->area = $request->area[$i];
            $address->cep = $request->cep[$i];
            $address->city = $request->city[$i];
            $address->state = $request->state[$i];

            $address->save();
        }

        return redirect()
            ->back()
            ->withSuccess(is_null($id) ? 'Você salvou todos seus endereços com sucesso!' : 'Você salvou todos os endereços de ' . $user->getShortName() . ' com sucesso!');
    }

    /**
     * Deleta todos os endereços de um usuário ($id)
     *
     * @param $id | ID do usuário.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAddresses($id)
    {
        $user = User::find($id) ?? auth()->user();

        if (!CanEditUser($id)) {
            return redirect()
                ->back()
                ->withErrors('Você não tem permissão para editar os endereços deste usuário')
                ->withInput();
        }

        if (!count($user->addresses)) {
            return redirect()
                ->back()
                ->withWarning(is_null($id) ? 'Você ainda não tem nenhum endereço salvo.' : $user->getShortName() . ' ainda não tem nenhum endereço salvo.')
                ->withInput();
        }

        $user->addresses()->delete();

        return redirect()
            ->back()
            ->withSuccess(is_null($id) ? 'Você deletou todos os seus endereços com sucesso.' : 'Você deletou todos os endereços de ' . $user->getShortName() . '.')
            ->withInput();
    }

    /**
     * Deleta um único endereço ($id)
     *
     * @param $id | ID do endereço.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $address = Address::find($id);

        if (is_null($address)) {
            return redirect()
                ->back()
                ->withErrors('Este endereço não existe.');
        }

        if (!CanEditAddress($id)) {
            return redirect()
                ->back()
                ->withErrors('Você não tem permissão para editar este endereço.')
                ->withInput();
        }

        $address->delete();

        return redirect()
            ->back()
            ->withSuccess('Você deletou este endereço com sucesso!')
            ->withInput();
    }
}
