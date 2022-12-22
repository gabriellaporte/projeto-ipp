<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        $userNotifications = auth()->user()->notifications()->orderBy('id', 'desc')->paginate(5);

        return view('content.account.notifications')->with('notifications', $userNotifications);
    }

    public function read(Notification $notification): JsonResponse
    {
        if($notification->notifiable_id != auth()->user()->id) {
            $response_array['status'] = 400;
            $response_array['message'] = 'Você não tem permissão para editar esta notificação.';

            return response()->json($response_array);
        }

        $notification->update(['read_at' => now()]);

        $response_array['status'] = 200;
        $response_array['message'] = 'Você marcou a notificação como lida.';

        return response()->json($response_array);
    }
}
