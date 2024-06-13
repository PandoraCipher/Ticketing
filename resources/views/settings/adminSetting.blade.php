@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Settings</h1>
        </div>
        <div>
            <h3 class="h3">Status list</h3>
            <div class="table-responsive small">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Abreviation</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Awaiting customer reply</td>
                            <td>ACR</td>
                            <td>delete</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div>
            <h3 class="h3">Category list</h3>
        </div>

    </main>
@endsection
