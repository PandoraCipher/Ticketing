@include('auth.base')

<body class="container p-5 h-100">
    <section class="login">
        <div class="formulaire">
            <form class="" action="{{ route('auth.login') }}" method="POST">
                @csrf
                <h1 class="form_heading text-center">Ticket System</h1>
                <div class="d-flex">
                    {{--<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path fill="currentColor"
                            d="M4 15h2v5h12V4H6v5H4V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6zm6-4V8l5 4-5 4v-3H2v-2h8z">
                        </path>
                    </svg>--}}
                    <h1 class="">Login</h1>
                </div>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @error('email')
                    <label class="text-danger" for="">{{ $message }}</label>
                @enderror
                <div class="field">
                    <label for="email">email: </label>
                    <input class="input" name="email" type="email" placeholder="" id="email"
                        value="{{ old('email') }}">

                </div>
                <div class="field">
                    <label for="password">Password: </label>
                    <input class="input" name="password" type="password" placeholder="" id="password"
                        required>
                </div>
                <div class="field">
                    <button class="button">Login</button>
                </div>
            </form>
            <a href="{{ route('auth.signup') }}">
                <button class="button">Sign up</button>
            </a>
        </div>
    </section>

</body>

