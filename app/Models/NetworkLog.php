<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkLog extends Model
{
    use HasFactory;

    protected $fillable = ['device_id', 'action', 'timestamp'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
