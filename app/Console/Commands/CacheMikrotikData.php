<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MikrotikService;
use Illuminate\Support\Facades\Cache;

class CacheMikrotikData extends Command
{
    protected $signature = 'mikrotik:cache-to-redis';
    protected $description = 'Ambil semua data Mikrotik dan simpan ke Redis';

    protected $mikrotik;

    public function __construct(MikrotikService $mikrotik)
    {
        parent::__construct();
        $this->mikrotik = $mikrotik;
    }

    public function handle()
    {
        if ($this->mikrotik->hasConnectionError()) {
            $this->error("Gagal konek ke Mikrotik: " . $this->mikrotik->getConnectionError());
            return;
        }

        $dataList = [
            'interfaces'  => 'getInterfaces',
            'arp'         => 'getArp',
            'dhcp_leases' => 'getDhcpLeases',
            'resource'    => 'getResources',
            'logs'        => 'getLogs',
            'identity'    => 'getSystemIdentity',
        ];

        foreach ($dataList as $key => $method) {
            try {
                $data = $this->mikrotik->{$method}();
                Cache::put("mikrotik:$key", json_encode($data), now()->addMinutes(5));
                $this->info("✔ Cached $key to Redis.");
            } catch (\Exception $e) {
                $this->warn("✘ Gagal ambil $key: " . $e->getMessage());
            }
        }

        \Log::info('mikrotik:cache-to-redis run at ' . now());
    }
}
