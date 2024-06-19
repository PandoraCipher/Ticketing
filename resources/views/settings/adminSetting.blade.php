@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Settings</h1>
        </div>
        <div>
            <h3 class="h3">Status list</h3>
            <div class="table-responsive small">
                <table class="table table-hover table-bordered rounded table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Abreviation</th>
                            <th class="text-center" scope="col">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($statuses as $status)
                            <tr>
                                <td>{{ $status->name }}</td>
                                <td>{{ $status->abreviation }}</td>
                                <td class="text-center">
                                    <button type="button" class="badge bg-danger p-1" data-bs-toggle="modal"
                                        data-bs-target="#deleteStatusModal{{ $status->id }}">
                                        <svg class="bi">
                                            <use xlink:href="#icon-trash" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">no status found</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="3">
                                <button type="button" class="btn btn-primary p-1" data-bs-toggle="modal"
                                    data-bs-target="#createStatusModal">
                                    add
                                    <svg class="bi">
                                        <use xlink:href="#plus-circle" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div>
            <h3 class="h3">Category list</h3>
            <div class="table-responsive small">
                <table class="table table-hover table-bordered rounded table-sm">
                    <thead>
                        <tr>
                            <th>name</th>
                            <th class="text-center">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>other</td>
                            <td class="text-center">
                                <button type="button" class="badge bg-danger p-1" data-bs-toggle="modal"
                                    data-bs-target="#deleteCategoryModal">
                                    <svg class="bi">
                                        <use xlink:href="#icon-trash" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="button" class="btn btn-primary p-1" data-bs-toggle="modal"
                                    data-bs-target="#createCategoryModal">
                                    add
                                    <svg class="bi">
                                        <use xlink:href="#plus-circle" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @foreach ($statuses as $status)
            @include('settings.modals.deleteStatusModal', ['statusId' => $status->id])
        @endforeach
        @include('settings.modals.createStatusModal')
    </main>
@endsection
