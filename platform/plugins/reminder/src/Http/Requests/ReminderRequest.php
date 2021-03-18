<?php

namespace Platform\Reminder\Http\Requests;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;
use Platform\Reminder\Contants\StatusEnum;

class ReminderRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => 'required',
            'description'   => 'required',
            'member_id'   => 'required',
            'date'   => [
                'required',
                'date_format:d/m/Y'
            ],
            'time'   => [
                'required',
            ],
            'status' => Rule::in(StatusEnum::values()),
        ];
    }
}
