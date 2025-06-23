<?php

namespace App\Services;

use RouterOS\Client;
use RouterOS\Query;
use Exception;

class MikrotikService
{
    protected $client;
    protected $connectionError = null;

    public function __construct()
    {
        try {
            $this->client = new Client([
                'host' => config('mikrotik.host'),
                'user' => config('mikrotik.user'),
                'pass' => config('mikrotik.pass'),
                'timeout' => 100,
            ]);
        } catch (Exception $e) {
            $this->connectionError = 'Gagal membuat koneksi ke Mikrotik: ' . $e->getMessage();
        }
    }

    public function hasConnectionError()
    {
        return $this->connectionError !== null;
    }

    public function getConnectionError()
    {
        return $this->connectionError;
    }

    protected function safeQuery(Query $query)
    {
        if ($this->hasConnectionError()) {
            throw new Exception($this->connectionError);
        }

        $maxAttempts = 3;
        $delaySeconds = 2;
        $attempt = 0;

        while ($attempt < $maxAttempts) {
            try {
                return $this->client->query($query)->read();
            } catch (Exception $e) {
                $attempt++;
                if ($attempt >= $maxAttempts) {
                    throw new Exception('Gagal mengambil data dari Mikrotik setelah beberapa percobaan: ' . $e->getMessage());
                }
                // Optional: log intermediate failure
                \Log::warning("Percobaan $attempt gagal: " . $e->getMessage());
                sleep($delaySeconds);
            }
        }

        // Sebenarnya tidak akan sampai sini
        throw new Exception('Tidak bisa melakukan query Mikrotik.');
    }


    protected $blacklistInterfaces = ['lo', 'wg0'];

    public function getInterfaces()
    {
        $interfaces = $this->safeQuery(new Query('/interface/print'));
        $blacklist = $this->blacklistInterfaces;

        return array_filter($interfaces, function ($iface) use ($blacklist) {
            return !in_array($iface['name'] ?? '', $blacklist);
        });
    }


    public function getInterfaceTraffic($interface)
    {
        $query = (new Query('/interface/monitor-traffic'))
            ->equal('interface', $interface)
            ->equal('once', '');
        return $this->safeQuery($query);
    }

    public function getArp()
    {
        return $this->safeQuery(new Query('/ip/arp/print'));
    }

    public function getDhcpLeases()
    {
        return $this->safeQuery(new Query('/ip/dhcp-server/lease/print'));
    }

    public function getResources()
    {
        return $this->safeQuery(new Query('/system/resource/print'));
    }

    public function getLogs()
    {
        return $this->safeQuery(new Query('/log/print'));
    }

    public function getSystemIdentity()
    {
        return $this->safeQuery(new Query('/system/identity/print'));
    }
    public function getLatency($targetIp = null, $count = 3)
    {
        if ($targetIp === null) {
            $interfaces = $this->getInterfaces();
            $firstIface = $interfaces[0]['name'] ?? null;
            if (!$firstIface) {
                throw new \Exception("Interface tidak ditemukan untuk ping.");
            }
            $targetIp = config('mikrotik.gateway_ip', '10.20.20.2');
        }

        $query = new Query('/ping');
        $query->equal('address', $targetIp)
            ->equal('count', $count);

        $result = $this->safeQuery($query);

        // Hitung rata-rata latency dari hasil ping
        if (empty($result)) {
            throw new \Exception("Ping ke $targetIp gagal.");
        }

        $totalLatency = 0;
        $validCount = 0;
        foreach ($result as $item) {
            if (isset($item['time'])) {
                $totalLatency += (float)$item['time'];
                $validCount++;
            }
        }
        if ($validCount === 0) {
            throw new \Exception("Tidak ada data latency yang valid.");
        }

        return round($totalLatency / $validCount, 2);
    }
}
