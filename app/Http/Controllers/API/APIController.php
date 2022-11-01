<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Notification;
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

    public function getNotification($id) {
        $notification = Notification::find($id);

        if(is_null($notification)) {
            return [];
        }

        /* Preparando a lista de usuários para se adequar aos moldes da whitelist do Tagify */
        $users = array();

        foreach($notification->users as $user) {
            $users[] = [
                'value' => $user->user->id,
                'name' => $user->user->name,
                'avatar' => asset('storage/' . $user->user->profile_picture ),
                'email' => $user->user->email
            ];
        }
        $response = $notification->toArray();
        $response['users'] = $users;

        return response()->json($response);
    }
}
