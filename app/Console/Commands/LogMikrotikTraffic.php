<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Services\MikrotikService;

class LogMikrotikTraffic extends Command
{
    protected $signature = 'mikrotik:log-traffic';
    protected $description = 'Log MikroTik interface traffic bandwidth periodically';

    protected $mikrotik;

    public function __construct(MikrotikService $mikrotik)
    {
        parent::__construct();
        $this->mikrotik = $mikrotik;
    }

    public function handle()
    {
        if ($this->mikrotik->hasConnectionError()) {
            $this->error('Mikrotik connection failed');
            return;
        }

        // Bisa ganti sesuai interface yang mau di-log
        $interfaces = ['ether1'];
        $filename = 'mikrotik/traffic_logs.json';

        $logs = Storage::exists($filename)
            ? json_decode(Storage::get($filename), true)
            : [];

        foreach ($interfaces as $iface) {
            $trafficArray = $this->mikrotik->getInterfaceTraffic($iface);

           
            $traffic = $trafficArray[0] ?? [];

            $logs[] = [
                'timestamp' => now()->toDateTimeString(),
                'interface' => $iface,
                'rx_bps'    => isset($traffic['rx-bits-per-second']) ? (int)$traffic['rx-bits-per-second'] : 0,
                'tx_bps'    => isset($traffic['tx-bits-per-second']) ? (int)$traffic['tx-bits-per-second'] : 0
            ];
        }

        Storage::put($filename, json_encode($logs, JSON_PRETTY_PRINT));
        $this->info("Traffic bandwidth logged.");
    }
}
