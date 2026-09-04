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
     * Display a listing of the services.
     */
    public function index(): View
    {
        $services = Service::with(['user', 'category'])
            ->latest()
            ->paginate(12);

        return view('services.index', compact('services'));
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
        $validated['statut'] = 'brouillon';
        $validated['disponibilite'] = $request->boolean('disponibilite');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store(
                'services',
                'public'
            );
        }

        Service::create($validated);

        return redirect()
            ->route('services.index')
            ->with('success', 'Service créé avec succès.');
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service): View
    {
        $service->load(['user', 'category']);

        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service): View
    {
        $this->authorize('update', $service);

        $categories = Category::orderBy('nom')->get();

        return view('services.edit', compact('service', 'categories'));
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
            'category_id' => ['required', 'exists:categories,id'],
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'ville' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
            'disponibilite' => ['nullable', 'boolean'],
            'statut' => ['required', 'in:brouillon,publie,suspendu'],
        ]);

        $validated['disponibilite'] = $request->boolean('disponibilite');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store(
                'services',
                'public'
            );
        }

        $service->update($validated);

        return redirect()
            ->route('services.index')
            ->with('success', 'Service modifié avec succès.');
    }

    /**
     * Remove the specified service.
     */
    public function destroy(Service $service): RedirectResponse
    {
        $this->authorize('delete', $service);

        $service->delete();

        return redirect()
            ->route('services.index')
            ->with('success', 'Service supprimé avec succès.');
    }
}