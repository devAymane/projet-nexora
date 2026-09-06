<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->otherUser = User::factory()->create();
});

test('authenticated user can view notifications', function () {
    $this->user->notify(
        new class extends \Illuminate\Notifications\Notification {
            public function via(object $notifiable): array
            {
                return ['database'];
            }

            public function toArray(object $notifiable): array
            {
                return [
                    'message' => 'Notification test',
                ];
            }
        }
    );

    $response = $this
        ->actingAs($this->user)
        ->get(route('notifications.index'));

    $response->assertSuccessful();
    $response->assertViewHas('notifications');
});

test('guest cannot view notifications', function () {
    $response = $this->get(route('notifications.index'));

    $response->assertRedirect(route('login'));
});

test('user can mark own notification as read', function () {
    $notification = $this->user->notifications()->create([
        'id' => \Illuminate\Support\Str::uuid(),
        'type' => 'test',
        'data' => [
            'message' => 'Notification test',
        ],
    ]);

    $response = $this
        ->actingAs($this->user)
        ->patch(route('notifications.read', $notification));

    $response->assertRedirect();

    expect(
        $notification->fresh()->read_at
    )->not->toBeNull();
});

test('user cannot mark another user notification as read', function () {
    $notification = $this->otherUser->notifications()->create([
        'id' => \Illuminate\Support\Str::uuid(),
        'type' => 'test',
        'data' => [
            'message' => 'Private notification',
        ],
    ]);

    $response = $this
        ->actingAs($this->user)
        ->patch(route('notifications.read', $notification));

    $response->assertForbidden();

    expect(
        $notification->fresh()->read_at
    )->toBeNull();
});

test('user can mark all notifications as read', function () {
    $this->user->notifications()->createMany([
        [
            'id' => \Illuminate\Support\Str::uuid(),
            'type' => 'test',
            'data' => ['message' => 'Notification 1'],
        ],
        [
            'id' => \Illuminate\Support\Str::uuid(),
            'type' => 'test',
            'data' => ['message' => 'Notification 2'],
        ],
    ]);

    expect(
        $this->user->unreadNotifications()->count()
    )->toBe(2);

    $response = $this
        ->actingAs($this->user)
        ->patch(route('notifications.read-all'));

    $response->assertRedirect();
    $response->assertSessionHas(
        'success',
        'Toutes les notifications ont été marquées comme lues.'
    );

    expect(
        $this->user->fresh()->unreadNotifications()->count()
    )->toBe(0);
});

test('guest cannot mark all notifications as read', function () {
    $response = $this->patch(route('notifications.read-all'));

    $response->assertRedirect(route('login'));
});