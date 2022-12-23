<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tithe;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TitheController extends Controller
{
    public function index(): View
    {
        $tithes = Tithe::orderBy('created_at', 'desc')->paginate(10);

        return view('content.admin.tithes', compact('tithes'));
    }
}
