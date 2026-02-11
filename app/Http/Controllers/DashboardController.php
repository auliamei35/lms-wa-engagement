<?php

namespace App\Http\Controllers;

use App\Models\MessageLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data log terbaru
        $logs = MessageLog::latest()->get();

        return view('dashboard', compact('logs'));
    }
}