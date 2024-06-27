@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="form-box">
            <form class="form" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                @csrf
                <span class="title">New user</span>
                <label class="text-start" for="name">Name:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input text-dark" name="name" placeholder="Name"
                        value="{{ old('name') }}" required>
                </div>

                <label class="text-start" for="email">email:</label>
                <div class="form-container m-0 p-0">
                    <input type="email" class="input text-dark" name="email" placeholder="email"
                        value="{{ old('email') }}" required>
                </div>

                <label class="text-start" for="contact">contact:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input text-dark" name="contact" placeholder="contact"
                        value="{{ old('contact') }}" required>
                </div>

                <label class="text-start" for="department_id">Department</label>
                <div class="form-container m-0 p-0">
                    <select class="input text-dark" name="department_id" id="department_id">
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <label class="text-start" for="password">password:</label>
                <div class="form-container m-0 p-0">
                    <input type="password" class="input text-dark" name="password" placeholder="password" required>
                </div>

                <label class="text-start" for="password_confirmation">confirm password:</label>
                <div class="form-container m-0 p-0">
                    <input type="password" class="input text-dark" name="password_confirmation" id="password_confirmation"
                        placeholder="confirm" required>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger p-0">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <label class="text-start" for="priority">Role:</label>
                <div class="form-container m-0 p-0">
                    <select class="input text-dark" name="role" required>
                        <option value="User">User</option>
                        <option value="Admin">Admin</option>
                    </select>

                </div>
                <button type="submit">create</button>
            </form>
        </div>
    </main>
@endsection
