<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BandwidthUsage extends Model
{
    use HasFactory;

    protected $table = "bandwidth_usage";
    protected $fillable = ['device_id', 'download', 'upload', 'timestamp'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
