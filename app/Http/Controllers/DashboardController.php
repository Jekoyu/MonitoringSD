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
        return view('dashboard', [
            'devices' => Device::all(),
            'logs' => NetworkLog::latest()->take(10)->get(),
            'bandwidth' => BandwidthUsage::latest()->take(5)->get(),
            'notifications' => Notification::latest()->take(5)->get(),
        ]);
    }
}
