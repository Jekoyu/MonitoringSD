<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Monitoring Jaringan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Monitoring Jaringan</a>
            <a href="{{ url('/logout') }}" class="btn btn-danger">Logout</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Dashboard Monitoring</h2>

        <!-- Notifikasi -->
        <div class="alert alert-info">
            <strong>Notifikasi:</strong>
            @foreach ($notifications as $notif)
                <p>{{ $notif->message }}</p>
            @endforeach
        </div>

        <!-- Status Perangkat -->
        <h4>Perangkat Terhubung</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Perangkat</th>
                    <th>IP Address</th>
                    <th>MAC Address</th>
                    <th>Tipe</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($devices as $device)
                <tr>
                    <td>{{ $device->name }}</td>
                    <td>{{ $device->ip_address }}</td>
                    <td>{{ $device->mac_address }}</td>
                    <td>{{ ucfirst($device->type) }}</td>
                    <td>
                        <span class="badge bg-{{ $device->status == 'online' ? 'success' : 'danger' }}">
                            {{ ucfirst($device->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Log Jaringan -->
        <h4>Log Aktivitas Jaringan</h4>
        <ul class="list-group">
            @foreach ($logs as $log)
                <li class="list-group-item">{{ $log->action }} - {{ $log->timestamp }}</li>
            @endforeach
        </ul>

    </div>

</body>
</html>
