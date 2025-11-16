<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Stat\StatResource;
use App\Models\Stat;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function index()
    {
        $stats = Stat::all();
        $stats = StatResource::collection($stats)->resolve();
        return inertia('Admin/Stat/Index', compact('stats'));
    }
}
