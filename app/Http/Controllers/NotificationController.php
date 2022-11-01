<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Retorna a view de notificações do usuário
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index() {
        $userNotifications = auth()->user()->notifications()->orderBy('id', 'desc')->paginate(5);

        return view('content.account.notifications')
            ->with('notifications', $userNotifications);
    }

    /**
     * Marca uma notificação como lida
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function readNotification($id) {
        $notification = UserNotification::find($id);

        if(is_null($notification)) {
            $response_array['status'] = 400;
            $response_array['message'] = 'Notificação inválida. Tente novamente.';

            return response()->json($response_array);
        }

        if(!canReadNotification($id)) {
            $response_array['status'] = 400;
            $response_array['message'] = 'Você não tem permissão para editar esta notificação.';

            return response()->json($response_array);
        }

        $notification->read = 1;
        $notification->save();

        $response_array['status'] = 200;
        $response_array['message'] = 'Você marcou a notificação como lida.';

        return response()->json($response_array);
    }
}
