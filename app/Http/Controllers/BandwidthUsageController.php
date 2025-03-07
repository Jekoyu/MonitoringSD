<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BandwidthUsage;

class BandwidthUsageController extends Controller
{
    public function index()
    {
        return response()->json(BandwidthUsage::with('device')->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'download' => 'required|numeric|min:0',
            'upload' => 'required|numeric|min:0',
        ]);

        $usage = BandwidthUsage::create($request->all());
        return response()->json(['message' => 'Data bandwidth berhasil ditambahkan', 'usage' => $usage], 201);
    }

    public function show($id)
    {
        return response()->json(BandwidthUsage::findOrFail($id), 200);
    }

    public function destroy($id)
    {
        BandwidthUsage::destroy($id);
        return response()->json(['message' => 'Data bandwidth berhasil dihapus'], 200);
    }
}
