<?php

namespace Platform\TodoList\Models;

use Platform\Base\Models\BaseModel;
use Platform\Member\Models\Member;

class TodoList extends BaseModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'todo_lists';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'owner',
        'assignTo',
        'deadline',
        'reason_missed_deadline',
        'piority',
        'status',
    ];

    public function owner()
    {
        return $this->belongsTo(Member::class, 'owner', 'id');
    }

    public function assigned()
    {
        return $this->belongsTo(Member::class, 'assignTo', 'id');
    }
}
