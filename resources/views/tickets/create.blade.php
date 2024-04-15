@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="form-box">
            <form class="form" method="POST">
                @csrf
                <span class="title">new ticket</span>
                {{-- <span class="subtitle">Create a free account with your email.</span> --}}
                <label class="text-start" for="client">Name:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" placeholder="Name">
                </div>
                <label class="text-start" for="assigned">To:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" placeholder="Assignement">
                </div>
                <label class="text-start" for="subject">Subject:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" placeholder="Subject">
                </div>
                <label class="text-start" for="description">Description:</label>
                <div class="form-container m-0 p-0">
                    {{-- @include('components.forms.tinymce-editor') --}}
                    <x-forms.tinymce-editor />
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Default file</label>
                    <input type="file" class="form-control" id="formFile">
                </div>
                <label class="text-start" for="priority">Priority:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" placeholder="Priority">
                </div>
                <button>Submit</button>
            </form>
        </div>
    </main>
@endsection
