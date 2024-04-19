{{-- @extends('base') --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
</head>

<body>
    <div class="card">
        <form class="form card" action="{{ route('auth.login') }}" method="POST">
            @csrf
            <div class="card_header">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path fill="currentColor"
                        d="M4 15h2v5h12V4H6v5H4V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6zm6-4V8l5 4-5 4v-3H2v-2h8z">
                    </path>
                </svg>
                <h1 class="form_heading">Login</h1>
            </div>
            @error('email')
                <label class="text-danger" for="">{{ $message }}</label>
            @enderror
            <div class="field">
                <label for="email">email</label>
                <input class="input" name="email" type="email" placeholder="email" id="email"
                    value="{{ old('email') }}">

            </div>
            <div class="field">
                <label for="password">Password</label>
                <input class="input" name="password" type="password" placeholder="Password" id="password">
                {{-- @error('password')
                    <label class="text-danger" for="">{{ $message }}</label>
                @enderror --}}
            </div>
            <div class="field">
                <button class="button">Login</button>
            </div>
        </form>
    </div>

</body>

</html>
