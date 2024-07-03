@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 row">
        <div class="update-form-box table-responsive col-5">
            <form class="form" method="POST" action="{{ route('tickets.update', $ticket) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <span class="title">Edit ticket</span>
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                <label for="reference" class="text-start">
                    <h3>[ticket #{{ $ticket->id }}] {{ $ticket->subject }}</h2>
                </label>

                <div class="container d-flex column p-0">
                    <div class="container d-flex p-0">
                        <label class="text-start" for="name"><b>Author:&nbsp;</b></label>
                        <label for="name">{{ $ticket->name }}</label>
                    </div>
                    @if (Auth::user()->role == 'Admin')
                        <div class="container d-flex p-0">
                            <label class="text-start" for="intervention"><b>operation:&nbsp;</b></label>
                            @if ($ticket->intervention_id != null)
                                <a href="#" class="badge btn btn-primary"
                                    for="intervention">{{ $ticket->intervention_id }}</a>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="container d-flex column p-0">
                    <div class="container d-flex p-0">
                        <label class="text-start" for="client"><b>Client:&nbsp;</b></label>
                        <label for="client">{{ $ticket->client }}</label>
                    </div>
                    <div class="container d-flex p-0">
                        <label class="text-start" for="contact"><b>Contact:&nbsp;</b></label>
                        @foreach ($users as $user)
                            @if ($user->name == $ticket->client)
                                <label for="contact">{{ $user->contact }}</label>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="container d-flex p-0">
                    <label class="text-start" for="category"><b>Category:&nbsp;</b></label>
                    <label for="client">{{ $ticket->category }}</label>
                </div>
                @if ($ticket->status != 'Closed')

                    @if (Auth::user()->role == 'Admin')
                        @include('tickets.operationDetails.adminDetail')
                    @else
                        @include('tickets.operationDetails.userDetail')
                    @endif

                
                    <div class="container d-flex column p-0">
                        <label class="text-start" for="priority"><b>Priority:</b></label>
                        <div class="form-container m-0 p-0 col-3 mx-1">
                            <select class="input text-dark" name="priority" required>
                                <option value="Low" {{ $ticket->priority === 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ $ticket->priority === 'Medium' ? 'selected' : '' }}>Medium
                                </option>
                                <option value="High" {{ $ticket->priority === 'High' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                        @if (Auth::user()->role == 'Admin')
                            <label class="text-start" for="status"><b>Status:</b></label>
                            <div class="form-container m-0 p-0 col-5 mx-2">
                                <select name="status" id="status" class="input text-dark"
                                    value="{{ old('status', $ticket->status) }}">
                                    @foreach ($statuses as $status)
                                        <option value="ACR"
                                            {{ $ticket->status === $status->abreviation ? 'selected' : '' }}>
                                            {{ $status->name }}</option>
                                    @endforeach
                                    <option value="Closed" {{ $ticket->status === 'Closed' ? 'selected' : '' }}>Closed
                                    </option>

                                </select>
                            </div>
                        @else
                            <label class="text-start" for="status"><b>Status:</b></label>
                            <div class="form-container m-0 p-0 col-5 mx-2">
                                <select name="status" id="status" class="input text-dark"
                                    value="{{ old('status', $ticket->status) }}">
                                    @foreach ($statuses as $status)
                                        <option value="ACR"
                                            {{ $ticket->status === $status->abreviation ? 'selected' : '' }}>
                                            {{ $status->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        @endif
                    </div>

                    <label class="text-start" for="subject"><b>Subject:</b></label>
                    <div class="form-container m-0 p-0">
                        <input type="text" class="input text-dark" name="subject"
                            value="{{ old('subject', $ticket->subject) }}">
                    </div>

                    <label class="text-start" for="assigned"><b>Assign to:</b></label>
                    <div class="form-container m-0 p-0">
                        @if (Auth::user()->role == 'User')
                            <select name="assigned" class="input text-dark" required>
                                @foreach ($users as $user)
                                    @if ($user->role == 'Admin')
                                        <option value="{{ $user->name }}"
                                            {{ $ticket->assigned === $user->name ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endif
                                @endforeach
                                {{-- <option value="{{ $ticket->client }}"
                                {{ $ticket->assigned === $ticket->client ? 'selected' : '' }}>{{ $ticket->client }}
                            </option> --}}
                            </select>
                        @else
                            <select name="assigned" class="input text-dark" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->name }}"
                                        {{ $ticket->assigned === $user->name ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endif

                    </div>

                    <label class="text-start" for="note"><b>Note:</b></label>
                    <div class="form-container m-0 p-0" style="height: 25vh">
                        <textarea class="input text-dark" style="height: 100vh" id="note" name="note" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="text-start"><b>Attach file:</b></label>
                        <input type="file" class="form-control" id="formFile" name="file">
                    </div>

                    <button class="w-25" type="submit">Update</button>
                @endif
            </form>
        </div>

        <div class="update-form-box col-6 mx-2 table-responsive rounded small">
            @if (session('error'))
                <div class="alert alert-success">
                    {{ session('error') }}
                </div>
            @endif
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
                            <td class=""><i>{{ $note->updated_at->format('Y-m-d H:i') }}</i></td>
                            <td><span
                                    class="{{ $note->status === 'Open' ? 'badge p-1 text-white bg-danger' : ($note->status === 'Closed' ? 'rounded p-1 text-white bg-success' : 'rounded p-1 text-white bg-warning') }}">
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
            <div class="btn-toolbar mb-2 mb-md-0">
                {{-- <div class="btn-group ms-auto mb-1">
                    <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                </div> --}}
            </div>
        </div>
    </main>
@endsection
