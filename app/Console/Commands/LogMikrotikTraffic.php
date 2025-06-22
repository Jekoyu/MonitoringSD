<?php
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Services\MikrotikService;

class LogMikrotikTraffic extends Command
{
    protected $signature = 'mikrotik:log-traffic';
    protected $description = 'Log MikroTik interface traffic periodically';

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

        $interfaces = ['ether1']; 
        $filename = 'mikrotik/traffic_logs.json';

        $logs = Storage::exists($filename)
            ? json_decode(Storage::get($filename), true)
            : [];

        foreach ($interfaces as $iface) {
            $traffic = $this->mikrotik->getInterfaceTraffic($iface);

            $logs[] = [
                'timestamp' => now()->toDateTimeString(),
                'interface' => $iface,
                'rx' => $traffic['rx-byte'],
                'tx' => $traffic['tx-byte']
            ];
        }

        Storage::put($filename, json_encode($logs, JSON_PRETTY_PRINT));
        $this->info("Traffic logged.");
    }
}
