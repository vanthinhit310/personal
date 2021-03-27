<?php

namespace Platform\Notification\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar' => $this->sender->getAvatarUrlAttribute(),
            'message' => $this->content,
            'time' => Carbon::parse($this->created_at)->diffForHumans(),
            'status' => $this->status,
        ];
    }
}
