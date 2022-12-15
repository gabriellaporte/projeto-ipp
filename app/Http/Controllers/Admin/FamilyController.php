<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFamilyRequest;
use App\Models\Family;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FamilyController extends AdminController
{
    public function index(): View
    {
        $families = Family::orderBy('name', 'asc')->paginate(10);
        $users = User::orderBy('name', 'asc')->get(); // Todos usuários
        $unassignedUsers = User::whereNull('family_id')->orderBy('name', 'asc')->get(); // Usuários sem família vinculada

        return view('content.admin.families', compact('families', 'unassignedUsers', 'users'));
    }

    public function store(StoreFamilyRequest $request): RedirectResponse
    {
        $users = collect(json_decode($request->users)) ?? [];

        $family = Family::create([
            'name' => $request->name
        ]);

        User::whereIn('id', $users->pluck('value'))->update([
            'family_id' => $family->id
        ]);

        return back()->withSuccess('Você criou a família ' . $family->name . ' com sucesso!');
    }

    public function update(Family $family, StoreFamilyRequest $request): RedirectResponse
    {
        $users = collect(json_decode($request->users)) ?? [];


        $family->update([
            'name' => $request->name
        ]);

        // Retirar a família de todos usuários para atualizar novamente
        User::where('family_id', $family->id)->update(['family_id' => null]);

        // Setar a família nos usuários atuais
        User::whereIn('id', $users->pluck('value'))->update([
            'family_id' => $family->id
        ]);

        return back()->withSuccess('Você editou a família ' . $family->name . ' com sucesso!');
    }

    public function delete(Family $family): RedirectResponse
    {
        $family->delete();

        return back()->withSuccess('Você deletou a família ' . $family->name . ' com sucesso!');
    }
}
