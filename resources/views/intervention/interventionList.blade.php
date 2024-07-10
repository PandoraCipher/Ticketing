@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h2>Operation list</h2>
        <div class="container d-flex gap-2">
        </div>
        <div class="table-responsive small" style="border-top: 1px solid grey; margin-top: 5px">
            <table id="example" class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        {{-- <th class="bg-secondary" scope="col">#id</th> --}}
                        <th class="text-center bg-info" scope="col">Category</th>
                        <th class="text-center bg-danger" scope="col">Incident start</th>
                        <th class="text-center bg-success" scope="col">Operation start</th>
                        <th class="text-center bg-info" scope="col">Operation end</th>
                        <th class="text-center bg-secondary" scope="col">Operation duration</th>
                        <th class="text-center bg-primary" scope="col">Restored date</th>
                        <th class="text-center bg-success wrap-content" scope="col">Downtime Resolution</th>
                        <th class="text-center bg-danger" scope="col">Ticket</th>
                        <th class="text-center bg-warning" scope="col">KPI(%)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($interventions as $intervention)
                        <tr>
                            <td>{{ $intervention->category->name }}</td>
                            <td>{{ $intervention->start_incident }}</td>
                            <td>{{ $intervention->start_interv }}</td>
                            <td>{{ $intervention->end_interv }}</td>
                            <td>{{ floor($intervention->intervention_duration / 60) }}h{{ str_pad($intervention->intervention_duration % 60, 2, '0', STR_PAD_LEFT) }}m
                            </td>
                            <td>{{ $intervention->restore_date }}</td>
                            <td>{{ floor($intervention->downtime_resolution / 60) }}h{{ str_pad($intervention->intervention_duration % 60, 2, '0', STR_PAD_LEFT) }}m
                            </td>
                            <td><a class=" badge btn btn-primary"
                                    href="/tickets/{{ $intervention->ticket->id }}">{{ $intervention->ticket->id }}</a>
                            </td>
                            <td>{{ $intervention->kpi_intervention }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td><b>No intervention found</b></h3></label></td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <!-- Affichage des liens de pagination -->
                        {{-- <div class="wpsc_ticket_list_nxt_pre_page">
                            {{ $interventions->appends(request()->query())->links() }}
                        </div> --}}
                    </div>
                </div>
            </div>

        </div>
    </main>
    <script>
        $.extend(true, $.fn.dataTable.defaults, {
            columnDefs: [{
                targets: '_all',
                defaultContent: ""
            }]
        });
        new DataTable('#example', {
            order: [
                [3, 'desc']
            ]
        });
    </script>
@endsection
