<?php

use Illuminate\Support\Facades\Auth;

/**
 * Determina se um usuário logado pode editar um usuário específico
 *
 * @param $id   |   O ID do usuário a ser editado. Checa pelo usuário logado
 * @return bool
 */
function canEditUser($id)
{
    if (auth()->user()->id == $id) {
        return true;
    }

    if (auth()->user()->can('users.edit')) {
        return true;
    }

    return false;
}

/**
 * Determina se um usuário logado pode editar um endereço específico
 *
 * @param $id   |   ID do endereço a ser verificado
 * @return bool
 */
function canEditAddress($id)
{
    if (in_array($id, auth()->user()->addresses->pluck('id')->toArray())) {
        return true;
    }

    if (auth()->user()->can('addresses.edit')) {
        return true;
    }

    return false;
}

/**
 * Determina se um usuário logado pode marcar uma notificação em específico como lida
 *
 * @param $id   |   ID da notificação a ser verificada
 * @return bool
 */
function canReadNotification($id)
{
    if (in_array($id, auth()->user()->notifications->pluck('id')->toArray())) {
        return true;
    }

    if (auth()->user()->can('notifications.read')) {
        return true;
    }

    return false;
}
