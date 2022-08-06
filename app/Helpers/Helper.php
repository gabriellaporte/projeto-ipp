<?php

use Illuminate\Support\Facades\Auth;

function canEditUser($id) {
  if(auth()->user()->id == $id) {
    return true;
  }

  if(auth()->user()->can('users.edit')) {
    return true;
  }

  return false;
}

function canEditAddress($id) {
  if(in_array($id, auth()->user()->addresses->pluck('id')->toArray())) {
    return true;
  }

  if(auth()->user()->can('addresses.edit')) {
    return true;
  }

  return false;
}
