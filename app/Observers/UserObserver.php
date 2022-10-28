<?php

namespace App\Observers;

use App\Models\NotificationSetting;
use App\Models\User;

class UserObserver
{
    private $notifications = ['system_tithes_notification', 'system_offers_notification', 'system_birthdate_notification',
        'email_tithes_notification', 'email_offers_notification', 'email_birthday_notification', 'email_system_notification'];

    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $user->assignRole('Membro');

        foreach($this->notifications as $notification) {
            NotificationSetting::create([
                'user_id' => $user->id,
                'name' => $notification,
            ]);
        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
