<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class AdminNotificationController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Exibe todas notificações e gerencia também.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showNotifications()
    {
        $users = User::all()->sortBy('name');

        return view('content.admin.admin_notifications')
            ->with('users', $users);
    }

    public function storeNotification(NotificationRequest $request)
    {
        $users = json_decode($request->users);

        if(!count($users)) {
            return redirect()
                ->back()
                ->withErrors('Por favor, selecione novamente o(s) usuário(s) destinatário(s).');
        }

        $notification = Notification::create([
            'title' => $request->title,
            'content' => $request->message
        ]);

        foreach($users as $user) {
            UserNotification::create([
                'notification_id' => $notification->id,
                'sender_id' => auth()->user()->id,
                'user_id' => $user->value
            ]);
        }

        return redirect()
            ->back()
            ->withSuccess('Você enviou a notificação com sucesso!');
    }
}
