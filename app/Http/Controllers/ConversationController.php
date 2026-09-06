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
    /**
     * Display the user's conversations.
     */
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Conversation::class);

        $user = $request->user();

        $conversations = Conversation::with([
            'client',
            'provider',
            'messages' => fn ($query) => $query
                ->latest('date_envoi')
                ->limit(1),
        ])
            ->where(function ($query) use ($user) {
                $query
                    ->where('client_id', $user->id)
                    ->orWhere('provider_id', $user->id);
            })
            ->latest('updated_at')
            ->paginate(10);

        return view('conversations.index', compact('conversations'));
    }

    /**
     * Create a conversation with another user.
     */
    public function create(Request $request, User $user): RedirectResponse
    {
        Gate::authorize('create', Conversation::class);

        $currentUser = $request->user();

        abort_if($currentUser->id === $user->id, 403);

        abort_unless(
            $currentUser->hasRole('client') || $currentUser->hasRole('provider'),
            403
        );

        abort_unless(
            $user->hasRole('client') || $user->hasRole('provider'),
            403
        );

        $clientId = $currentUser->hasRole('client')
            ? $currentUser->id
            : $user->id;

        $providerId = $currentUser->hasRole('provider')
            ? $currentUser->id
            : $user->id;

        $conversation = Conversation::firstOrCreate([
            'client_id' => $clientId,
            'provider_id' => $providerId,
        ]);

        return redirect()->route('conversations.show', $conversation);
    }

    /**
     * Display a conversation.
     */
    public function show(Conversation $conversation): View
    {
        Gate::authorize('view', $conversation);

        $conversation->load([
            'client',
            'provider',
            'messages.user',
        ]);

        // Mark incoming unread messages as read.
        $conversation->messages()
            ->where('user_id', '!=', auth()->id())
            ->where('lu', false)
            ->update([
                'lu' => true,
            ]);

        return view('conversations.show', compact('conversation'));
    }
}