<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();
        return view('users.userlist', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('users.usercreate', ['users' => $users]);
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
                'password' => 'required|string|min:4|confirmed', // Le champ est obligatoire et doit être confirmé
                'role' => 'required|string|in:Admin,User', // Le rôle doit être soit 'admin' soit 'user'
            ],
            [
                'password.confirmed' => 'The passwords do not match.',
            ],
        );

        // Créer un nouvel utilisateur avec les données validées
        $user = new User([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // Hasher le mot de passe
            'role' => $validatedData['role'],
        ]);

        // Enregistrer le nouvel utilisateur dans la base de données
        $user->save();

        return redirect()->route('users.userlist')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.usershow', compact('user'));
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
        $user = User::findOrFail($id);

        // Règles de validation pour la mise à jour de l'utilisateur
        $validatedData = $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $user->id, // Assure l'unicité de l'email en excluant l'utilisateur actuel
                'password' => 'nullable|string|min:4|confirmed', // Le champ est facultatif et doit être confirmé
                'role' => 'required|string|in:Admin,User', // Le rôle doit être soit 'admin' soit 'user'
                'password_confirmation' => 'nullable|string|min:4', // Règle pour confirmer le mot de passe
            ],
            [
                'password.confirmed' => 'The passwords do not match.',
            ],
        );

        // Mettre à jour les champs de l'utilisateur
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->role = $validatedData['role'];

        // Vérifier et mettre à jour le mot de passe si fourni
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Enregistrer les modifications de l'utilisateur
        $user->save();

        return redirect()
            ->route('users.userlist', $user->id)
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
