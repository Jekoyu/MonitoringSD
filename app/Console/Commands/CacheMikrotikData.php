<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MikrotikService;
use Illuminate\Support\Facades\Storage;

class CacheMikrotikData extends Command
{
    protected $signature = 'mikrotik:cache-all';
    protected $description = 'Ambil semua data Mikrotik & cache ke file JSON';

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

        // Simpan semua data ke file JSON
        $dataList = [
            'interfaces'     => ['method' => 'getInterfaces',    'file' => 'mikrotik/interfaces.json'],
            'arp'            => ['method' => 'getArp',           'file' => 'mikrotik/arp.json'],
            'dhcp_leases'    => ['method' => 'getDhcpLeases',    'file' => 'mikrotik/dhcp_leases.json'],
            'resource'       => ['method' => 'getResources',     'file' => 'mikrotik/resource.json'],
            'logs'           => ['method' => 'getLogs',          'file' => 'mikrotik/logs.json'],
            'identity'       => ['method' => 'getSystemIdentity','file' => 'mikrotik/identity.json'],
            // Tambahkan endpoint lain kalau perlu
        ];

        foreach ($dataList as $key => $cfg) {
            try {
                $data = $this->mikrotik->{$cfg['method']}();
                Storage::put($cfg['file'], json_encode($data, JSON_PRETTY_PRINT));
                $this->info("Berhasil cache $key ke {$cfg['file']}");
            } catch (\Exception $e) {
                $this->error("Gagal cache $key: {$e->getMessage()}");
            }
        }
    }
}
