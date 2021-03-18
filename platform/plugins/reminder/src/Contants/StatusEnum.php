<?php
namespace Platform\Reminder\Contants;

use Platform\Base\Supports\Enum;

/**
 * @method static StatusEnum NORMAL()
 * @method static StatusEnum URGENT()
 * @method static StatusEnum COMPLETED()
 * @method static StatusEnum LATE()
 */
class StatusEnum  extends Enum{
    public const NORMAL = 'NORMAL';
    public const URGENT = 'URGENT';
    public const COMPLETED = 'COMPLETED';
    public const LATE = 'LATE';
}
