<?php

namespace Platform\TodoList\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'message' => $this->content,
            'status' => $this->status,
        ];
    }
}
