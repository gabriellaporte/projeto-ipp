<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    use HasFactory;

    const NOTIFICATION_TYPES = [
        'system_tithes_notification',
        'system_offers_notification',
        'system_birthdate_notification',
        'email_tithes_notification',
        'email_offers_notification',
        'email_birthday_notification',
        'email_system_notification'
    ];

    protected $table = 'notification_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'value',
    ];


}
