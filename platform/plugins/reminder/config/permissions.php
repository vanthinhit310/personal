<?php

return [
    [
        'name' => 'Reminders',
        'flag' => 'reminder.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'reminder.create',
        'parent_flag' => 'reminder.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'reminder.edit',
        'parent_flag' => 'reminder.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'reminder.destroy',
        'parent_flag' => 'reminder.index',
    ],
];
