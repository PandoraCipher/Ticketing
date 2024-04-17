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
            <select id="sortSelect" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
                <svg class="bi">
                    <use xlink:href="#gear-wide-connected" />
                </svg>
                <option value="byID">by ID</option>
                <option value="byPriority">by priority</option>
                <option value="byAssignement">by assignement</option>
            </select>

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
                            <td>
                                <span
                                    class="{{ $ticket->priority === 'Low' ? 'text-primary' : ($ticket->priority === 'Medium' ? 'text-warning' : 'text-danger') }}">
                                    {{ $ticket->priority }}
                                </span>
                            </td>
                            <td>{{ $ticket->name }}</td>
                            <td>{{ $ticket->subject }}</td>
                            <td>{{ $ticket->description }}</td>
                            <td>{{ $ticket->assigned }}</td>
                            <td>
                                <span
                                    class="{{ $ticket->status === 'Open' ? 'rounded p-1 text-white bg-danger' : 'rounded p-1 text-white bg-success' }}">
                                    {{ $ticket->status }}
                                </span>
                            </td>
                            <td>{{ $ticket->updated_at->format('Y-m-d') }}</td>
                            <td><a class="btn btn-primary" href="/tickets/{{ $ticket->id }}">Update</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
    {{-- <script>
        document.getElementById('sortSelect').addEventListener('change', function() {
            var selectedValue = this.value;
            var rows = document.querySelectorAll('table tbody tr');

            // Fonction de tri personnalisée
            function customSortByProperty(property) {
                return function(a, b) {
                    var valueA = a.querySelector('.' + property).innerText;
                    var valueB = b.querySelector('.' + property).innerText;
                    return valueA.localeCompare(valueB);
                };
            }

            // Tri des lignes de tableau en fonction de l'option sélectionnée
            if (selectedValue === 'byID') {
                rows.forEach(function(row) {
                    row.remove(); // Supprimer les lignes existantes
                });
                // Ré-ajouter les lignes triées par ID
                rows.forEach(function(row) {
                    document.querySelector('table tbody').appendChild(row);
                });
            } else if (selectedValue === 'byPriority') {
                // Tri par priorité
                var sortedRows = Array.from(rows).sort(customSortByProperty('priority'));
                rows.forEach(function(row) {
                    row.remove(); // Supprimer les lignes existantes
                });
                // Ré-ajouter les lignes triées par priorité
                sortedRows.forEach(function(row) {
                    document.querySelector('table tbody').appendChild(row);
                });
            } else if (selectedValue === 'byAssignement') {
                // Tri par assignement
                var sortedRows = Array.from(rows).sort(customSortByProperty('assignement'));
                rows.forEach(function(row) {
                    row.remove(); // Supprimer les lignes existantes
                });
                // Ré-ajouter les lignes triées par assignement
                sortedRows.forEach(function(row) {
                    document.querySelector('table tbody').appendChild(row);
                });
            }
        });
    </script> --}}
@endsection
