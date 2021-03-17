<?php

namespace Platform\SpendingDiary\Http\Resources;

use App\Handle\Constant;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Platform\Member\Http\Resources\MemberResource;

class DiaryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'amount' => $this->amount,
            'author' => new MemberResource($this->author),
            'category' => new DiaryCategoryResource($this->category),
            'created' => Carbon::parse($this->created_at)->format(Constant::DATE_FORMAT)
        ];
    }
}
