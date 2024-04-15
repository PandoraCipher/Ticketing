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
                    <input type="text" class="input" name="priority" value="{{ old('priority', $ticket->priority) }}">
                </div>

                <label class="text-start" for="assigned">To:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" name="assigned" value="{{ old('assigned', $ticket->assigned) }}">
                </div>

                <label class="text-start" for="status">Status:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" name="status" value="{{ old('status', $ticket->status) }}">
                </div>

                <label class="text-start" for="description">Description:</label>
                <div class="form-container m-0 p-0">
                    <x-forms.tinymce-editor name="description" :content="$ticket->description" />
                </div>

                <div class="mb-3">
                    <label for="file" class="text-start">Attach file:</label>
                    <input type="file" class="form-control" id="formFile" name="file">
                </div>

                <button type="submit">Update</button>
            </form>
        </div>
    </main>
@endsection
