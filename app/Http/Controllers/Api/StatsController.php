<?php

namespace App\Http\Controllers\Api;

use App\Models\Stat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class StatsController extends Controller
{
    public function index()
    {
        $stats = User::all();
        return response()->json($stats);
    }
}
