@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="form-box">
            <form class="form" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                @csrf
                <span class="title">New user</span>
                <label class="text-start" for="name">Name:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" name="name" placeholder="Name" value="{{ old('name') }}"
                        required>
                </div>

                <label class="text-start" for="subject">email:</label>
                <div class="form-container m-0 p-0">
                    <input type="email" class="input" name="email" placeholder="email" value="{{ old('email') }}"
                        required>
                </div>

                <label class="text-start" for="subject">contact:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" name="contact" placeholder="contact" value="{{ old('contact') }}"
                        required>
                </div>

                <label class="text-start" for="password">password:</label>
                <div class="form-container m-0 p-0">
                    <input type="password" class="input" name="password" placeholder="password" required>
                </div>

                <label class="text-start" for="password_confirmation">confirm password:</label>
                <div class="form-container m-0 p-0">
                    <input type="password" class="input" name="password_confirmation" id="password_confirmation"
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
                    <select class="input" name="role" required>
                        <option value="User" @if (old('role') == 'User') selected @endif>User</option>
                        <option value="Admin" @if (old('role') == 'Admin') selected @endif>Admin</option>
                    </select>

                </div>
                <button type="submit">create</button>
            </form>
        </div>
    </main>
@endsection
