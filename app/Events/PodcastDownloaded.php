<?php

namespace App\Events;

use App\Models\Podcast;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PodcastDownloaded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Podcast
     */
    public Podcast $podcast;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Podcast $podcast)
    {
        $this->podcast = $podcast;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn(): Channel|array
    {
        // here we could broadcast on a particular channel name, and pick this event up on the likes of the frontend.
        // utilising websockets via pusher so that the frontend can directly interact with the event, and make changes
        // based upon when an event had occurred on the server. for simplicity in the scope of the project, avoiding
        // the creation of pusher and interacting with websockets on the frontend (as the scope is backend concepts).
        // jotting ideas for what could be utilised in this particular method as a future oriented task.
        return new PrivateChannel('channel-name');
    }
}
