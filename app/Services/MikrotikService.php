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

        try {
            return $this->client->query($query)->read();
        } catch (Exception $e) {
            throw new Exception('Gagal mengambil data dari Mikrotik: ' . $e->getMessage());
        }
    }

    public function getInterfaces()
    {
        return $this->safeQuery(new Query('/interface/print'));
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
}
