<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);

            if ($request->username === 'superadmin' && $request->password === 'superadmin') {
                Session::put('user', 'superadmin');
                // return response()->json(['message' => 'Login berhasil', 'status' => 'success'], 200);
                return redirect('/dashboard');
            }
        } catch (Exception $e) {
            Log::error('eror' . $e->getMessage());
            return response()->json(['message' => 'Login gagal', 'status' => 'error'], 401);
            
        }
    }

    public function logout()
    {
        Session::forget('user');
        return response()->json(['message' => 'Logout berhasil', 'status' => 'success'], 200);
    }
}
