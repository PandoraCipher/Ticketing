<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchUserRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Ramsey\Uuid\Type\Integer;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchUserRequest $request)
    {
        $departments = Department::all();
        $query = User::with('department')->orderBy('id', 'asc');

        if ($request->input('name') != '') {
            $name = $request->input('name');

            $query->where('name', 'like', "%$name%");
        }

        if ($request->input('department_id') != '') {
            $department_id = $request->input('department_id');

            $query->where('department_id', $department_id);
        }

        $users = $query->paginate(100);
        return view('users.userlist', compact('users', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $departments = Department::all();
        return view('users.usercreate', ['users' => $users, 'departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Règles de validation pour la mise à jour de l'utilisateur
        $validatedData = $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email', // Assure l'unicité de l'email
                'contact' => 'required|string|max:15',
                'password' => 'required|string|min:4|confirmed', // Le champ est obligatoire et doit être confirmé
                'role' => 'required|string|in:Admin,User', // Le rôle doit être soit 'admin' soit 'user'
                'department_id' => 'required|exists:departments,id',
            ],
            [
                'password.confirmed' => 'The passwords do not match.',
            ],
        );

        // Créer un nouvel utilisateur avec les données validées
        $user = new User([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'contact' => $validatedData['contact'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
            'department_id' => $validatedData['department_id'],
        ]);

        $user->save();

        return redirect()->route('users.userlist')->with('success', 'User created successfully');
    }

    public function register(Request $request)
    {
        // Règles de validation pour l'inscription de l'utilisateur
        $validatedData = $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email', // Assure l'unicité de l'email
                'contact' => 'required|string|max:15',
                'password' => 'required|string|min:4|confirmed', // Le champ est obligatoire et doit être confirmé
                'department_id' => 'required|exists:departments,id',
            ],
            [
                'password.confirmed' => 'The passwords do not match.',
            ],
        );

        // Créer un nouvel utilisateur avec les données validées
        $user = new User([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'contact' => $validatedData['contact'],
            'password' => Hash::make($validatedData['password']),
            'department_id' => $validatedData['department_id'],
        ]);

        $user->save();

        // Redirige l'utilisateur nouvellement inscrit vers une page appropriée
        return redirect()->route('auth.login')->with('success', 'User created successfully. Please log in.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $departments = Department::all();
        return view('users.usershow', compact('user', 'departments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);

            // Règles de validation pour la mise à jour de l'utilisateur
            $validatedData = $request->validate(
                [
                    'name' => 'required|string',
                    'email' => [
                        'required',
                        'email',
                        Rule::unique('users')->ignore($user->id),
                        function ($attribute, $value, $fail) {
                            if (!strpos($value, '@')) {
                                $fail('The email must contain @');
                            }
                        },
                    ],
                    'contact' => ['required', 'string', 'max:15', 'regex:/^\+?[0-9]+$/'],
                    'department_id' => 'required|exists:departments,id',
                    'password' => 'nullable|string|min:4|confirmed',
                    'role' => 'required|string|in:Admin,User',
                    'password_confirmation' => 'nullable|string|min:4',
                ],
                [
                    'password.confirmed' => 'The passwords do not match.',
                ],
            );

            // Mettre à jour les champs de l'utilisateur
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->contact = $validatedData['contact'];
            $user->department_id = $validatedData['department_id'];
            $user->role = $validatedData['role'];

            // Vérifier et mettre à jour le mot de passe si fourni
            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            // Enregistrer les modifications de l'utilisateur
            $user->save();

            $successMessage = 'User updated successfully';

            Session::flash('success', $successMessage);

            // Redirection avec un message de succès approprié
            if (Auth::user()->role == 'Admin') {
                return response()->json(['redirect_url' => route('users.userlist', $user->id), 'message' => $successMessage], 200);
            } else {
                return response()->json(['redirect_url' => route('dashboard'), 'message' => 'Profil updated successfully'], 200);
            }
        } catch (ValidationException $e) {
            // Renvoyer les erreurs de validation en tant que réponse JSON
            return response()->json(['errors' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            // Renvoyer une réponse JSON avec une erreur générale
            return response()->json(['message' => 'An error occurred while updating user.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(String $id)
    {
        try {
            // Rechercher l'utilisateur par ID
            $user = User::findOrFail($id);

            // Supprimer l'utilisateur
            $user->delete();

            // Redirection avec message de succès
            return redirect()->route('users.userlist')->with('success', 'User deleted successfully');
        } catch (ModelNotFoundException $e) {
            // Gestion de l'erreur lorsque l'utilisateur n'est pas trouvé
            return redirect()->route('users.userlist')->with('error', 'User not found');
        } catch (\Exception $e) {
            // Gestion générale des autres erreurs
            return redirect()->route('users.userlist')->with('error', 'cannot delete this user');
        }
    }
}
