<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\NotificationSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationSettingController extends Controller
{
    public function index(): View
    {
        $notificationSettings = NotificationSetting::where('user_id', auth()->user()->id)->get();

        return view('content.account.notification-settings', ['notSettings' => $notificationSettings]);
    }

    public function edit(Request $request)
    {
        $notifications = array_merge(array_fill_keys(NotificationSetting::NOTIFICATION_TYPES, null), $request->except('_token'));

        foreach($notifications as $name => $value) {
            $this->changeUserNotification($name, (bool) $value);
        }

        return back()->withSuccess('Você atualizou as suas configurações de notificações com sucesso!');
    }

    private function changeUserNotification(string $name, bool $value): void
    {
        $notSetting = auth()->user()->notificationSettings()->where('name', $name)->first();

        $notSetting->update([
            'value' => $value
        ]);
    }
}
