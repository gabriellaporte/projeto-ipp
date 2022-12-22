<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function index(): mixed
    {
        if (auth()->check()) {
            return redirect()
                ->route('index')
                ->withWarning('Você já está autenticado!');
        }

        return view('content.authentications.login');
    }

    public function logout(): RedirectResponse
    {
        session()->flush();
        auth()->logout();

        return redirect()
            ->route('login')
            ->withWarning('Você se desconectou.');
    }

    public function showRecoverPasswordPage(): View
    {
        return view('content.authentications.forgot-password');
    }
}
