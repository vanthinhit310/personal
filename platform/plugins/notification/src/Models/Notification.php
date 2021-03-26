<?php

namespace Platform\Notification\Models;

use Platform\Base\Models\BaseModel;

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
        'schedule',
        'status',
    ];
}
