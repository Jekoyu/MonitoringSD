<?php

namespace App\Http\Controllers;

use App\Services\MikrotikService;

class MikrotikApiController extends Controller
{
    protected $mikrotik;

    public function __construct(MikrotikService $mikrotik)
    {
        $this->mikrotik = $mikrotik;
    }

    public function interfaces()
    {
        try {
            if ($this->mikrotik->hasConnectionError()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $this->mikrotik->getConnectionError()
                ], 500);
            }
    
            return response()->json([
                'status' => 'success',
                'data' => $this->mikrotik->getInterfaces()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function traffic($interface)
    {
        try {
            if ($this->mikrotik->hasConnectionError()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $this->mikrotik->getConnectionError()
                ], 500);
            }
    
            return response()->json([
                'status' => 'success',
                'data' => $this->mikrotik->getInterfaceTraffic($interface)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function arp()
    {
        try {
            if ($this->mikrotik->hasConnectionError()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $this->mikrotik->getConnectionError()
                ], 500);
            }
    
            return response()->json([
                'status' => 'success',
                'data' => $this->mikrotik->getArp()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function dhcpLeases()
    {
        try {
            if ($this->mikrotik->hasConnectionError()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $this->mikrotik->getConnectionError()
                ], 500);
            }
    
            return response()->json([
                'status' => 'success',
                'data' => $this->mikrotik->getDhcpLeases()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function resource()
    {
        try {
            if ($this->mikrotik->hasConnectionError()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $this->mikrotik->getConnectionError()
                ], 500);
            }
    
            return response()->json([
                'status' => 'success',
                'data' => $this->mikrotik->getResources()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function logs()
    {
        try {
            if ($this->mikrotik->hasConnectionError()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $this->mikrotik->getConnectionError()
                ], 500);
            }
    
            return response()->json([
                'status' => 'success',
                'data' => $this->mikrotik->getLogs()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function systemIdentity()
    {
        try {
            if ($this->mikrotik->hasConnectionError()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $this->mikrotik->getConnectionError()
                ], 500);
            }
    
            return response()->json([
                'status' => 'success',
                'data' => $this->mikrotik->getSystemIdentity()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    
}
