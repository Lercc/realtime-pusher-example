<?php

namespace App\Events;

use App\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusChangedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('channel-name');
        // return new Channel('pizza-tracker');
        // return new Channel('pizza-tracker.'.$this->order->id);
        return [
            'pizza-tracker.' . $this->order->id,
            'pizza-tracker'
        ];
    }

    public function broadcastWith()
    {
        $this->order->status_name = $this->order->status->name;
        $this->order->status_percent = $this->order->status->percent;

        \Log::debug("{$this->order}");      //
        return $this->order->toArray();
    }
}
