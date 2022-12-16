<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NotificationRequest;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminNotificationController extends AdminController
{
    public function index(): View
    {
        $users = User::all()->sortBy('name');
        $notifications = Notification::orderBy('id', 'desc')->paginate(10);

        return view('content.admin.admin_notifications', compact('users', 'notifications'));
    }

    public function store(NotificationRequest $request): RedirectResponse
    {
        $notification = Notification::create($request->only('title', 'content'));

        foreach($request->users as $user) {
            UserNotification::create([
                'notification_id' => $notification->id,
                'sender_id' => auth()->user()->id,
                'user_id' => $user->value
            ]);
        }

        return back()->withSuccess('Você enviou a notificação com sucesso!');
    }

    public function update(Notification $notification, NotificationRequest $request)
    {
        $notification->update($request->only('title', 'content'));

        $notification->users()->delete();

        // Vincular os usuários à notificação
        foreach($request->users as $user) {
            UserNotification::create([
                'notification_id' => $notification->id,
                'sender_id' => auth()->user()->id,
                'user_id' => $user->value
            ]);
        }

        return back()->withSuccess('Você alterou a notificação com sucesso!');
    }

    public function delete(Notification $notification) {
        $notification->delete();

        return back()->withSuccess('Você deletou a notificação com sucesso.');
    }
}
