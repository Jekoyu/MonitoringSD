<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabel: interface_logs
        Schema::create('interface_logs', function (Blueprint $table) {
            $table->id();
            $table->string('interface_name');
            $table->unsignedBigInteger('rx_bytes');
            $table->unsignedBigInteger('tx_bytes');
            $table->unsignedBigInteger('rx_packets');
            $table->unsignedBigInteger('tx_packets');
            $table->boolean('status_running');
            $table->timestamps();
        });

        // Tabel: traffic_logs
        Schema::create('traffic_logs', function (Blueprint $table) {
            $table->id();
            $table->string('interface_name');
            $table->integer('rx_rate');
            $table->integer('tx_rate');
            $table->timestamps();
        });

        // Tabel: connected_devices
        Schema::create('connected_devices', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->string('mac_address');
            $table->string('hostname')->nullable();
            $table->string('interface')->nullable();
            $table->dateTime('lease_expiration')->nullable();
            $table->boolean('is_currently_connected');
            $table->timestamps();
        });

        // Tabel: system_resources
        Schema::create('system_resources', function (Blueprint $table) {
            $table->id();
            $table->integer('cpu_load');
            $table->unsignedBigInteger('memory_used');
            $table->unsignedBigInteger('memory_total');
            $table->string('uptime');
            $table->string('identity');
            $table->timestamps();
        });

        // Tabel: system_logs
        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();
            $table->string('time');
            $table->string('topic');
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_logs');
        Schema::dropIfExists('system_resources');
        Schema::dropIfExists('connected_devices');
        Schema::dropIfExists('traffic_logs');
        Schema::dropIfExists('interface_logs');
    }
};
