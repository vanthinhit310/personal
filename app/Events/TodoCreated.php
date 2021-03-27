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

    public $member;
    public $todo;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Member $member, TodoList $todo)
    {
        $this->member = $member;
        $this->todo = $todo;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

        return new PrivateChannel(sprintf('member.%s', $this->member->id));
    }

    public function broadcastAs()
    {
        return 'task.created';
    }

    public function broadcastWith()
    {
        $message = sprintf('%s just assigned a new task %s to you. The deadline for completion is %s', @$this->member->getFullName(), @$this->todo->name, @$this->todo->deadline);

        //create new notification
        app(NotificationInterface::class)->createOrUpdate([
            'content' => $message,
            'data' => json_encode([$this->member, $this->todo]),
            'status' => 'Unread'
        ]);

        return [
            'taskId' => $this->todo->id,
            'message' => $message
        ];
    }
}
