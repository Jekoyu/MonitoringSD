<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'ip_address', 'mac_address', 'type', 'status'];

    public function logs()
    {
        return $this->hasMany(NetworkLog::class);
    }

    public function bandwidth()
    {
        return $this->hasMany(BandwidthUsage::class);
    }
}
