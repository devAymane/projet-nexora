<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MessageController extends Controller
{
    public function store(
        Request $request,
        Conversation $conversation
    ): RedirectResponse {
        Gate::authorize('view', $conversation);
        Gate::authorize('create', Message::class);

        $validated = $request->validate([
            'contenu' => ['required', 'string', 'max:2000'],
        ]);

        $message = $conversation->messages()->create([
            'user_id' => $request->user()->id,
            'contenu' => $validated['contenu'],
            'lu' => false,
            'date_envoi' => now(),
        ]);

        if ($request->user()->id === $conversation->client_id) {
            $recipient = $conversation->provider;
        } else {
            $recipient = $conversation->client;
        }

        $recipient->notify(
            new NewMessageNotification($message)
        );

        return redirect()
            ->route('conversations.show', $conversation)
            ->with('success', 'Message envoyé.');
    }

    public function read(
        Request $request,
        Message $message
    ): RedirectResponse {
        Gate::authorize('view', $message);

        $message->update([
            'lu' => true,
        ]);

        return back();
    }
}