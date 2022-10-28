<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    /**
     *
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showLoginPage()
    {
        if (Auth::check()) {
            return redirect()
                ->route('index')
                ->withWarning('Você já está autenticado!');
        }

        return view('content.authentications.login');
    }

    /**
     * Função responsável pelo logout de usuários
     *
     * @return mixed
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()
            ->route('login')
            ->withWarning('Você se desconectou.');
    }

    // Index (página de recover password)
    public function showRecoverPasswordPage()
    {
        return view('content.authentications.forgot-password');
    }
}
