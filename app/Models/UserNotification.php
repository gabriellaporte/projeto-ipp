<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $table = 'users_notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'notification_id',
        'sender_id',
        'user_id',
        'read'
    ];

    /**
     * Retorna a notificação da tabela 'notifications'
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function notification() {
        return $this->belongsTo(Notification::class, 'notification_id');
    }

    /**
     * Retorna o usuário que enviou a notificação (0, se for o sistema)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Retorna o usuário que recebeu a notificação
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
