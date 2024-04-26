@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        {{-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Dashboard</h1>
      <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
          <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
          <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
          <svg class="bi"><use xlink:href="#calendar3"/></svg>
          This week
        </button>
      </div>
    </div>

    <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas> --}}

        <h2>Tickets list</h2>
        <div class="container d-flex gap-2">
            <form action="" method="get">
                <div class="container p-0">
                    <div class="container d-flex mx-0 my-1">
                        <input class="rounded border border-dark mx-1" type="number" name="id" placeholder="id"
                            id="" value="{{ $input['id'] ?? '' }}">
                        <input class="rounded border border-dark mx-1" type="text" name="client" placeholder="Client"
                            id="" value="{{ $input['client'] ?? '' }}">
                        <input class="rounded border border-dark mx-1" type="text" name="assigned" placeholder="assigned"
                            id="" value="{{ $input['assigned'] ?? '' }}">
                        <select name="status" class="rounded border border-dark mx-3" id="">
                            <option value="">Status</option>
                            <option value="Open" {{ session('status') == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="Closed" {{ session('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <label for=""><b>du:</b></label>
                        <input class="rounded border border-dark mx-1" type="date" name="begin" placeholder=""
                            id="" value="{{ $input['begin'] ?? '' }}">
                        <label for=""><b>au:</b></label>
                        <input class="rounded border border-dark mx-1" type="date" name="end" placeholder=""
                            id="" value="{{ $input['end'] ?? '' }}">
                    <a class=" btn btn-sm mx-3 btn-outline-primary align-items-center gap-1" href="/tickets/create">
                        <svg class="bi">
                            <use xlink:href="#plus-circle" />
                        </svg>
                        New ticket
                    </a>

                    <button type="submit" class="btn btn-sm btn-outline-secondary align-items-center gap-1">
                        <svg class="bi">
                            <use xlink:href="#search" />
                        </svg>
                    </button>
                    
                </div>

            </form>
            
        </div>

        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Priority</th>
                        <th scope="col">Name</th>
                        <th scope="col">Client</th>
                        <th scope="col">Subject</th>
                        {{-- <th scope="col">Description</th> --}}
                        <th scope="col">Assignement</th>
                        <th scope="col">Status</th>
                        <th scope="col">last update</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                        @if (Auth::user()->role == 'User')
                            @if ($ticket->name == Auth::user()->name)
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
                                            @if ($ticket->status !== 'Closed') bg-danger
                                            @else bg-success @endif
">
                                            @if ($ticket->status === 'Closed')
                                                {{ 'Closed' }}
                                            @else
                                                {{ 'Open' }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>{{ $ticket->updated_at->format('Y-m-d') }}</td>
                                    <td><a class="btn btn-primary" href="/tickets/{{ $ticket->id }}">check</a></td>
                                </tr>
                            @endif
                        @else
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
                                {{-- <td>{{ $ticket->description }}</td> --}}
                                <td>{{ $ticket->assigned }}</td>
                                <td>
                                    <span
                                        class="rounded p-1 text-white
                                        @if ($ticket->status !== 'Closed') bg-danger
                                        @else bg-success @endif
">
                                        @if ($ticket->status === 'Closed')
                                            {{ 'Closed' }}
                                        @else
                                            {{ 'Open' }}
                                        @endif
                                    </span>
                                </td>
                                <td>{{ $ticket->updated_at->format('Y-m-d') }}</td>
                                <td><a class="btn btn-primary" href="/tickets/{{ $ticket->id }}">check</a></td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td><b>No ticket found</b></h3></label></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <!-- Affichage des liens de pagination -->
                        <div class="wpsc_ticket_list_nxt_pre_page">
                            {{ $tickets->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

@endsection
