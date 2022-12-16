<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'mobile_phone',
        'house_phone',
        'birth_date',
        'gender',
        'enrollment_date',
        'enrollment_origin',
        'family_id',
        'previous_last_login',
        'last_login'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Retorna todos endereços vinculados ao usuário
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    /**
     * Retorna as configurações de notificação do usuário
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notificationSettings()
    {
        return $this->hasMany(NotificationSetting::class, 'user_id');
    }

    /**
     * Retorna o primeiro nome do usuário
     *
     * @return string
     */
    public function getShortName()
    {
        return explode(' ', $this->name)[0];
    }

    /**
     * Retorna as notificações do usuário
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(UserNotification::class, 'user_id');
    }

    /**
     * Retorna a família ao qual o usuário pertence
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function family()
    {
        return $this->belongsTo(Family::class, 'family_id');
    }
}
