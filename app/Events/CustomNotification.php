<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

	public $message, $user_id ,$date ,$id;

    public function __construct( $user_id, $message ,$date,$id)
    {
        $this->user_id = $user_id;
        $this->message = $message;
        $this->date= $date;
        $this->id = $id;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
	public function broadcastOn()
	{
		return ['my-channel-' . $this->user_id  ];
	}

	public function broadcastAs()
	{
		return 'my-event-' . $this->user_id;
	}
}
