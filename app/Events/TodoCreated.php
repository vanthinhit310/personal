<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Platform\Member\Models\Member;
use Platform\Notification\Repositories\Interfaces\NotificationInterface;

class TodoCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sender;
    public $todo;
    public $reciever;
    public $type;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Member $sender, $todo = null, $reciever = null, $type = null)
    {
        $this->sender = $sender;
        $this->todo = $todo;
        $this->reciever = $reciever;
        $this->type = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel(sprintf('member.%s', $this->reciever->id));
    }

    public function broadcastAs()
    {
        return 'task.socket';
    }

    public function broadcastWith()
    {
        switch ($this->type) {
            case 'created':
                # code...
                $message = sprintf('%s just assigned a new task %s to you. The deadline for completion is %s', @$this->sender->getFullName(), @$this->todo->name, @$this->todo->deadline);
                break;

            case 'updated':
                # code...
                $message = sprintf('%s just updated task %s.', @$this->sender->getFullName(), @$this->todo->name);
                break;

            case 'destroyed':
                # code...
                $message = sprintf('%s just destroyed task %s.', @$this->sender->getFullName(), @$this->todo->name);
                break;
        }

        //create new notification
        $notification = app(NotificationInterface::class)->createOrUpdate([
            'content' => $message,
            'from' => $this->sender->id,
            'to' => $this->reciever->id,
            'data' => json_encode([$this->sender, $this->todo, $this->reciever]),
            'status' => 'Unread'
        ]);

        return [
            'taskId' => $this->todo->id,
            'notificationId' => @$notification->id,
            'type' => $this->type
        ];
    }
}
