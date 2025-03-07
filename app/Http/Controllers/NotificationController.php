<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        return response()->json(Notification::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $notification = Notification::create($request->all());
        return response()->json(['message' => 'Notifikasi berhasil ditambahkan', 'notification' => $notification], 201);
    }

    public function show($id)
    {
        return response()->json(Notification::findOrFail($id), 200);
    }

    public function update($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['status' => 'read']);
        return response()->json(['message' => 'Notifikasi telah dibaca'], 200);
    }

    public function destroy($id)
    {
        Notification::destroy($id);
        return response()->json(['message' => 'Notifikasi berhasil dihapus'], 200);
    }
}
