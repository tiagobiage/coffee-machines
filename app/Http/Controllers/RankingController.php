<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index()
    {
        $ranking = Order::ranking()->get();
        return view('admin/ranking/index', compact('ranking'));
    }
}
