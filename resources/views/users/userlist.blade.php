@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

        <h2>Users list</h2>
        <div class="d-flex table-responsive">
            <form action="" method="get">
                {{-- <input class="rounded border border-dark mx-1" type="text" name="name" placeholder="name" id=""
                    value="{{ request()->input('name') ?? '' }}">

                <select class="rounded border border-dark mx-3" name="department_id" id="department_id">
                    <option value="" disabled selected>Department</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}"
                            {{ $department->id === request()->input('department_id') ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select> --}}


                {{-- <button type="submit" class="btn btn-sm btn-outline-secondary align-items-center gap-1">
                    <svg class="bi">
                        <use xlink:href="#search" />
                    </svg>
                    search
                </button> --}}
                @if (Auth::user()->role == 'Admin')
                    <a class=" btn btn-sm btn-outline-primary align-items-center gap-1"
                        href="{{ route('users.usercreate') }}">
                        <svg class="bi">
                            <use xlink:href="#plus-circle" />
                        </svg>
                        New user
                    </a>
                @endif
            </form>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive small">
            <table id="usertable" class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">name</th>
                        <th scope="col">email</th>
                        <th scope="col">contact</th>
                        <th scope="col">Department</th>
                        <th scope="col">role</th>
                        <th scope="col">action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->contact }}</td>
                            <td>{{ $user->department ? $user->department->name : 'N/A' }}</td>
                            <td>{{ $user->role }}</td>
                            @if (Auth::user()->role == 'Admin')
                                <td class="d-flex">
                                    <button class="btn btn-primary p-1" data-bs-toggle="modal"
                                        data-bs-target="#modifyModal{{ $user->id }}">
                                        edit
                                        <svg class="bi">
                                            <use xlink:href="#edit-icon" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger p-1 ms-1" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $user->id }}">
                                            <svg class="bi">
                                                <use xlink:href="#icon-trash" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            @else
                                <td>no action</td>
                            @endif

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <!-- Affichage des liens de pagination -->
                        <div class="wpsc_ticket_list_nxt_pre_page">
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($users as $user)
            @include('users.modals.modify', ['userId' => $user->id])
            @include('users.modals.delete', ['userId' => $user->id])
        @endforeach
    </main>
    <script>
        $.extend(true, $.fn.dataTable.defaults, {
            columnDefs: [{
                targets: '_all',
                defaultContent: "" 
            }]
        });
        new DataTable('#usertable', {
            order: [
                [3, 'desc']
            ]
        });
    </script>
@endsection
