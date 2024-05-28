<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Models\User;
use App\Notifications\TicketCreated as TicketCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTicketCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TicketCreated $event)
    {
        $ticket = $event->ticket;
        $users = collect([
            User::where('name', $ticket->name)->first(),
            User::where('name', $ticket->client)->first(),
        ])->filter()->unique('id');

        $admins = User::where('role', 'Admin')->get();
        $users = $users->merge($admins)->unique('id');

        foreach ($users as $user){
            $user->notify(new TicketCreatedNotification($ticket));
        }
    }
}
