<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, Helvetica, sans-serif; background: #f4f4f4; padding: 20px; color: #222; }
        .card { background: #fff; border-radius: 8px; padding: 24px; max-width: 560px; margin: 0 auto; box-shadow: 0 1px 4px rgba(0,0,0,.1); }
        h2 { margin-top: 0; }
        .down { color: #b91c1c; }
        .up { color: #15803d; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        td { padding: 8px 10px; border-bottom: 1px solid #eee; font-size: 14px; }
        td.label { font-weight: 700; width: 140px; color: #555; }
        .footer { margin-top: 16px; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="card">
        @if (($data['event'] ?? '') === 'license_server_down')
            <h2 class="down">🔒 Server LOCKED — Application Taken Down</h2>
        @else
            <h2 class="up">🔓 Server UNLOCKED — Application Back Up</h2>
        @endif
        <p>The license control system changed the state of <strong>{{ $data['app'] ?? 'Unknown App' }}</strong>.</p>
        <table>
            <tr>
                <td class="label">State</td>
                <td>{{ ucfirst($data['state'] ?? '—') }}</td>
            </tr>
            <tr>
                <td class="label">Triggered From IP</td>
                <td>{{ $data['ip'] ?? '—' }}</td>
            </tr>
            <tr>
                <td class="label">Request URL</td>
                <td>{{ $data['url'] ?? '—' }}</td>
            </tr>
            <tr>
                <td class="label">Time</td>
                <td>{{ $data['time'] ?? '—' }}</td>
            </tr>
        </table>
        <div class="footer">This is an automated alert from the license control system.</div>
    </div>
</body>
</html>
