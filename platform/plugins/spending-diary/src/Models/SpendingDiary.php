<?php

namespace Platform\SpendingDiary\Models;

use Platform\Base\Traits\EnumCastable;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\Base\Models\BaseModel;
use Platform\Member\Models\Member;

class SpendingDiary extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'spending_diaries';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'member_id',
        'category_id',
        'amount',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function category(){
        return $this->belongsTo(SpendingDiaryCategory::class, 'category_id', 'id');
    }

    public function author(){
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
