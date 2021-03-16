<?php

namespace Platform\TodoList\Repositories\Caches;

use Platform\Support\Repositories\Caches\CacheAbstractDecorator;
use Platform\TodoList\Repositories\Interfaces\TodoListInterface;

class TodoListCacheDecorator extends CacheAbstractDecorator implements TodoListInterface
{

}
