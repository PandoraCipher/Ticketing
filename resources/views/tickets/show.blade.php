@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="form-box">
            <form class="form" method="POST" action="{{ route('tickets.update', $ticket) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <span class="title">Edit ticket</span>
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                <label class="text-start" for="name">Name:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" name="name" value="{{ old('name', $ticket->name) }}">
                </div>

                <label class="text-start" for="priority">Priority:</label>
                <div class="form-container m-0 p-0">
                    {{-- <input type="text" class="input" name="priority" value="{{ old('priority', $ticket->priority) }}"> --}}
                    <select class="input" name="priority" required>
                        <option value="Low" {{ $ticket->priority === 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ $ticket->priority === 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ $ticket->priority === 'High' ? 'selected' : '' }}>High</option>
                    </select>

                </div>

                <label class="text-start" for="subject">Subject:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" name="subject" value="{{ old('subject', $ticket->subject) }}">
                </div>

                <label class="text-start" for="assigned">To:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" name="assigned" value="{{ old('assigned', $ticket->assigned) }}">
                </div>

                <label class="text-start" for="status">Status:</label>
                <div class="form-container m-0 p-0">
                    {{-- <input type="text" class="input" name="status" value="{{ old('status', $ticket->status) }}"> --}}
                    <select name="status" id="status" class="input" value="{{ old('status', $ticket->status) }}">
                        <option value="Open" {{ $ticket->status === 'Open' ? 'selected' : '' }}>Open</option>
                        <option value="Closed" {{ $ticket->status === 'Closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <label class="text-start" for="description">Description:</label>
                <div class="form-container m-0 p-0">
                    <textarea class="input" id="descriptionid" name="description">{!! old('description', html_entity_decode($ticket->description ?? '')) !!}</textarea>
                </div>

                <div class="mb-3">
                    <label for="file" class="text-start">Attach file:</label>
                    @if ($ticket->file)
                        <p>{{ $ticket->file }}</p>
                        <a href="{{ route('tickets.download', ['filename' => $ticket->file]) }}" class="btn btn-primary">Télécharger le fichier</a>
                    @else
                        <p>No file attached</p>
                    @endif
                    <input type="file" class="form-control" id="formFile" name="file">
                </div>

                <button type="submit">Update</button>
            </form>
        </div>
    </main>
@endsection
