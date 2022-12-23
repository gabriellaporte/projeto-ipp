<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tithe extends Model
{
    use HasFactory;

    protected $table = 'tithes';

    protected $fillable = [
        'user_id',
        'amount',
        'payment_type',
        'payed_at',
        'first_checker',
        'second_checker',
        'observation',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function firstChecker()
    {
        return $this->belongsTo(User::class, 'first_checker');
    }

    public function secondChecker()
    {
        return $this->belongsTo(User::class, 'second_checker');
    }
}
