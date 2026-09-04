<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;


class ConversationController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Conversation::class);

        $user = $request->user();

        $conversations = Conversation::with([
            'client',
            'provider',
            'messages' => fn ($query) => $query->latest('date_envoi')->limit(1),
        ])
            ->where(function ($query) use ($user) {
                $query->where('client_id', $user->id)
                    ->orWhere('provider_id', $user->id);
            })
            ->latest()
            ->paginate(10);

        return view('conversations.index', compact('conversations'));
    }

 public function create(Request $request, User $user): RedirectResponse
    {
        Gate::authorize('create', Conversation::class);

        abort_if($request->user()->id === $user->id, 403);

        $conversation = Conversation::firstOrCreate([
            'client_id' => $request->user()->hasRole('client')
                ? $request->user()->id
                : $user->id,

            'provider_id' => $request->user()->hasRole('provider')
                ? $request->user()->id
                : $user->id,
        ]);

        return redirect()->route('conversations.show', $conversation);
    }

    public function show(Conversation $conversation): View
    {
        Gate::authorize('view', $conversation);

        $conversation->load([
            'client',
            'provider',
            'messages.user',
        ]);

        return view('conversations.show', compact('conversation'));
    }
}