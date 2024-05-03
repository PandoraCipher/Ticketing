@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 row">
        <div class="form-box col-5">
            <form class="form" method="POST" action="{{ route('tickets.update', $ticket) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <span class="title">Edit ticket</span>
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                <label for="reference" class="text-start">
                    <h3>[ticket #{{ $ticket->id }}] {{ $ticket->subject }}</h2>
                </label>

                <div class="container d-flex p-0">
                    <label class="text-start" for="name"><b>Name:&nbsp;</b></label>
                    <label for="name">{{ $ticket->name }}</label>
                </div>

                <div class="container d-flex p-0">
                    <label class="text-start" for="client"><b>Client:&nbsp;</b></label>
                    <label for="client">{{ $ticket->client }}</label>
                </div>
                <div class="container d-flex p-0">
                    <label class="text-start" for="category"><b>Category:&nbsp;</b></label>
                    <label for="client">{{ $ticket->category }}</label>
                </div>

                <div class="container d-flex column p-0">
                    <label class="text-start" for="priority"><b>Priority:</b></label>
                    <div class="form-container m-0 p-0 col-3 mx-1">
                        <select class="input " name="priority" required>
                            <option value="Low" {{ $ticket->priority === 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ $ticket->priority === 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ $ticket->priority === 'High' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                    @if (Auth::user()->role == 'Admin')
                        <label class="text-start" for="status"><b>Status:</b></label>
                        <div class="form-container m-0 p-0 col-5 mx-2">
                            <select name="status" id="status" class="input"
                                value="{{ old('status', $ticket->status) }}">
                                <option value="Open" {{ $ticket->status === 'Open' ? 'selected' : '' }}>Open</option>
                                <option value="Closed" {{ $ticket->status === 'Closed' ? 'selected' : '' }}>Closed</option>

                                <option value="ACR" {{ $ticket->status === 'ACR' ? 'selected' : '' }}>Awaiting customer
                                    reply</option>
                                <option value="AAR" {{ $ticket->status === 'AAR' ? 'selected' : '' }}>Awaiting agent
                                    reply
                                </option>

                            </select>
                        </div>
                    @else
                        <label class="text-start" for="status"><b>Status:</b></label>
                        <div class="form-container m-0 p-0 col-5 mx-2">
                            <select name="status" id="status" class="input"
                                value="{{ old('status', $ticket->status) }}">
                                <option value="ACR" {{ $ticket->status === 'ACR' ? 'selected' : '' }}>Awaiting customer
                                    reply</option>
                                <option value="AAR" {{ $ticket->status === 'AAR' ? 'selected' : '' }}>Awaiting agent
                                    reply
                                </option>

                            </select>
                        </div>
                    @endif
                </div>

                <label class="text-start" for="subject"><b>Subject:</b></label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" name="subject" value="{{ old('subject', $ticket->subject) }}">
                </div>

                <label class="text-start" for="assigned"><b>To:</b></label>
                <div class="form-container m-0 p-0">
                    <select name="assigned" class="input" required>
                        @foreach ($users as $user)
                            @if ($user->role == 'Admin')
                                <option value="{{ $user->name }}"
                                    {{ $ticket->assigned === $user->name ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <label class="text-start" for="note"><b>Note:</b></label>
                <div class="form-container m-0 p-0" style="height: 25vh">
                    <textarea class="input" style="height: 100vh" id="note" name="note" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="file" class="text-start">Attach file:</label>
                    @if ($ticket->file)
                        <p>{{ $ticket->file }}</p>
                        <a href="{{ route('tickets.download', ['filename' => urlencode($ticket->file)]) }}"
                            class="btn btn-primary">
                            Télécharger le fichier
                        </a>
                    @else
                        <p>No file attached</p>
                    @endif
                    <input type="file" class="form-control" id="formFile" name="file">
                </div>

                <button type="submit">Update</button>
            </form>
        </div>
        <div class="form-box col-6 mx-2 table-responsive small">
            <table class="table table-striped table-sm my-2">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">status</th>
                        <th scope="col">by</th>
                        <th scope="col" class="col-4">description</th>
                        <th scope="col">file</th>
                        <th scope="col" class="col-2">assigned</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notes as $note)
                        <tr>
                            <td>{{ $note->updated_at->format('Y-m-d H:i') }}</td>
                            <td><span
                                    class="{{ $note->status === 'Open' ? 'rounded p-1 text-white bg-danger' : ($note->status === 'Closed' ? 'rounded p-1 text-white bg-success' : 'rounded p-1 text-white bg-warning') }}">
                                    {{ $note->status }}
                                </span></td>
                            <td>{{ $note->author }}</td>
                            <td>{{ $note->content }}</td>
                            <td>
                                @if ($note->file)
                                    <a href="{{ route('tickets.download', ['filename' => $note->file]) }}"
                                        class="btn btn-primary">
                                        download file
                                    </a>
                                @else
                                    No file attached
                                @endif
                            </td>
                            <td>{{ $note->assigned }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection
