<form method="post" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data"
    id="updateForm{{ $user->id }}">
    @csrf
    @method('PUT')
    <div class="modal fade" id="modifyModal{{ $user->id }}" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" aria-labelledby="modifyModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifyModalLabel{{ $user->id }}">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="text-start" for="name">Name:</label>
                    <div class="form-container m-0 p-0">
                        <input type="text" class="input text-dark" name="name" id="name{{ $user->id }}"
                            placeholder="Name" value="{{ old('name', $user->name) }}" required>
                        <span class="text-danger" id="nameError{{ $user->id }}"></span>
                    </div>

                    <label class="text-start" for="email">Email:</label>
                    <div class="form-container m-0 p-0">
                        <input type="email" class="input text-dark" name="email" id="email{{ $user->id }}"
                            placeholder="Email" value="{{ old('email', $user->email) }}" required>
                        <span class="text-danger" id="emailError{{ $user->id }}"></span>
                    </div>

                    <label  for="contact">Contact:</label>
                    <div class="form-container m-0 p-0">
                        <input type="text" class="input text-dark" name="contact" id="contact{{ $user->id }}"
                            placeholder="Contact" value="{{ old('contact', $user->contact) }}" required>
                        <span class="text-danger" id="contactError{{ $user->id }}"></span>
                    </div>

                    <label class="text-start" for="department_id">Department</label>
                    <div class="form-container m-0 p-0">
                        <select class="input text-dark" name="department_id" id="department_id{{ $user->id }}">
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <label class="text-start" for="password">New Password:</label>
                    <div class="form-container m-0 p-0">
                        <input type="password" class="input text-dark" name="password" id="password{{ $user->id }}"
                            placeholder="Password">
                        <span class="text-danger" id="passwordError{{ $user->id }}"></span>
                    </div>

                    <label class="text-start" for="password_confirmation">Confirm Password:</label>
                    <div class="form-container m-0 p-0">
                        <input type="password" class="input text-dark" name="password_confirmation"
                            id="password_confirmation{{ $user->id }}">
                        <span class="text-danger" id="passwordConfirmationError{{ $user->id }}"></span>
                    </div>

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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#updateForm{{ $user->id }}').on('submit', function(event) {
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
                    $('#modifyModal{{ $user->id }}').modal('hide');
                    // Exemple de redirection après succès
                    window.location.href = response.redirect_url;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Nettoyer les messages d'erreur précédents
                    $('#nameError{{ $user->id }}').text('');
                    $('#emailError{{ $user->id }}').text('');
                    $('#contactError{{ $user->id }}').text('');
                    $('#passwordError{{ $user->id }}').text('');
                    $('#passwordConfirmationError{{ $user->id }}').text('');
                    console.log('Il y a une putain d\'erreur dans ton foutu code');
                    console.error('Erreur lors de la soumission du formulaire:', textStatus,
                        errorThrown);

                    // Échec : afficher les erreurs de validation dans le modal
                    if (jqXHR.status ===
                        422) { // Code 422 indique des erreurs de validation
                        var errors = jqXHR.responseJSON.errors;
                        if (errors.name) {
                            $('#nameError{{ $user->id }}').text(errors.name[0]);
                        }
                        if (errors.email) {
                            $('#emailError{{ $user->id }}').text(errors.email[0]);
                        }
                        if (errors.contact) {
                            $('#contactError{{ $user->id }}').text(errors.contact[0]);
                        }
                        if (errors.password) {
                            $('#passwordError{{ $user->id }}').text(errors.password[
                                0]);
                        }
                        if (errors.password_confirmation) {
                            $('#passwordConfirmationError{{ $user->id }}').text(errors
                                .password_confirmation[0]);
                        }
                        // Afficher le modal pour montrer les erreurs
                        $('#modifyModal{{ $user->id }}').modal('show');
                    }
                }
            });
        });
    });
</script>
