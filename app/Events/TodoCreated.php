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
use Platform\TodoList\Models\TodoList;

class TodoCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sender;
    public $todo;
    public $reciever;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Member $sender, TodoList $todo, Member $reciever)
    {
        $this->sender = $sender;
        $this->todo = $todo;
        $this->reciever = $reciever;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel(sprintf('member.%s', $this->reciever->id));
    }

    public function broadcastAs()
    {
        return 'task.created';
    }

    public function broadcastWith()
    {
        $message = sprintf('%s just assigned a new task %s to you. The deadline for completion is %s', @$this->sender->getFullName(), @$this->todo->name, @$this->todo->deadline);

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
            'notificationId' => @$notification->id
        ];
    }
}
