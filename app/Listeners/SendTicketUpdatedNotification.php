<?php

namespace App\Listeners;

use App\Events\TicketUpdated;
use App\Models\User;
use App\Notifications\TicketUpdated as TicketUpdatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTicketUpdatedNotification
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
    public function handle(TicketUpdated $event)
    {
        $ticket = $event->ticket;
        $users = collect([
            User::where('name', $ticket->name)->first(),
            User::where('name', $ticket->client)->first(),
        ])->filter()->unique('id');

        $admins = User::where('role', 'Admin')->get();
        $users = $users->merge($admins)->unique('id');

        try{
        foreach ($users as $user){
            $user->notify(new TicketUpdatedNotification($ticket));
        }
    }catch(\Exception $e){
        throw new \Exception($e->getMessage());
    }
    }
}
