@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="form-box">
            <form class="form" method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <span class="title">New ticket</span>
                {{-- <label class="text-start" for="name">Author:</label> --}}
                <div class="form-container m-0 p-0">
                    <input type="hidden" class="input text-dark" name="name" placeholder="Name"
                        value=" {{ Auth::user()->name }} " required>
                </div>

                <label class="text-start" for="incident_start">Incident start(if incident):</label>
                <div class="form-container m-0 p-0">
                    <input type="datetime-local" class="input text-dark" name="start_incident" id="datetime"
                        value="">
                </div>

                @if (Auth::user()->role == 'Admin')
                    <label class="text-start" for="Client">Client id:</label>
                    <div class="form-container m-0 p-0">
                        <input class="input text-dark" list="users" name="client" id="client">
                        <datalist id="users">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}/{{ $user->department->name ?? '' }}</option>
                            @endforeach
                        </datalist>
                    </div>
                @else
                    <input type="hidden" name="client" value="{{ Auth::user()->id }}" required>
                @endif

                <label class="text-start" for="assigned">Assign to:</label>
                <div class="form-container m-0 p-0">
                    <select name="assigned" class="input text-dark" required>
                        @foreach ($users as $user)
                            @if ($user->role == 'Admin')
                                <option value="{{ $user->id }}" {{ $ticket->assigned === $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endif
                        @endforeach
                        {{-- <option value="Support Enterprise" class="text-dark">Support Enterprise</option>
                        <option value="Tovo RAJONSON" class="text-dark">Tovo RAJONSON</option>
                        <option value="ELIE RAKOTONDRANIVO" class="text-dark">ELIE RAKOTONDRANIVO</option> --}}
                    </select>
                </div>

                <label class="text-start" for="assigned">Category:</label>
                <div class="form-container m-0 p-0">
                    <select class="input text-dark" name="category" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <label class="text-start" for="subject">Subject:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input text-dark" name="subject" placeholder="Subject" required>
                </div>

                <label class="text-start" for="note"><b>Note:</b></label>
                <div class="form-container m-0 p-0" style="height: 25vh">
                    <textarea class="input text-dark" style="height: 100vh" id="note" name="note" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="formFile" class="text-start">Attach file:</label>
                    <input type="file" class="form-control" id="formFile" name="file">
                </div>

                <label class="text-start" for="priority">Priority:</label>
                <div class="form-container m-0 p-0">
                    <select class="input text-dark" name="priority" required>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
    </main>

    <script>

        // document.addEventListener('DOMContentLoaded', function() {
        //     var dateTimeInput = document.getElementById('datetime');
        //     var dateElement = document.createElement('span');
        //     var timeElement = document.createElement('span');

        //     dateTimeInput.addEventListener('change', function() {
        //         var dateTime = this.value.split('T');
        //         dateElement.textContent = dateTime[0]; // Format YYYY-MM-DD
        //         timeElement.textContent = dateTime[1].substring(0, 5); // Format HH:mm
        //     });

        //     dateElement.style.display = 'inline-block';
        //     timeElement.style.display = 'inline-block';

        //     // Afficher les éléments à côté du champ input
        //     dateTimeInput.parentNode.insertBefore(dateElement, dateTimeInput.nextSibling);
        //     dateTimeInput.parentNode.insertBefore(timeElement, dateTimeInput.nextSibling);
        // });
    </script>

@endsection
