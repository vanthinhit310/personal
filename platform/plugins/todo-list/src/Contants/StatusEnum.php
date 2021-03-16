<?php
namespace Platform\TodoList\Contants;

use Platform\Base\Supports\Enum;

/**
 * @method static StatusEnum COMPLETED()
 * @method static StatusEnum NEW()
 * @method static StatusEnum INPROGRESS()
 * @method static StatusEnum MISSEDDEADLINE()
 */
class StatusEnum  extends Enum{
    public const COMPLETED = 'COMPLETED';
    public const NEW = 'NEW';
    public const INPROGRESS = 'IN PROGRESS';
    public const MISSEDDEADLINE = 'MISSED DEADLINE';
}
