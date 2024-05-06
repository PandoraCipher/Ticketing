@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
        </div>

        <div class="d-flex">
            <a class="p-2 m-1 flex-grow-1 dashboard-card" href="{{ route('tickets.list', ['status' => 'Open']) }}">
                <div class="btn">
                    <div class="dashboard-text1">Open tickets</div>
                    <div class="dashboard-text2">{{ $openTicketsCount }}</div>
                </div>
            </a>
            <a class="p-2 m-1 flex-grow-1 dashboard-card" href="{{ route('tickets.list', ['status' => 'Pending']) }}">
                <div class="btn">
                    <div class="dashboard-text1">Pending tickets</div>
                    <div class="dashboard-text2">{{ $pendingTicketsCount }}</div>
                </div>
            </a>
        </div>

        <label class="mt-5" for=""><b><h5>Today's tickets:</h4></b></label>
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
                            @if (
                                $ticket->name == Auth::user()->name ||
                                    $ticket->assigned == Auth::user()->name ||
                                    $ticket->client == Auth::user()->name)
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
