<?php

namespace Platform\TodoList\Http\Requests;

use Platform\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;
use Platform\TodoList\Contants\StatusEnum;

class TodoListRequest extends Request
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
            'assignTo'   => [
                'required'
            ],
            'status' => Rule::in(StatusEnum::values()),
        ];
    }
}
