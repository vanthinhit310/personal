<?php

namespace Platform\TodoList\Http\Requests;

use Platform\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;
use Platform\TodoList\Contants\PiorityEnum;
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
                'required',
                'exists:members,id'
            ],
            'deadline' => [
                'required',
                'date_format:d/m/Y H:i'
            ],
            'piority' => [
                Rule::in(PiorityEnum::values())
            ],
            'status' => [
                Rule::in(StatusEnum::values())
            ],
        ];
    }
}
