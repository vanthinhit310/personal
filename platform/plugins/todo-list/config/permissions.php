<?php

return [
    [
        'name' => 'Todo lists',
        'flag' => 'todo-list.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'todo-list.create',
        'parent_flag' => 'todo-list.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'todo-list.edit',
        'parent_flag' => 'todo-list.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'todo-list.destroy',
        'parent_flag' => 'todo-list.index',
    ],
];
