<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    public function index()
    {
        return response()->json(Device::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'ip_address' => 'required|ipv4|unique:devices',
            'mac_address' => 'required|string|unique:devices',
            'type' => 'required|in:pc,router,printer,switch',
        ]);

        $device = Device::create($request->all());
        return response()->json(['message' => 'Perangkat berhasil ditambahkan', 'device' => $device], 201);
    }

    public function show($id)
    {
        return response()->json(Device::findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        $device = Device::findOrFail($id);
        $device->update($request->all());
        return response()->json(['message' => 'Perangkat berhasil diperbarui', 'device' => $device], 200);
    }

    public function destroy($id)
    {
        Device::destroy($id);
        return response()->json(['message' => 'Perangkat berhasil dihapus'], 200);
    }
}
