<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Family;
use App\Models\Notification;
use App\Models\TithesOfferings\TitheOfferingType;
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
        $addresses = Address::select(DB::raw("address, house_number, address_complement, area, cep, city, state, GROUP_CONCAT(DISTINCT user_id) as `users`, GROUP_CONCAT(DISTINCT u.name ORDER BY u.id ASC) as `users_names`"))
            ->join('users as u', 'user_id', 'u.id')
            ->groupBy('address', 'house_number', 'address_complement', 'area', 'cep', 'city', 'state')
            ->get();

        return response()->json($addresses);
    }

    /**
     * Retorna uma notificação e os usuários que a receberam
     *
     * @param $id   |   O ID da notificação
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function getNotification($id) {
        $notification = Notification::find($id);

        if(is_null($notification)) {
            return [];
        }

        /* Preparando o usuário para se adequar aos moldes da whitelist do Tagify */
        $user[] = [
            'value' => $notification->user->id,
            'name' => $notification->user->name,
            'avatar' => asset('storage/' . $notification->user->profile_picture ),
            'email' => $notification->user->email
        ];


        $notification['tagify_user'] = $user;

        return response()->json($notification);
    }

    /**
     * Retorna uma família e os usuários que pertencem a ela
     *
     * @param $id   |   O id da família
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function getFamily($id) {
        $family = Family::find($id);

        if(is_null($family)) {
            return [];
        }

        /* Preparando a lista de usuários para se adequar aos moldes da whitelist do Tagify */
        $users = array();

        foreach($family->users as $user) {
            $users[] = [
                'value' => $user->id,
                'name' => $user->name,
                'avatar' => asset('storage/' . $user->profile_picture ),
                'email' => $user->email
            ];
        }
        $response = $family->toArray();
        $response['users'] = $users;

        return response()->json($response);
    }

    /**
     * Retorna uma categoria
     *
     * @param $id   |   O ID da notificação
     */
    public function getCategoryInfo(TitheOfferingType $category) {
        return response()->json($category);
    }
}
