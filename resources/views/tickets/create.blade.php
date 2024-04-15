@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="form-box">
            <form class="form" method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
                @csrf
                <span class="title">New ticket</span>
                <label class="text-start" for="name">Name:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" name="name" placeholder="Name" required>
                </div>
                <label class="text-start" for="assigned">To:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" name="assigned" placeholder="Assignment" required>
                </div>
                <label class="text-start" for="subject">Subject:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" name="subject" placeholder="Subject" required>
                </div>
                <label class="text-start" for="description">Description:</label>
                <div class="form-container m-0 p-0">
                    <x-forms.tinymce-editor name="description" />
                </div>
                <div class="mb-3">
                    <label for="formFile" class="text-start">Attach file:</label>
                    <input type="file" class="form-control" id="formFile" name="file">
                </div>
                <label class="text-start" for="priority">Priority:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" name="priority" placeholder="Priority" required>
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
    </main>
@endsection
