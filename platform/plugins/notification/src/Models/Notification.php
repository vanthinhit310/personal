<?php

namespace Platform\Notification\Models;

use Platform\Base\Models\BaseModel;
use Platform\Member\Models\Member;

class Notification extends BaseModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'app_notifications';

    /**
     * @var array
     */
    protected $fillable = [
        'content',
        'data',
        'url',
        'from',
        'to',
        'schedule',
        'status',
    ];

    public function sender()
    {
        return $this->belongsTo(Member::class, 'from', 'id');
    }

    public function reciever()
    {
        return $this->belongsTo(Member::class, 'to', 'id');
    }
}
