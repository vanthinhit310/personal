<?php

namespace Platform\TodoList\Http\Resources;

use App\Handle\Constant;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Platform\Member\Http\Resources\MemberResource;

class TodoListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'deadline' => $this->deadline,
            'author' => new MemberResource($this->author),
            'members' => MemberResource::collection($this->members),
            'piority' => $this->piority,
            'status' => $this->status,
            'created' => Carbon::parse($this->created_at)->format(Constant::DATE_FORMAT)
        ];
    }
}
