<?php

namespace Platform\Member\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'fullname'   => $this->getFullName(),
            'email'       => $this->email,
            'phone'       => $this->phone,
            'avatar'      => $this->avatar_url,
            'dob'         => $this->dob,
            'gender'      => $this->gender,
            'description' => $this->description,
        ];
    }
}
