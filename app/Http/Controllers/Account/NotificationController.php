<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        $userNotifications = auth()->user()->notifications()->orderBy('id', 'desc')->paginate(5);

        return view('content.account.notifications')->with('notifications', $userNotifications);
    }

    public function read(UserNotification $notification): JsonResponse
    {
        if(!canReadNotification($notification->id)) {
            $response_array['status'] = 400;
            $response_array['message'] = 'Você não tem permissão para editar esta notificação.';

            return response()->json($response_array);
        }

        $notification->update(['read' => 1]);

        $response_array['status'] = 200;
        $response_array['message'] = 'Você marcou a notificação como lida.';

        return response()->json($response_array);
    }
}
