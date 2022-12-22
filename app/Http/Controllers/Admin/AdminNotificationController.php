<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\AdminNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Notification as NotificationFacade;

class AdminNotificationController extends AdminController
{
    public function index(): View
    {
        $users = User::all()->sortBy('name');
        $notifications = Notification::orderBy('created_at', 'desc')->paginate(10);

        return view('content.admin.admin_notifications', compact('users', 'notifications'));
    }

    public function store(StoreNotificationRequest $request): RedirectResponse
    {
        $users = User::whereIn('id',
            collect($request->users)->pluck('value')
                ->toArray()
        )->get();

        NotificationFacade::send($users, new AdminNotification($request->title, $request->content, auth()->user()->id));

        return back()->withSuccess('Você enviou a notificação com sucesso!');
    }

    public function update(Notification $notification, UpdateNotificationRequest $request)
    {
        $notification->update([
            'data' => json_encode($request->only('title', 'content')),
            'sender_id' => auth()->user()->id
        ]);

        return back()->withSuccess('Você alterou a notificação com sucesso! Esta alteração só surte efeito no nosso sistema: os e-mails enviados continuarão os mesmos.');
    }

    public function delete(Notification $notification) {
        $notification->delete();

        return back()->withSuccess('Você deletou a notificação com sucesso.');
    }
}
