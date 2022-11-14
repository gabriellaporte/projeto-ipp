<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nice_name',
        'address',
        'house_number',
        'address_complement',
        'area',
        'cep',
        'city',
        'state',
    ];

    protected $table = 'addresses';

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
