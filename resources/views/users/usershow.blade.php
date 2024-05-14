@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="form-box">
            <form class="form" method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <span class="title">modify user</span>
                <input type="hidden" name="ticket_id" value="{{ $user->id }}">

                <label class="text-start" for="name">Name:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input" name="name" placeholder="Name"
                        value="{{ old('name', $user->name) }}" required>
                </div>

                <label class="text-start" for="subject">email:</label>
                <div class="form-container m-0 p-0">
                    <input type="email" class="input" name="email" placeholder="email"
                        value="{{ old('email', $user->email) }}" required>
                </div>

                <label class="text-start" for="subject">new password:</label>
                <div class="form-container m-0 p-0">
                    <input type="password" class="input" name="password" placeholder="password">
                </div>

                <label class="text-start" for="password_confirmation">confirm password:</label>
                <div class="form-container m-0 p-0">
                    <input type="password" class="input" name="password_confirmation" id="password_confirmation">
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
                        <option value="Admin" {{ $user->role === 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="User" {{ $user->role === 'User' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
                <button type="submit">update</button>
            </form>
        </div>
    </main>
@endsection
