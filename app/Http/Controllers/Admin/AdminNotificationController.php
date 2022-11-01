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
        $notifications = Notification::orderBy('id', 'desc')->paginate(10);

        return view('content.admin.admin_notifications')
            ->with('users', $users)
            ->with('notifications', $notifications);
    }

    /**
     * Armazena a notificação e vincula aos usuários destinatários
     *
     * @param NotificationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Edita e altera a notificação, vinculando aos respectivos destinatários
     *
     * @param NotificationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editNotification(NotificationRequest $request)
    {
        $users = json_decode($request->users);

        if(!count($users)) {
            return redirect()
                ->back()
                ->withErrors('Por favor, selecione novamente o(s) usuário(s) destinatário(s).');
        }

        $notification = Notification::find($request->id);

        if(is_null($notification)) {
            return redirect()
                ->back()
                ->withErrors('Houve um erro ao tentar editar a notificação. Tente novamente.');
        }

        $notification->title = $request->title;
        $notification->content = $request->message;
        $notification->save();

        // Deletar os vínculos existentes de usuário e notificação
        foreach($notification->users as $user) {
            $user->delete();
        }

        // Vincular os usuários à notificação
        foreach($users as $user) {
            UserNotification::create([
                'notification_id' => $notification->id,
                'sender_id' => auth()->user()->id,
                'user_id' => $user->value
            ]);
        }

        return redirect()
            ->back()
            ->withSuccess('Você alterou a notificação com sucesso!');
    }

    /**
     * Deleta uma notificação e seus vínculos de usuário
     *
     * @param $id   |   O ID da notificação a ser excluida
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteNotification($id) {
        $notification = Notification::find($id);

        if(is_null($notification)) {
            return redirect()
                ->back()
                ->withErrors('Não foi possível acessar a notificação especificada. Tente novamente.');
        }

        $notification->delete();

        return redirect()
            ->back()
            ->withSuccess('Você deletou a notificação com sucesso.');
    }
}
