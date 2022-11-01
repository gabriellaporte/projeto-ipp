<?php

namespace App\Http\Controllers;

use App\Models\NotificationSetting;
use Illuminate\Http\Request;

class NotificationSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Sincroniza as notificações do usuário enviadas pela requisição ($request)
     *
     * @param Request $request | A requisição em método POST
     * @return void
     */
    public function syncNotifications(Request $request)
    {

        !is_null($request->system_tithes_notification) ? $this->changeNotification(auth()->user()->id, 'system_tithes_notification', true) : $this->changeNotification(auth()->user()->id, 'system_tithes_notification', false);
        !is_null($request->system_offers_notification) ? $this->changeNotification(auth()->user()->id, 'system_offers_notification', true) : $this->changeNotification(auth()->user()->id, 'system_offers_notification', false);
        !is_null($request->system_birthdate_notification) ? $this->changeNotification(auth()->user()->id, 'system_birthdate_notification', true) : $this->changeNotification(auth()->user()->id, 'system_birthdate_notification', false);
        !is_null($request->email_tithes_notification) ? $this->changeNotification(auth()->user()->id, 'email_tithes_notification', true) : $this->changeNotification(auth()->user()->id, 'email_tithes_notification', false);
        !is_null($request->email_offers_notification) ? $this->changeNotification(auth()->user()->id, 'email_offers_notification', true) : $this->changeNotification(auth()->user()->id, 'email_offers_notification', false);
        !is_null($request->email_birthday_notification) ? $this->changeNotification(auth()->user()->id, 'email_birthday_notification', true) : $this->changeNotification(auth()->user()->id, 'email_birthday_notification', false);
        !is_null($request->email_system_notification) ? $this->changeNotification(auth()->user()->id, 'email_system_notification', true) : $this->changeNotification(auth()->user()->id, 'email_system_notification', false);

        return redirect()
            ->back()
            ->withSuccess('Você atualizou as suas configurações de notificações com sucesso!');
    }

    /**
     * Função responsável por alterar uma notificação ($name, $value) de um usuário ($id). Se não tiver, cria com os parâmetros informados.
     *
     * @param $id | O ID do usuário a ser modificado
     * @param $name | A "chave" da notificação, ou, o nome dela
     * @param boolean $value | O valor (true ou false)
     * @return void
     */
    public function changeNotification($id, $name, bool $value)
    {
        $notSetting = NotificationSetting::where('user_id', $id)->where('name', $name)->first();

        if (is_null($notSetting)) {
            $notSetting = new NotificationSetting;

            $notSetting->user_id = $id;
            $notSetting->name = $name;
        }

        $notSetting->value = $value;

        $notSetting->save();
    }
}
