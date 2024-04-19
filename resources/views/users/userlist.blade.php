@extends('layouts.main')

@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <h2>Users list</h2>
    <div class="d-flex">
        {{-- <select id="sortSelect" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
            <svg class="bi">
                <use xlink:href="#gear-wide-connected" />
            </svg>
            <option value="byID">by ID</option>
            <option value="byPriority">by priority</option>
            <option value="byAssignement">by assignement</option>
        </select> --}}

        <input class="rounded border border-dark mx-3" type="text" name="" id="">
        <button type="button" class="btn btn-sm btn-outline-secondary align-items-center gap-1">
            <svg class="bi">
                <use xlink:href="#search" />
            </svg>
        </button>
        <a class=" btn btn-sm mx-3 btn-outline-primary align-items-center gap-1" href="/users/usercreate">
            <svg class="bi">
                <use xlink:href="#plus-circle" />
            </svg>
            New user
        </a>
    </div>

    <div class="table-responsive small">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">name</th>
                    <th scope="col">email</th>
                    <th scope="col">role</th>
                    <th scope="col">action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        {{-- <td>{{ $ticket->description }}</td>
                        <td>{{ $ticket->assigned }}</td> --}}
                        @if (Auth::user()->role== 'Admin')
                        <td><a class="btn btn-primary" href="/users/{{ $user->id }}">modify</a></td>
                        @else
                            <td>no action</td>
                        @endif
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection