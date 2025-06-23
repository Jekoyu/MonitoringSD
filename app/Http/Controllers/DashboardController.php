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
        // $identity = Storage::get('mikrotik/resource.json'); 
        // $data = json_decode($identity, true);
        // $systemInfo = $data[0];
    
        // $uptime = $systemInfo['uptime'];

        // $json = Storage::get('mikrotik/speed.json');
        // $data = json_decode($json, true);
    
        // $ether2 = collect($data)->firstWhere('name', 'ether2');
    
        return view('home', [
            // 'ether2' => $ether2,
            // 'uptime' => $uptime,
        ]);
    }
}
