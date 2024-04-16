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
        <div class="d-flex">
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
                <svg class="bi">
                    <use xlink:href="#gear-wide-connected" />
                </svg>
                Filter
            </button>
            <input class="rounded border border-dark mx-3" type="text" name="" id="">
            <button type="button" class="btn btn-sm btn-outline-secondary align-items-center gap-1">
                <svg class="bi">
                    <use xlink:href="#search" />
                </svg>
            </button>
            <a class=" btn btn-sm mx-3 btn-outline-primary align-items-center gap-1" href="/tickets/create">
                <svg class="bi">
                    <use xlink:href="#plus-circle" />
                </svg>
                New ticket
              </a>
        </div>

        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Priority</th>
                        <th scope="col">Client</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Description</th>
                        <th scope="col">Assignement</th>
                        <th scope="col">Status</th>
                        <th scope="col">last update</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->priority }}</td>
                            <td>{{ $ticket->name }}</td>
                            <td>{{ $ticket->subject }}</td>
                            <td>{{ $ticket->description }}</td>
                            <td>{{ $ticket->assigned }}</td>
                            <td>{{ $ticket->status }}</td>
                            <td>{{ $ticket->updated_at->format('Y-m-d') }}</td>
                            <td><a class="btn btn-primary" href="/tickets/{{ $ticket->id }}">Update</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection
