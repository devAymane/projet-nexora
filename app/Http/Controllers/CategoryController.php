<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(): View
    {
        $this->authorize('viewAny', Category::class);

        $categories = Category::withCount('services')
            ->orderBy('nom')
            ->paginate(10);

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        $this->authorize('create', Category::class);

        return view('categories.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Category::class);

        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:categories,nom'],
            'description' => ['nullable', 'string'],
        ]);

        Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category): View
    {
        $this->authorize('view', $category);

        $category->load([
            'services' => function ($query) {
                $query->with(['user', 'category'])
                    ->latest();
            },
        ]);

        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category): View
    {
        $this->authorize('update', $category);

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category.
     */
    public function update(
        Request $request,
        Category $category
    ): RedirectResponse {
        $this->authorize('update', $category);

        $validated = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:255',
                'unique:categories,nom,' . $category->id,
            ],
            'description' => ['nullable', 'string'],
        ]);

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Catégorie modifiée avec succès.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $this->authorize('delete', $category);

        if ($category->services()->exists()) {
            return redirect()
                ->route('categories.index')
                ->with(
                    'error',
                    'Impossible de supprimer cette catégorie car elle contient des services.'
                );
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}