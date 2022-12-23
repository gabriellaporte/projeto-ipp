<?php

namespace App\Models\TithesOfferings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitheOfferingType extends Model
{
    use HasFactory;

    protected $table = 'tithes_offerings_types';
    public $timestamps = false;

    protected $fillable = [
        'type_name',
        'is_offering'
    ];

    public function tithesAndOfferings()
    {
        return $this->hasMany(TitheOffering::class, 'type');
    }
}
