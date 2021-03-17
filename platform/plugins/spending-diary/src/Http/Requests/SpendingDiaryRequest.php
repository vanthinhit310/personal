<?php

namespace Platform\SpendingDiary\Http\Requests;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class SpendingDiaryRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => [
                'required',
                'unique:spending_diaries,name'
            ],
            'description'   => 'required',
            'category_id'   => [
                'required',
                'exists:spending_diarie_categories,id'
            ],
            'amount'   => [
                'required',
                'min:10000'
            ],
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
