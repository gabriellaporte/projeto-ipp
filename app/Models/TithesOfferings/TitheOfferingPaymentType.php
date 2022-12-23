<?php

namespace App\Models\TithesOfferings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitheOfferingPaymentType extends Model
{
    use HasFactory;

    protected $table = 'tithes_offerings_payment_types';
    public $timestamps = false;

    protected $fillable = [
        'type_name',
        'is_in_cash'
    ];
}
