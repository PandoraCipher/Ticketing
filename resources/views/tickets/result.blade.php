    <tr>
        <td>{{ $ticket->id }}</td>
        <td>
            <span
                class="{{ $ticket->priority === 'Low' ? 'text-primary' : ($ticket->priority === 'Medium' ? 'text-warning' : 'text-danger') }}">
                {{ $ticket->priority }}
            </span>
        </td>
        <td>{{ $ticket->name }}</td>
        <td>{{ $ticket->client }}</td>
        <td>{{ $ticket->subject }}</td>
        <td>{{ $ticket->assigned }}</td>
        <td>
            <span
                class="rounded p-1 text-white
                @if ($ticket->status === 'Open') bg-danger
                @elseif ($ticket->status === 'Closed')
                    bg-success
                    @else
                    bg-warning @endif">
                @if ($ticket->status === 'Closed')
                    {{ 'Closed' }}
                @elseif ($ticket->status === 'Open')
                    {{ 'Open' }}
                @else
                    {{ 'Pending' }}
                @endif
            </span>
        </td>
        <td>{{ $ticket->updated_at->format('Y-m-d') }}</td>
        <td><a class="btn btn-primary" href="/tickets/{{ $ticket->id }}">check</a></td>
    </tr>
