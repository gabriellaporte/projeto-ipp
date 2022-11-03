<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    /**
     * Exibe uma lista de endereços. Se o ID do usuário for null, agrupa todos usuários de um mesmo endereço e lista todos endereços existentes.
     *
     * @param $userID   |   ID do usuário
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserAddresses($userID = null)
    {
        // Caso tenha o usuário especificado, retornar apenas os endereços vinculados
        if(!is_null($userID)) {
            $addresses = Address::where('user_id', $userID)->orderBy('id', 'asc')->get();

            return response()->json($addresses);
        }

        // Se não tiver usuário, retornar todos
        $addresses = Address::select(DB::raw("address, house_number, address_complement, area, cep, city, state, GROUP_CONCAT(DISTINCT a.user_id) as `users`, GROUP_CONCAT(DISTINCT u.name ORDER BY u.id ASC) as `users_names`"))
            ->join('users as u', 'a.user_id', 'u.id')
            ->groupBy('address', 'house_number', 'address_complement', 'area', 'cep', 'city', 'state')
            ->get();

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
