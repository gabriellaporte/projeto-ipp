<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchUsersRequest;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
}
