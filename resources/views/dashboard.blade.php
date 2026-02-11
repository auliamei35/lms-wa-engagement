<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">WhatsApp Monitoring Log</h1>
        
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="p-4">ID</th>
                        <th class="p-4">Recipient (Masked)</th>
                        <th class="p-4">Type</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">{{ $log->id }}</td>
                        <td class="p-4 font-mono">{{ $log->recipient_phone }}</td>
                        <td class="p-4">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                                {{ $log->message_type }}
                            </span>
                        </td>
                        <td class="p-4">
                            @if($log->status == 'success')
                                <span class="text-green-600 font-bold uppercase text-sm">● Success</span>
                            @elseif($log->status == 'failed')
                                <span class="text-red-600 font-bold uppercase text-sm">● Failed</span>
                            @else
                                <span class="text-yellow-600 font-bold uppercase text-sm">● {{ $log->status }}</span>
                            @endif
                        </td>
                        <td class="p-4 text-gray-500 text-sm italic">{{ $log->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4 text-sm text-gray-500 text-right">
            Auto-refresh tidak aktif. Segarkan halaman untuk data terbaru.
        </div>
    </div>
</body>
</html>