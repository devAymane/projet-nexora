<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRoleRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', User::class);

        $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'role' => ['nullable', 'in:admin,client,provider'],
        ]);

        $query = User::with('roles');

        // Recherche par nom, prénom ou email
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtre par rôle
        if ($request->filled('role')) {
            $role = $request->input('role');

            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        $users = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        $this->authorize('create', User::class);

        return view('users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'telephone' => ['nullable', 'string', 'max:30'],
            'pays' => ['nullable', 'string', 'max:255'],
            'ville' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        // Par défaut, un utilisateur créé par l'admin devient client.
        $user->addRole('client');

        return redirect()
            ->route('users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): View
    {
        $this->authorize('view', $user);

        $user->load([
            'roles',
            'services',
            'reservations',
        ]);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        $user->load('roles');

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(
        Request $request,
        User $user
    ): RedirectResponse {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],
            'telephone' => ['nullable', 'string', 'max:30'],
            'pays' => ['nullable', 'string', 'max:255'],
            'ville' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'Utilisateur modifié avec succès.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(
        Request $request,
        User $user
    ): RedirectResponse {
        $this->authorize('delete', $user);

        // Empêcher l'admin de supprimer son propre compte.
        if ($request->user()->id === $user->id) {
            return redirect()
                ->route('users.index')
                ->with(
                    'error',
                    'Vous ne pouvez pas supprimer votre propre compte.'
                );
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Update the role of a user.
     */
    public function updateRole(
        UpdateUserRoleRequest $request,
        User $user
    ): RedirectResponse {
        $this->authorize('update', $user);

        // Empêcher l'admin de modifier son propre rôle.
        if ($request->user()->id === $user->id) {
            return redirect()
                ->route('users.index')
                ->with(
                    'error',
                    'Vous ne pouvez pas modifier votre propre rôle.'
                );
        }

        $role = $request->validated('role');

        $user->syncRoles([$role]);

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Rôle de ' . $user->prenom . ' ' . $user->nom .
                ' modifié avec succès.'
            );
    }
}