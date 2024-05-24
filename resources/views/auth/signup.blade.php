@include('auth.base')

<body class="container my-5 p-5 h-100 w-100">
    <div class="card">
        <form class="form card" action="{{ route('user.signup') }}" method="POST">
            @csrf
            <h1 class="form_heading text-center">Ticket System</h1>
            <div class="card_header">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path fill="currentColor"
                        d="M4 15h2v5h12V4H6v5H4V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6zm6-4V8l5 4-5 4v-3H2v-2h8z">
                    </path>
                </svg>
                <h1 class="form_heading">Sign up</h1>
            </div>
            <div class="field">
                <label for="name">name</label>
                <input class="input" name="name" type="text" placeholder="name" id="name"
                    value="{{ old('email') }}" required>
            </div>

            <div class="field">
                <label for="email">email</label>
                <input class="input" name="email" type="email" placeholder="email" id="email"
                    value="{{ old('email') }}" required>
            </div>

            <div class="field">
                <label for="email">contact</label>
                <input class="input" name="contact" type="text" placeholder="contact" id="contact"
                    value="{{ old('email') }}" required>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input class="input" name="password" type="password" placeholder="Password" id="password" required>
            </div>

            <div class="field">
                <label for="password">Confirm Password</label>
                <input class="input" name="password_confirmation" type="password" placeholder="Confirm Password"
                    id="password_confirmation" required>
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

            <input type="hidden" name="role" value="User">

            <div class="field">
                <button class="button" type="submit">Signin</button>
            </div>
        </form>
    </div>

</body>

</html>
