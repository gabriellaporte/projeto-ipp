<?php

namespace App\Models\TithesOfferings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitheOfferingPayment extends Model
{
    use HasFactory;

    protected $table = 'tithes_offerings_payment';
    public $timestamps = false;

    protected $fillable = [
        'tithe_offering_id',
        'payment_type',
        'amount',
        'payed_at',
    ];

    public function paymentType()
    {
        return $this->belongsTo(TitheOfferingPaymentType::class, 'payment_type');
    }
}
