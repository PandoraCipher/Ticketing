@extends('layouts.main')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="form-box">
            <form class="form" method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data"
                id="updateForm">
                @csrf
                @method('PUT')

                <span class="title">modify user</span>
                <input type="hidden" name="ticket_id" value="{{ $user->id }}">

                <label class="text-start" for="name">Name:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input text-dark" name="name" placeholder="Name"
                        value="{{ old('name', $user->name) }}" required>
                </div>

                <label class="text-start" for="email">email:</label>
                <div class="form-container m-0 p-0">
                    <input type="email" class="input text-dark" name="email" placeholder="email"
                        value="{{ old('email', $user->email) }}" required>
                </div>

                <label class="text-start" for="contact">contact:</label>
                <div class="form-container m-0 p-0">
                    <input type="text" class="input text-dark" name="contact" placeholder="contact"
                        value="{{ old('contact', $user->contact) }}" required>
                </div>

                <label class="text-start" for="password">new password:</label>
                <div class="form-container m-0 p-0">
                    <input type="password" class="input text-dark" name="password" placeholder="password">
                    <span class="text-danger" id="passwordError"></span>
                </div>

                <label class="text-start" for="password_confirmation">confirm password:</label>
                <div class="form-container m-0 p-0">
                    <input type="password" class="input text-dark" name="password_confirmation" id="password_confirmation">
                    <span class="text-danger" id="passwordConfirmationError"></span>
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

                @if (Auth::user()->role == 'Admin')
                    <label class="text-start" for="role">Role:</label>
                    <div class="form-container m-0 p-0">
                        <select class="input text-dark" name="role" required>
                            <option value="Admin" {{ $user->role === 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="User" {{ $user->role === 'User' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                @else
                    <input type="hidden" name="role" value="User">
                @endif

                <button type="submit">update</button>
            </form>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            $('#updateForm').on('submit', function(event) {
                event.preventDefault(); // Empêcher la soumission par défaut du formulaire

                // Récupérer les données du formulaire
                var formData = $(this).serializeArray();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                formData.push({
                    name: '_token',
                    value: csrfToken
                });

                // Envoyer une requête AJAX à l'endpoint Laravel
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        // Réussite : fermer le modal après succès
                        console.log('Fermeture du modal');
                        $('#modifyModal').modal('hide'); // Assurez-vous que #modifyModal existe
                        // Exemple de redirection après succès
                        window.location.href = response
                        .redirect_url; // Assurez-vous que la réponse contient redirect_url
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Nettoyer les messages d'erreur précédents
                        $('#passwordError').text('');
                        $('#passwordConfirmationError').text('');

                        // Échec : afficher les erreurs de validation
                        if (jqXHR.status ===
                            422) { // Code 422 indique des erreurs de validation
                            var errors = jqXHR.responseJSON.errors;
                            if (errors.password) {
                                $('#passwordError').text(errors.password[0]);
                            }
                            if (errors.password_confirmation) {
                                $('#passwordConfirmationError').text(errors
                                    .password_confirmation[0]);
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
