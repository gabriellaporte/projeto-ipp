<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchAddressRequest;
use App\Http\Requests\SearchUsersRequest;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Executa as buscas por um usuário com os critérios e retorna a view com os resultados
     *
     * @param SearchUsersRequest $request   |   Critérios de busca
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function searchUsers(SearchUsersRequest $request) {
        $users = User::orderBy('name', 'asc');

        if(!is_null($request->search_name)) {
            $users->whereRaw('lower(name) like (?)', '%' . strtolower($request->search_name) . '%');
        }

        if(!is_null($request->search_since)) {
            $users->whereDate('birth_date', '>=', $request->search_since);
        }

        if(!is_null($request->search_to)) {
            $users->whereDate('birth_date', '<=', $request->search_to);
        }

        if(!is_null($request->search_gender)) {
            $users->where('gender', $request->search_gender);
        }

        $users = $users->paginate(10);

        return view('content.search.member_search')
            ->with('users', $users);
    }


    public function searchAddresses(SearchAddressRequest $request) {
        $addresses = Address::orderBy('id', 'asc');

        if(!is_null($request->search_city)) {
            $addresses->where('city', $request->search_city);
        }

        if(!is_null($request->search_area)) {
            $addresses->where('area', $request->search_area);
        }

        $addresses = $addresses->select('user_id')->distinct()->get();
        $users = [];

        foreach($addresses as $address) {
            $users[] = $address->user->id;
        }

        $users = User::whereIn('id', $users)->orderBy('name', 'asc')->paginate(10);

        return view('content.search.address_search')
            ->with('users', $users);
    }
}
