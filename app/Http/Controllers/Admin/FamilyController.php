<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFamilyRequest;
use App\Models\Family;
use App\Models\User;
use Illuminate\Http\Request;

class FamilyController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Exibe a lista de famílias ativas e inativas
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showFamilies() {
        $families = Family::orderBy('name', 'asc')->paginate(10);
        $users = User::orderBy('name', 'asc')->get(); // Todos usuários
        $unassignedUsers = User::whereNull('family_id')->orderBy('name', 'asc')->get(); // Usuários sem família vinculada

        return view('content.admin.families')
            ->with('families', $families)
            ->with('unassignedUsers', $unassignedUsers)
            ->with('users', $users);
    }

    /**
     * Armazena uma nova família com os dados enviados (nome e usuários a serem vinculados)
     *
     * @param StoreFamilyRequest $request   |   Dados enviados
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeFamily(StoreFamilyRequest $request) {
        $users = json_decode($request->users) ?? [];

        $existingName = Family::where('name', $request->name)->exists();
        if($existingName) {
            return redirect()
                ->back()
                ->withErrors('Já existe uma família com este nome.');
        }

        $family = Family::create([
            'name' => $request->name
        ]);

        foreach($users as $user) {
            User::find($user->value)->update(['family_id' => $family->id]);
        }

        return redirect()
            ->back()
            ->withSuccess('Você criou a família ' . $family->name . ' com sucesso!');
    }

    /**
     * Edita uma família com os dados enviados (nome e usuários a serem vinculados)
     *
     * @param StoreFamilyRequest $request   |   Dados enviados
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editFamily(StoreFamilyRequest $request) {
        $users = json_decode($request->users) ?? [];

        $family = Family::find($request->id);

        if(is_null($family)) {
            return redirect()
                ->back()
                ->withErrors('Não foi possível encontrar a família acessada. Tente novamente.');
        }

        $existingName = Family::where('name', $request->name)->where('id', '!=', $request->id)->exists();
        if($existingName) {
            return redirect()
                ->back()
                ->withErrors('Já existe uma família com este nome.');
        }

        $family->update(['name' => $request->name]);

        User::where('family_id', $request->id)->update(['family_id' => null]);

        foreach($users as $user) {
            User::find($user->value)->update(['family_id' => $family->id]);
        }

        return redirect()
            ->back()
            ->withSuccess('Você editou a família ' . $family->name . ' com sucesso!');
    }

    /**
     * Deleta uma família pelo seu ID
     *
     * @param $id   |   ID da família
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteFamily($id) {
        $family = Family::find($id);

        if(is_null($family)) {
            return redirect()
                ->back()
                ->withErrors('Houve um problema no banco de dados. Tente novamente.');
        }

        $family->delete();

        return redirect()
            ->back()
            ->withSuccess('Você deletou a família ' . $family->name . ' com sucesso!');
    }
}
