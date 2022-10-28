<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    public function getUserAddresses($userID)
    {
        $addresses = Address::where('user_id', $userID)->orderBy('id', 'asc')->get();

        return response()->json($addresses);
    }
}
