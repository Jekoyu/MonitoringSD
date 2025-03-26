<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\NetworkLog;
use App\Models\BandwidthUsage;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        return view('home');
    }
}
