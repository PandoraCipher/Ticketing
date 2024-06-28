@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h2>Intervention list</h2>
        <div class="container d-flex gap-2">
            <div class="table-responsive">
                <form action="" method="get">
                    <div class="container p-0">
                        <div class="container d-flex mx-0 my-1">
                            <input class="rounded border border-dark mx-1" type="number" name="id" placeholder="id"
                                id="" value="{{ $input['id'] ?? '' }}" min="1">
                            <input class="rounded border border-dark mx-1" type="text" name="client"
                                placeholder="Client" id="" value="{{ $input['client'] ?? '' }}">
                            <select name="category" id="category" class="rounded border border-dark mx-3">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            {{-- <select name="status" class="rounded border border-dark mx-3" id="">
                                <option class="placeholder-text" value="">status</option>
                                <option value="Pending"
                                    {{ isset($input['status']) && $input['status'] == 'Pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="Open"
                                    {{ isset($input['status']) && $input['status'] == 'Open' ? 'selected' : '' }}>Open
                                </option>
                                <option value="Closed"
                                    {{ isset($input['status']) && $input['status'] == 'Closed' ? 'selected' : '' }}>Closed
                                </option>
                            </select> --}}
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
            <table class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        {{--<th class="bg-secondary" scope="col">#id</th>--}}
                        <th class="bg-danger" scope="col">Incident start</th>
                        <th class="bg-success" scope="col">Intervention start</th>
                        <th class="bg-info" scope="col">Intervention end</th>
                        <th class="bg-primary" scope="col">Restored date</th>
                        <th class="bg-success" scope="col">Downtime Resolution</th>
                        <th class="bg-secondary" scope="col">Intervention duration</th>
                        <th class="bg-info" scope="col">Category</th>
                        <th class="bg-danger" scope="col">Ticket</th>
                        <th class="bg-warning" scope="col">KPI</th>
                    </tr>
                </thead>
                <tbody>
                    {{--@forelse ($tickets as $ticket)
                        
                    @empty
                        <tr>
                            <td><b>No intervention found</b></h3></label></td>
                        </tr>
                    @endforelse--}}
                    <tr>
                        <td>hello</td>
                        <td>hello</td>
                        <td>hello</td>
                        <td>hello</td>
                        <td>Hello</td>
                        <td>hello</td>
                        <td>hello</td>
                        <td>hello</td>
                        <td>hello</td>
                    </tr>
                </tbody>
            </table>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <!-- Affichage des liens de pagination -->
                        {{--<div class="wpsc_ticket_list_nxt_pre_page">
                            {{ $interventions->appends(request()->query())->links() }}
                        </div>--}}
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
