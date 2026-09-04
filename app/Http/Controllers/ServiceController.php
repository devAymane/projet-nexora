<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display a listing of published services.
     */
    public function index(Request $request): View
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'integer', 'exists:categories,id'],
            'ville' => ['nullable', 'string', 'max:100'],
            'prix_min' => ['nullable', 'numeric', 'min:0'],
            'prix_max' => ['nullable', 'numeric', 'gte:prix_min'],
        ]);

        $query = Service::with(['category', 'user'])
            ->where('statut', 'publie');

        // Recherche
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('ville', 'like', "%{$search}%");
            });
        }

        // Catégorie
        if ($request->filled('category')) {
            $query->where(
                'category_id',
                $request->input('category')
            );
        }

        // Ville
        if ($request->filled('ville')) {
            $query->where(
                'ville',
                $request->input('ville')
            );
        }

        // Prix minimum
        if ($request->filled('prix_min')) {
            $query->where(
                'prix',
                '>=',
                $request->input('prix_min')
            );
        }

        // Prix maximum
        if ($request->filled('prix_max')) {
            $query->where(
                'prix',
                '<=',
                $request->input('prix_max')
            );
        }

        $services = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('nom')->get();

        $villes = Service::where('statut', 'publie')
            ->whereNotNull('ville')
            ->distinct()
            ->orderBy('ville')
            ->pluck('ville');

        return view('services.index', compact(
            'services',
            'categories',
            'villes'
        ));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create(): View
    {
        $this->authorize('create', Service::class);

        $categories = Category::orderBy('nom')->get();

        return view('services.create', compact('categories'));
    }

    /**
     * Store a newly created service.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Service::class);

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'ville' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
            'disponibilite' => ['nullable', 'boolean'],
        ]);

        $validated['user_id'] = $request->user()->id;

        // Nouveau service = brouillon
        $validated['statut'] = 'brouillon';

        $validated['disponibilite'] =
            $request->boolean('disponibilite');

        // Upload image
        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('services', 'public');
        }

        Service::create($validated);

        return redirect()
            ->route('services.index')
            ->with(
                'success',
                'Service créé avec succès.'
            );
    }

    /**
     * Display the specified published service.
     */
    public function show(Service $service): View
    {
        // Uniquement les services publiés sont accessibles publiquement.
        abort_unless(
            $service->statut === 'publie',
            404
        );

        $service->load([
            'user',
            'category',
            'avis.user',
        ]);

        return view(
            'services.show',
            compact('service')
        );
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service): View
    {
        $this->authorize('update', $service);

        $categories = Category::orderBy('nom')->get();

        return view(
            'services.edit',
            compact('service', 'categories')
        );
    }

    /**
     * Update the specified service.
     */
    public function update(
        Request $request,
        Service $service
    ): RedirectResponse {
        $this->authorize('update', $service);

        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'titre' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'prix' => [
                'required',
                'numeric',
                'min:0',
            ],

            'ville' => [
                'required',
                'string',
                'max:255',
            ],

            'image' => [
                'nullable',
                'image',
                'max:2048',
            ],

            'disponibilite' => [
                'nullable',
                'boolean',
            ],

            'statut' => [
                'required',
                'in:brouillon,publie,suspendu',
            ],
        ]);

        $validated['disponibilite'] =
            $request->boolean('disponibilite');

        // Nouvelle image
        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('services', 'public');
        }

        $service->update($validated);

        return redirect()
            ->route('services.index')
            ->with(
                'success',
                'Service modifié avec succès.'
            );
    }

    /**
     * Remove the specified service.
     */
    public function destroy(
        Service $service
    ): RedirectResponse {
        $this->authorize('delete', $service);

        $service->delete();

        return redirect()
            ->route('services.index')
            ->with(
                'success',
                'Service supprimé avec succès.'
            );
    }
}