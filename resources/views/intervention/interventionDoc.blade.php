<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket Details</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { margin-bottom: 40px; }
        label { display: block; margin-top: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Ticket #{{ $ticket->id }} - {{ $ticket->subject }}</h2>
    <p><strong>Author:</strong> {{ $ticket->name }}</p>
    <p><strong>Incident Start Date:</strong> {{ $intervention->start_incident }}</p>
    <p><strong>Client:</strong> {{ $ticket->client }}</p>
    {{-- <p><strong>Contact:</strong> {{ $user->contact ?? 'N/A' }}</p> --}}
    <p><strong>Category:</strong> {{ $ticket->category }}</p>
    <p><strong>Subject:</strong> {{ $ticket->subject }}</p>

    <h3>Notes</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Status</th>
                <th>By</th>
                <th>Description</th>
                <th>File</th>
                <th>Assigned</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notes as $note)
                <tr>
                    <td>{{ $note->updated_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $note->status }}</td>
                    <td>{{ $note->author }}</td>
                    <td>{{ $note->content }}</td>
                    <td>{{ $note->file ? '<a href="' . route('tickets.download', ['filename' => $note->file]) . '" class="btn btn-primary">Download File</a>' : 'No file attached' }}</td>
                    <td>{{ $note->assigned }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>