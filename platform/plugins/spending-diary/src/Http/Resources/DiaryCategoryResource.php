<?php

namespace Platform\SpendingDiary\Http\Resources;

use App\Handle\Constant;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DiaryCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'color' => $this->color,
            'created' => Carbon::parse($this->created_at)->format(Constant::DATE_FORMAT)
        ];
    }
}
