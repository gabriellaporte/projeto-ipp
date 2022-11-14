<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\DeleteAddressRequest;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    public function sync(AddressRequest $request): RedirectResponse
    {
        auth()->user()->addresses()->delete();

        for($i = 0; $i < count($request->address); $i++)
        {
            Address::create([
                'user_id' => auth()->user()->id,
                'nice_name' => $request->nice_name[$i],
                'address' => $request->address[$i],
                'cep' => $request->cep[$i],
                'area' => $request->area[$i],
                'house_number' => $request->house_number[$i],
                'address_complement' => $request->address_complement[$i],
                'city' => $request->city[$i],
                'state' => $request->state[$i],
            ]);
        }

        return back()->withSuccess('Você salvou os seus endereços com sucesso.');
    }

    public function flush(): RedirectResponse
    {
        auth()->user()->addresses()->delete();

        return back()->withWarning('Você deletou os seus endereços.');
    }

    public function destroy(DeleteAddressRequest $request, Address $address): RedirectResponse
    {
        $address->delete();

        return back()->withSuccess("Você deletou o endereço '" . $address->nice_name . "' com sucesso!");
    }
}
