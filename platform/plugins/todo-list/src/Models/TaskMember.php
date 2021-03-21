<?php

namespace Platform\TodoList\Models;

use Illuminate\Database\Eloquent\Model;
use Platform\Member\Models\Member;

class TaskMember extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'task_members';

    /**
     * @var array
     */
    protected $fillable = [
        'task_id',
        'member_id',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function task()
    {
        return $this->belongsTo(TodoList::class, 'task_id', 'id');
    }
}
