<?php

namespace App\Http\Controllers\Admin\TithesOfferings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TithesOfferingsController extends Controller
{
    public function index(): View
    {
        $tithes = Tithe::orderBy('created_at', 'desc')->paginate(10);

        return view('content.admin.tithes_offerings', compact('tithes'));
    }
}
