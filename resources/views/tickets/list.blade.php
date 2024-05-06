@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h2>Tickets list</h2>
        <div class="container d-flex gap-2">
            <div class="table-responsive">
                <form action="" method="get">
                    <div class="container p-0">
                        <div class="container d-flex mx-0 my-1">
                            <input class="rounded border border-dark mx-1" type="number" name="id" placeholder="id"
                                id="" value="{{ $input['id'] ?? '' }}" min="1">
                            <input class="rounded border border-dark mx-1" type="text" name="client"
                                placeholder="Client" id="" value="{{ $input['client'] ?? '' }}">
                            <input class="rounded border border-dark mx-1" type="text" name="assigned"
                                placeholder="assigned" id="" value="{{ $input['assigned'] ?? '' }}">
                            <select name="status" class="rounded border border-dark mx-3" id="">
                                <option class="placeholder-text" value="">priority</option>
                                <option value="Pending"
                                    {{ isset($input['status']) && $input['status'] == 'Pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="Open"
                                    {{ isset($input['status']) && $input['status'] == 'Open' ? 'selected' : '' }}>Open
                                </option>
                                <option value="Closed"
                                    {{ isset($input['status']) && $input['status'] == 'Closed' ? 'selected' : '' }}>Closed
                                </option>
                            </select>
                        </div>
                        <div class="container d-flex my-1">
                            <label for=""><b>from:</b></label>
                            <input class="rounded border border-dark mx-1" type="date" name="begin" placeholder=""
                                id="" value="{{ old('begin') ?? ($input['begin'] ?? '') }}">
                            <label for=""><b>to:</b></label>
                            <input class="rounded border border-dark mx-1" type="date" name="end" placeholder=""
                                id="" value="{{ old('end') ?? ($input['end'] ?? '') }}">
                            <label for=""><b>last update:</b></label>
                            <input class="rounded border border-dark mx-1" type="date" name="update" placeholder=""
                                id="" value="{{ old('update') ?? ($input['update'] ?? '') }}">
                        </div>
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
                            search
                        </button>

                    </div>

                </form>
            </div>
        </div>

        <div class="table-responsive small" style="border-top: 1px solid grey; margin-top: 5px">
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
                            @if ($ticket->name == Auth::user()->name || $ticket->assigned == Auth::user()->name || $ticket->client == Auth::user()->name)
                                @include('tickets.result')
                            @endif
                        @else
                            @include('tickets.result')
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
                            {{ $tickets->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

@endsection
