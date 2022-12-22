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
     * Retorna a lista com todas as cidades existentes
     *
     * @return mixed    |   Array contendo somente o nome das cidades
     */
    public static function getExistingCities() {
        $areas = Address::select('city')->distinct()
            ->orderBy('city', 'asc')
            ->get();

        return $areas->pluck('city')->toArray();
    }

    /**
     * Retorna a lista com todos bairros existentes
     *
     * @param $city     |   Nome da cidade que os bairros estão. Se for null, pega todos bairros cadastrados.
     * @return mixed    |   Array contendo somente o nome dos bairros
     */
    public static function getExistingAreas($city = null) {
        $areas = Address::select('area')->distinct()->orderBy('area', 'asc');

        if($city) {
            $areas->where('city', $city);
        }

        return $areas->get()->pluck('area')->toArray();
    }
}
