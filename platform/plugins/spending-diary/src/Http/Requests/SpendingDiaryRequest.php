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
        if($this->routeIs('diary.editdiary.update')){
            return [
                'name'   => [
                    'required',
                    Rule::unique('spending_diaries', 'name')->ignore($this->diary)
                ],
                'description'   => 'required',
                'category_id'   => [
                    'required',
                    'exists:spending_diarie_categories,id'
                ],
                'amount'   => [
                    'required',
                ],
                'status' => Rule::in(BaseStatusEnum::values()),
            ];
        }
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
            ],
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
