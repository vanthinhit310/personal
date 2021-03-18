<?php

namespace Platform\Reminder\Models;

use Platform\Base\Traits\EnumCastable;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\Base\Models\BaseModel;
use Platform\Member\Models\Member;

class Reminder extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reminders';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'member_id',
        'date',
        'time',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function author(){
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
