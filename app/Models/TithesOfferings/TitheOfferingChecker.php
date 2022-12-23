<?php

namespace App\Models\TithesOfferings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitheOfferingChecker extends Model
{
    use HasFactory;

    protected $table = 'tithes_offerings_checkers';
    public $timestamps = false;

    protected $fillable = [
        'tithe_offering_id',
        'first_checker',
        'second_checker',
    ];
}
