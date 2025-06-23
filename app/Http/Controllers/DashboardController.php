<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\NetworkLog;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\BandwidthUsage;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        
    
        return view('home');
    }
}
