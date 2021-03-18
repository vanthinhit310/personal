<?php

namespace Platform\Reminder\Http\Resources;

use App\Handle\Constant;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Platform\Member\Http\Resources\MemberResource;

class ReminderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'author' => new MemberResource($this->author),
            'status' => $this->status,
            'created' => Carbon::parse($this->created_at)->format(Constant::DATE_FORMAT)
        ];
    }
}
