<?php

namespace App\Models\TithesOfferings;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitheOffering extends Model
{
    use HasFactory;

    protected $table = 'tithes_offerings';

    protected $fillable = [
        'user_id',
        'type',
        'observation',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(TitheOfferingType::class, 'type');
    }

    public function payment()
    {
        return $this->hasOne(TitheOfferingPayment::class, 'tithe_offering_id');
    }

    public function checkers()
    {
        return $this->hasOne(TitheOfferingChecker::class, 'tithe_offering_id');
    }
}
