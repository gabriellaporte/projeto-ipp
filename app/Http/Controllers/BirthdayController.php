<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class BirthdayController extends Controller
{
    public function index(): View
    {
        $monthsNames = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
        $userBirthdays = [];

        foreach($monthsNames as $index => $name) {
            $userBirthdays[] = User::whereMonth('birth_date', $index + 1)->orderBy('birth_date', 'desc')->get();;
        }

        return view('content.members.birthdays', ['userBirthdays' => $userBirthdays, 'monthsNames' => $monthsNames]);
    }
}
