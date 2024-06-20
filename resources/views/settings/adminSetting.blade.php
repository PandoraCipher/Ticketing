@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Settings</h1>
        </div>
        <div>
            <h3 class="h3">Status list</h3>
            <div class="table-responsive small">
                <table class="table table-hover rounded table-sm">
                    <thead>
                        <tr>
                            <th class="bg-secondary text-white" scope="col">Name</th>
                            <th class="bg-secondary text-white" scope="col">Abreviation</th>
                            <th class="bg-secondary text-white text-center" scope="col">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Open</td>
                            <td>Open</td>
                            <td class="text-center">no action</td>
                        </tr>
                        <tr>
                            <td>Closed</td>
                            <td>Closed</td>
                            <td class="text-center">no action</td>
                        </tr>
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
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary p-1" data-bs-toggle="modal"
                    data-bs-target="#createStatusModal">
                    add
                    <svg class="bi">
                        <use xlink:href="#plus-circle" />
                    </svg>
                </button>
            </div>
        </div>
        &nbsp;
        &nbsp;
        <div>
            <h3 class="h3">Category list</h3>
            <div class="table-responsive small">
                <table class="table table-hover rounded table-sm">
                    <thead>
                        <tr>
                            <th class="bg-secondary text-white">name</th>
                            <th class="bg-secondary text-white">Resolution Time(min)</th>
                            <th class="text-center bg-secondary text-white">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->stdResolutionTime }}</td>
                                <td class="text-center">
                                    <button type="button" class="badge bg-danger p-1" data-bs-toggle="modal"
                                        data-bs-target="#deleteCategoryModal{{ $category->id }}">
                                        <svg class="bi">
                                            <use xlink:href="#icon-trash" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">no category found</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td>other</td>
                            <td>0</td>
                            <td class="text-center">no action</td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary p-1" data-bs-toggle="modal"
                    data-bs-target="#createCategoryModal">
                    add
                    <svg class="bi">
                        <use xlink:href="#plus-circle" />
                    </svg>
                </button>
            </div>
        </div>

        @foreach ($statuses as $status)
            @include('settings.modals.deleteStatusModal', ['statusId' => $status->id])
        @endforeach
        @include('settings.modals.createStatusModal')
        @foreach ($categories as $category)
            @include('settings.modals.deleteCategoryModal', ['categoryId' => $category->id])
        @endforeach
        @include('settings.modals.createCategoryModal')
    </main>
@endsection
