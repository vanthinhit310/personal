<?php

return [
    [
        'name' => 'Spending diaries',
        'flag' => 'spending-diary.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'spending-diary.create',
        'parent_flag' => 'spending-diary.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'spending-diary.edit',
        'parent_flag' => 'spending-diary.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'spending-diary.destroy',
        'parent_flag' => 'spending-diary.index',
    ],
];
