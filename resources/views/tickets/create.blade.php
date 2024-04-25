@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="form-box">
            <form class="form" method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
                @csrf
                <span class="title">New ticket</span>
                <label class="text-start" for="name">Name:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" name="name" placeholder="Name" value=" {{ Auth::user()->name }} " required>
                </div>
                <label class="text-start" for="assigned">To:</label>
                <div class="form-container m-0 p-0">
                    <select name="assigned" class="input" required>
                        @foreach ($users as $user)
                            @if ($user->role == "Admin")
                                <option value="{{ $user->name }}" {{ $ticket->assigned === $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <label class="text-start" for="subject">Subject:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" name="subject" placeholder="Subject" required>
                </div>
                {{-- <label class="text-start" for="description">Description:</label>
                <div class="form-container m-0 p-0">
                    <x-forms.tinymce-editor name="description" :content="html_entity_decode($ticket->description)" />
                    <textarea class="input" name="description" id="description" cols="30" rows="30"></textarea>
                </div> --}}
                <label class="text-start" for="note"><b>Note:</b></label>
                <div class="form-container m-0 p-0" style="height: 25vh">
                    <textarea class="input" style="height: 100vh" id="note" name="note" required></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="formFile" class="text-start">Attach file:</label>
                    <input type="file" class="form-control" id="formFile" name="file">
                </div>
                <label class="text-start" for="priority">Priority:</label>
                <div class="form-container m-0 p-0">
                    <select class="input" name="priority" required>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
    </main>
@endsection
