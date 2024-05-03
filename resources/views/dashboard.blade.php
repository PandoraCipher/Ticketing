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

    </main>
@endsection
