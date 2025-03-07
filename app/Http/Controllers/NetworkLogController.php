<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NetworkLog;

class NetworkLogController extends Controller
{
    public function index()
    {
        return response()->json(NetworkLog::with('device')->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'action' => 'required|string',
        ]);

        $log = NetworkLog::create($request->all());
        return response()->json(['message' => 'Log berhasil ditambahkan', 'log' => $log], 201);
    }

    public function show($id)
    {
        return response()->json(NetworkLog::findOrFail($id), 200);
    }

    public function destroy($id)
    {
        NetworkLog::destroy($id);
        return response()->json(['message' => 'Log berhasil dihapus'], 200);
    }
}
