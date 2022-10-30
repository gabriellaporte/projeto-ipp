<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\QueryBuilder\QueryBuilder;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostra o index do sistema
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters('name')
            ->allowedSorts('name')
            ->orderBy('name', 'asc')
            ->paginate(5);

        return view('content.index')
            ->with('users', $users);
    }
}
