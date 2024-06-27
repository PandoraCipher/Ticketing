@include('auth.base')

<body class="container p-5 h-100">
    <section class="login">
        <div class="formulaire">
            <form class="" action="{{ route('user.signup') }}" method="POST">
                @csrf
                <h1 class="form_heading text-center">Ticket System</h1>
                <div class="d-flex">
                    <h1 class="">Sign up</h1>
                </div>
                <div class="field">
                    <label for="name">name: </label>
                    <input class="input" name="name" type="text" placeholder="" id="name"
                        value="{{ old('email') }}" required>
                </div>

                <div class="field">
                    <label for="email">email: </label>
                    <input class="input" name="email" type="email" placeholder="" id="email"
                        value="{{ old('email') }}" required>
                </div>

                <div class="field">
                    <label for="contact">contact: </label>
                    <input class="input" name="contact" type="text" placeholder="" id="contact"
                        value="{{ old('email') }}" required>
                </div>

                <div class="field">
                    <label for="department_id">Department: </label>
                    <select class="input bg-white" name="department_id" id="department_id">
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="password">Password: </label>
                    <input class="input" name="password" type="password" placeholder="" id="password"
                        required>
                </div>

                <div class="field">
                    <label for="password">Confirm Password: </label>
                    <input class="input" name="password_confirmation" type="password" placeholder=""
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
    </section>

</body>

</html>
